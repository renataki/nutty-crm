<?php

namespace App\Jobs;

use App\Repositories\DatabaseAccountRepository;
use App\Repositories\DatabaseLogRepository;
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

        $usernames = UnclaimedDepositRepository::findUsernameByStatus(true, $this->websiteId);
        $databaseIds = DatabaseAccountRepository::findDatabaseIdInUsername($usernames, $this->websiteId);

        $update = [
            "status" => "Deposited"
        ];
        DatabaseLogRepository::updateInDatabaseId($databaseIds, $update, $this->websiteId);

        $update = [
            "status" => false
        ];
        UnclaimedDepositRepository::updateByUsername($usernames, $update, $this->websiteId);

        $userIds = DatabaseLogRepository::findUserIdByStatusInDatabaseId($databaseIds, "Deposited", $this->websiteId);
        $deposits = [];

        foreach($userIds as $value) {

            if(array_key_exists(strval($value), $deposits)) {

                $deposits[strval($value)] += 1;

            } else {

                $deposits[strval($value)] = 1;

            }

        }

        Log::debug("Deposit for " . $this->websiteId . " " . json_encode($deposits));
        $totalDeposit = 0;
        $account = null;

        foreach($deposits as $key => $value) {

            $reportUserByDateUserId = ReportUserRepository::findOneByDateUserId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->subDays(1)), $this->nucode, $key);

            if(!empty($reportUserByDateUserId)) {

                $statusNames = $reportUserByDateUserId->status["names"];
                $statusTotals = $reportUserByDateUserId->status["totals"];

                $index = array_search("Deposited", $statusNames);

                if(gettype($index) == "integer") {

                    $statusTotals[$index] += $value;

                } else {

                    array_push($statusNames, "Deposited");
                    array_push($statusTotals, $value);

                }

                $account = UserRepository::findOneById($key);

                if(!empty($account)) {

                    Log::debug("Report update for " . $reportUserByDateUserId->_id . " " . $value);
                    $reportUserByDateUserId->status = [
                        "names" => $statusNames,
                        "totals" => $statusTotals
                    ];
                    ReportUserRepository::update($account, $reportUserByDateUserId);

                }

            }

            $totalDeposit += $value;

        }

        if(!empty($account)) {

            $reportWebsiteByDateUserId = ReportWebsiteRepository::findOneByDateWebsiteId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->subDays(1)), $this->nucode, $this->websiteId);

            if(!empty($reportWebsiteByDateUserId)) {

                $statusNames = $reportWebsiteByDateUserId->status["names"];
                $statusTotals = $reportWebsiteByDateUserId->status["totals"];

                $index = array_search("Deposited", $statusNames);

                if(gettype($index) == "integer") {

                    $statusTotals[$index] += $value;

                } else {

                    array_push($statusNames, "Deposited");
                    array_push($statusTotals, $value);

                }

                $reportWebsiteByDateUserId->status = [
                    "names" => $statusNames,
                    "totals" => $statusTotals
                ];
                ReportWebsiteRepository::update($account, $reportWebsiteByDateUserId);

            }

        }

    }


}
