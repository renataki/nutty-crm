<?php

namespace App\Jobs;

use App\Components\DataComponent;
use App\Repositories\DatabaseAccountRepository;
use App\Repositories\DatabaseLogRepository;
use App\Repositories\NexusPlayerTransactionRepository;
use App\Repositories\ReportUserRepository;
use App\Repositories\ReportWebsiteRepository;
use App\Repositories\UnclaimedDepositRepository;
use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;


class ReportDepositJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $nucode;

    public $websiteId;


    public function __construct($nucode, $websiteId) {

        $this->nucode = $nucode;
        $this->websiteId = $websiteId;

    }


    public function handle() {

        set_time_limit(900);

        $unclaimedDepositByStatus = UnclaimedDepositRepository::findByStatus(true, $this->websiteId);

        $deposits = [];

        foreach($unclaimedDepositByStatus as $value) {

            $databaseAccountById = DatabaseAccountRepository::findOneByUsername($value->username, $this->websiteId);

            if(!empty($databaseAccountById)) {

                $databaseLogByDatabaseId = DatabaseLogRepository::findLastByDatabaseId($databaseAccountById->database["_id"], $this->websiteId);

                if(!empty($databaseLogByDatabaseId)) {

                    $userById = UserRepository::findOneById($databaseLogByDatabaseId->user["_id"]);

                    if(!empty($userById)) {

                        if($userById->type == "Telemarketer" && $value->type == "FirstDeposit") {

                            $deposits = $this->generateDeposit($databaseLogByDatabaseId, $deposits, $value);

                        } else if($userById->type == "CRM" && $value->type == "ReDeposit") {

                            $deposits = $this->generateDeposit($databaseLogByDatabaseId, $deposits, $value);

                        }

                    }

                }

            }

        }

        $totalDeposit = 0;
        $account = null;

        foreach($deposits as $key => $value) {

            $reportUserByDateUserId = ReportUserRepository::findOneByDateUserId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->subDays(1)), $this->nucode, $key);

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

            $reportWebsiteByDateUserId = ReportWebsiteRepository::findOneByDateWebsiteId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->subDays(1)), $this->nucode, $this->websiteId);

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

            }

        }

        Log::debug(json_encode($deposits));

    }


    private function generateDeposit($databaseLog, $deposits, $unclaimedDeposit) {

        $databaseLog->status = "Deposited";
        DatabaseLogRepository::update(DataComponent::initializeSystemAccount(), $databaseLog, $this->websiteId);

        UnclaimedDepositRepository::updateByUsername($unclaimedDeposit->username, ["status" => false], $this->websiteId);
        $nexusPlayerTransactionByReference = NexusPlayerTransactionRepository::findOneByReference($unclaimedDeposit->reference, $this->websiteId);

        if(!empty($nexusPlayerTransactionByReference)) {

            $nexusPlayerTransactionByReference->claim = true;
            $nexusPlayerTransactionByReference->user = $databaseLog->user;
            NexusPlayerTransactionRepository::update(DataComponent::initializeSystemAccount(), $nexusPlayerTransactionByReference, $this->websiteId);

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


}
