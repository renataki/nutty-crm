<?php

namespace App\Services;

use App\Components\DataComponent;
use App\Jobs\DatabaseAccountSyncJob;
use App\Jobs\DeleteUnclaimedDepositJob;
use App\Jobs\PlayerTransactionJob;
use App\Jobs\PlayerTransactionSyncJob;
use App\Jobs\ReportDepositJob;
use App\Models\UnclaimedDepositQueue;
use App\Repositories\DatabaseAccountRepository;
use App\Repositories\DatabaseLogRepository;
use App\Repositories\NexusPlayerTransactionRepository;
use App\Repositories\ReportUserRepository;
use App\Repositories\ReportWebsiteRepository;
use App\Repositories\SyncQueueRepository;
use App\Repositories\UnclaimedDepositQueueRepository;
use App\Repositories\UnclaimedDepositRepository;
use App\Repositories\UserRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;
use stdClass;


class SystemService {


    public static function deleteUnclaimedDeposit() {

        $result = new stdClass();
        $result->response = "Failed to find player transaction";
        $result->result = false;

        $websites = WebsiteRepository::findAll();

        $delay = Carbon::now();

        foreach($websites as $value) {

            dispatch((new DeleteUnclaimedDepositJob($value->_id)))->delay($delay->addMinutes(config("app.api.nexus.batch.delay")));

        }

    }


    private static function generateDeposit($databaseLog, $deposits, $unclaimedDeposit, $websiteId) {

        $databaseLog->status = "Deposited";
        DatabaseLogRepository::update(DataComponent::initializeSystemAccount(), $databaseLog, $websiteId);

        UnclaimedDepositRepository::updateByUsername($unclaimedDeposit->username, ["status" => false], $websiteId);
        $nexusPlayerTransactionByReference = NexusPlayerTransactionRepository::findOneByReference($unclaimedDeposit->reference, $websiteId);

        if(!empty($nexusPlayerTransactionByReference)) {

            $nexusPlayerTransactionByReference->claim = true;
            $nexusPlayerTransactionByReference->user = $databaseLog->user;
            NexusPlayerTransactionRepository::update(DataComponent::initializeSystemAccount(), $nexusPlayerTransactionByReference, $websiteId);

        }

        if(array_key_exists(strval($databaseLog->user["_id"]), $deposits)) {

            $deposits[strval($databaseLog->user["_id"])]["total"] += 1;
            array_push($deposits[strval($databaseLog->user["_id"])]["reference"], $nexusPlayerTransactionByReference->reference);

        } else {

            $deposits[strval($databaseLog->user["_id"])] = [
                "reference" => [$nexusPlayerTransactionByReference->reference],
                "total" => 1,
                "username" => $databaseLog->user["username"]
            ];

        }

        return $deposits;

    }


    public static function generateDepositReport() {

        $result = new stdClass();
        $result->response = "Failed to generate deposit report";
        $result->result = false;

        $unclaimedDepositQueueByStatus = UnclaimedDepositQueueRepository::findOneByStatus("Pending");

        if(!empty($unclaimedDepositQueueByStatus)) {

            $websiteById = WebsiteRepository::findOneById($unclaimedDepositQueueByStatus->website["_id"]);

            if(!empty($websiteById)) {

                if(!empty($websiteById->api["nexus"]["code"]) && !empty($websiteById->api["nexus"]["salt"]) && !empty($websiteById->api["nexus"]["url"])) {

                    $fromDate = $unclaimedDepositQueueByStatus->date . "T00:00:00";
                    $toDate = Carbon::createFromFormat("Y-m-d", $unclaimedDepositQueueByStatus->date)->addDays(1)->format("Y-m-d") . "T00:00:00";
                    $apiNexusPlayerTransaction = ApiNexusService::findPlayerTransaction($websiteById->api["nexus"]["code"], $fromDate, $toDate, $websiteById->api["nexus"]["salt"], $websiteById->api["nexus"]["url"]);

                    if($apiNexusPlayerTransaction->result) {

                        if($apiNexusPlayerTransaction->content->errorCode == 0) {

                            ApiNexusService::savePlayerTransaction($apiNexusPlayerTransaction->content->data->bankTransactionList, $websiteById->_id);

                            $unclaimedDepositQueueByStatus->status = "TransactionSaved";
                            UnclaimedDepositQueueRepository::update(DataComponent::initializeSystemAccount(), $unclaimedDepositQueueByStatus);

                        }

                    }

                }

            }

        } else {

            $unclaimedDepositQueueByStatus = UnclaimedDepositQueueRepository::findOneByStatus("TransactionSaved");

            if(!empty($unclaimedDepositQueueByStatus)) {

                $unclaimedDepositByStatus = UnclaimedDepositRepository::findByStatusLimit(true, $unclaimedDepositQueueByStatus->website["_id"], 300);

                $deposits = [];

                if(!$unclaimedDepositByStatus->isEmpty()) {

                    foreach($unclaimedDepositByStatus as $value) {

                        $databaseAccountByUsername = DatabaseAccountRepository::findOneByUsername($value->username, $unclaimedDepositQueueByStatus->website["_id"]);

                        if(!empty($databaseAccountByUsername)) {

                            $databaseLogByDatabaseId = DatabaseLogRepository::findLastByDatabaseId($databaseAccountByUsername->database["_id"], $unclaimedDepositQueueByStatus->website["_id"]);

                            if(!empty($databaseLogByDatabaseId)) {

                                $userById = UserRepository::findOneById($databaseLogByDatabaseId->user["_id"]);

                                if(!empty($userById)) {

                                    if($userById->type == "Telemarketer" && $value->type == "FirstDeposit") {

                                        $deposits = self::generateDeposit($databaseLogByDatabaseId, $deposits, $value, $unclaimedDepositQueueByStatus->website["_id"]);

                                    } else if($userById->type == "CRM" && $value->type == "ReDeposit") {

                                        $deposits = self::generateDeposit($databaseLogByDatabaseId, $deposits, $value, $unclaimedDepositQueueByStatus->website["_id"]);

                                    }

                                }

                            }

                        }

                        $unclaimedDepositById = UnclaimedDepositRepository::findOneById($value->_id, $unclaimedDepositQueueByStatus->website["_id"]);

                        if(!empty($unclaimedDepositById)) {

                            $unclaimedDepositById->status = false;
                            UnclaimedDepositRepository::update(DataComponent::initializeSystemAccount(), $unclaimedDepositById, $unclaimedDepositQueueByStatus->website["_id"]);

                        }

                    }

                    $totalDeposit = 0;
                    $account = null;

                    foreach($deposits as $key => $value) {

                        $reportUserByDateUserId = ReportUserRepository::findOneByDateUserId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->subDays(1)), $unclaimedDepositQueueByStatus->nucode, $key);

                        if(!empty($reportUserByDateUserId)) {

                            $statusNames = $reportUserByDateUserId->status["names"];
                            $statusTotals = $reportUserByDateUserId->status["totals"];

                            $index = array_search("Deposited", $statusNames);

                            if(gettype($index) == "integer") {

                                $statusTotals[$index] = $statusTotals[$index] + $value["total"];

                            } else {

                                array_push($statusNames, "Deposited");
                                array_push($statusTotals, $value["total"]);

                            }

                            $account = UserRepository::findOneById($key);

                            if(!empty($account)) {

                                $reportUserByDateUserId->status = [
                                    "names" => $statusNames,
                                    "totals" => $statusTotals
                                ];
                                ReportUserRepository::update($account, $reportUserByDateUserId);

                            }

                        }

                        $totalDeposit += $value["total"];

                    }

                    if(!empty($account)) {

                        $reportWebsiteByDateUserId = ReportWebsiteRepository::findOneByDateWebsiteId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->subDays(1)), $unclaimedDepositQueueByStatus->nucode, $unclaimedDepositQueueByStatus->website["_id"]);

                        if(!empty($reportWebsiteByDateUserId)) {

                            $statusNames = $reportWebsiteByDateUserId->status["names"];
                            $statusTotals = $reportWebsiteByDateUserId->status["totals"];

                            $index = array_search("Deposited", $statusNames);

                            if(gettype($index) == "integer") {

                                $statusTotals[$index] += $totalDeposit;

                            } else {

                                array_push($statusNames, "Deposited");
                                array_push($statusTotals, $totalDeposit);

                            }

                            $reportWebsiteByDateUserId->status = [
                                "names" => $statusNames,
                                "totals" => $statusTotals
                            ];
                            ReportWebsiteRepository::update($account, $reportWebsiteByDateUserId);

                            Log::debug("Deposit report updated");

                        }

                    }

                } else {

                    $unclaimedDepositQueueByStatus->status = "Done";
                    UnclaimedDepositQueueRepository::update(DataComponent::initializeSystemAccount(), $unclaimedDepositQueueByStatus);

                }

                Log::debug(json_encode($deposits));

            }

        }

        return $result;

    }


    public static function generateUnclaimedDepositQueue($date) {

        $result = new stdClass();
        $result->response = "Failed to generate unclaimed deposit queue";
        $result->result = false;
        $result->total = 0;

        $websiteByStatusNotApiNexusSaltStart = WebsiteRepository::findBySyncNotApiNexusSaltStart("", "", "Synced");

        if(!$websiteByStatusNotApiNexusSaltStart->isEmpty()) {

            foreach($websiteByStatusNotApiNexusSaltStart as $value) {

                $unclaimedDepositQueue = new UnclaimedDepositQueue();
                $unclaimedDepositQueue->date = Carbon::createFromFormat("Y-m-d", $date)->subDays(1)->format("Y-m-d");
                $unclaimedDepositQueue->nucode = $value->nucode;
                $unclaimedDepositQueue->status = "Pending";
                $unclaimedDepositQueue->website = [
                    "_id" => DataComponent::initializeObjectId($value->_id),
                    "name" => $value->name
                ];
                UnclaimedDepositQueueRepository::insert(DataComponent::initializeSystemAccount(), $unclaimedDepositQueue);

                $result->total++;

                usleep(1000);

            }

        }

        $result->response = "Unclaimed deposit queue generated";
        $result->result = true;

        return $result;

    }


    public static function syncWebsiteTransaction() {

        $result = new stdClass();
        $result->response = "Failed to sync website transaction";
        $result->result = false;

        $syncQueueByStatus = SyncQueueRepository::findOneByStatus("OnGoing");

        if(!empty($syncQueueByStatus)) {

            $websiteById = WebsiteRepository::findOneById($syncQueueByStatus->website["_id"]);

            if(!empty($websiteById)) {

                if(!empty($websiteById->api["nexus"]["code"]) && !empty($websiteById->api["nexus"]["salt"]) && !empty($websiteById->api["nexus"]["url"])) {

                    $date = Carbon::createFromDate($syncQueueByStatus->date->toDateTime());
                    $dateStart = $date->format("Y-m-d") . "T00:00:00";
                    $date = $date->addDays(1);
                    $dateEnd = $date->format("Y-m-d") . "T00:00:00";
                    $apiNexusPlayerTransaction = ApiNexusService::findPlayerTransaction($websiteById->api["nexus"]["code"], $dateStart, $dateEnd, $websiteById->api["nexus"]["salt"], $websiteById->api["nexus"]["url"]);

                    if($apiNexusPlayerTransaction->result) {

                        ApiNexusService::savePlayerTransaction($apiNexusPlayerTransaction->content->data->bankTransactionList, $websiteById->_id);

                        $syncQueueByStatus->date = new UTCDateTime($date);
                        SyncQueueRepository::update(DataComponent::initializeSystemAccount(), $syncQueueByStatus);

                        if($date->gte(Carbon::now())) {

                            $websiteById->sync = "Sync";
                            WebsiteRepository::update(DataComponent::initializeSystemAccount(), $websiteById);

                        }

                    }

                }

            }

            $result->response = "Player transaction synced";
            $result->result = true;

        }

        return $result;

    }


}
