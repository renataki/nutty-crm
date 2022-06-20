<?php

namespace App\Services;

use App\Components\DataComponent;
use App\Repositories\DatabaseAccountRepository;
use App\Repositories\DatabaseLogRepository;
use App\Repositories\NexusPlayerTransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;


class DatabaseAccountService {


    private static function initializeFirstTransaction($databaseFirstAmount, $databaseFirstTimestamp, $firstAmount, $firstTimestamp) {

        $result = [
            "amount" => $databaseFirstAmount,
            "timestamp" => $databaseFirstTimestamp
        ];

        if(empty($result["amount"]) && empty($result["timestamp"])) {

            $result = [
                "amount" => floatval($firstAmount),
                "timestamp" => $firstTimestamp
            ];

        }

        return $result;

    }


    public static function sync($id, $websiteId) {

        $databaseAccountById = DatabaseAccountRepository::findOneById($id, $websiteId);

        if(!empty($databaseAccountById)) {

            $nexusPlayerTransaction = NexusPlayerTransactionRepository::findPlayerTransaction("D", $databaseAccountById->username, $websiteId);

            if(!$nexusPlayerTransaction->isEmpty()) {

                $lastIndex = count($nexusPlayerTransaction) - 1;

                $databaseAccountById->deposit = [
                    "average" => [
                        "amount" => floatval($nexusPlayerTransaction->avg("amount.request"))
                    ],
                    "first" => [
                        "amount" => floatval($nexusPlayerTransaction[0]->amount["request"]),
                        "timestamp" => $nexusPlayerTransaction[0]->requested["timestamp"]
                    ],
                    "last" => [
                        "amount" => floatval($nexusPlayerTransaction[$lastIndex]->amount["request"]),
                        "timestamp" => $nexusPlayerTransaction[$lastIndex]->requested["timestamp"]
                    ],
                    "total" => [
                        "amount" => floatval($nexusPlayerTransaction->sum("amount.request")),
                        "time" => count($nexusPlayerTransaction)
                    ]
                ];
                DatabaseAccountRepository::update(DataComponent::initializeSystemAccount(), $databaseAccountById, $websiteId);

            }

            $nexusPlayerTransaction = NexusPlayerTransactionRepository::findPlayerTransaction("W", $databaseAccountById->username, $websiteId);

            if(!$nexusPlayerTransaction->isEmpty()) {

                $lastIndex = count($nexusPlayerTransaction) - 1;

                $databaseAccountById->withdrawal = [
                    "average" => [
                        "amount" => floatval($nexusPlayerTransaction->avg("amount.request"))
                    ],
                    "first" => [
                        "amount" => floatval($nexusPlayerTransaction[0]->amount["request"]),
                        "timestamp" => $nexusPlayerTransaction[0]->requested["timestamp"]
                    ],
                    "last" => [
                        "amount" => floatval($nexusPlayerTransaction[$lastIndex]->amount["request"]),
                        "timestamp" => $nexusPlayerTransaction[$lastIndex]->requested["timestamp"]
                    ],
                    "total" => [
                        "amount" => floatval($nexusPlayerTransaction->sum("amount.request")),
                        "time" => count($nexusPlayerTransaction)
                    ]
                ];
                DatabaseAccountRepository::update(DataComponent::initializeSystemAccount(), $databaseAccountById, $websiteId);

            }

        }

    }


    public static function update($id, $websiteId) {

        $databaseAccountById = DatabaseAccountRepository::findOneById($id, $websiteId);

        if(!empty($databaseAccountById)) {

            $nexusPlayerTransactionToday = NexusPlayerTransactionRepository::findPendingPlayerTransaction(new UTCDateTime(Carbon::now()->subDays(30)->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)), "D", $databaseAccountById->username, $websiteId);
            $deposit = [];
            $lastTransaction = null;

            if(!$nexusPlayerTransactionToday->isEmpty()) {

                $depositFirst = self::initializeFirstTransaction($databaseAccountById->deposit["first"]["amount"], $databaseAccountById->deposit["first"]["timestamp"], $nexusPlayerTransactionToday[0]->amount["request"], $nexusPlayerTransactionToday[0]->requested["timestamp"]);
                $totalAmount = $nexusPlayerTransactionToday->sum("amount.request");
                $lastIndex = count($nexusPlayerTransactionToday) - 1;
                $lastTransaction = $nexusPlayerTransactionToday[$lastIndex];

                $deposit = [
                    "average" => [
                        "amount" => 0.00
                    ],
                    "first" => [
                        "amount" => $depositFirst["amount"],
                        "timestamp" => $depositFirst["timestamp"]
                    ],
                    "last" => [
                        "amount" => $nexusPlayerTransactionToday[$lastIndex]->amount["request"],
                        "timestamp" => $nexusPlayerTransactionToday[$lastIndex]->requested["timestamp"]
                    ],
                    "total" => [
                        "amount" => $databaseAccountById->deposit["total"]["amount"] + $totalAmount,
                        "time" => $databaseAccountById->deposit["total"]["time"] + count($nexusPlayerTransactionToday)
                    ]
                ];
                $deposit["average"]["amount"] = floatval($deposit["total"]["amount"] / $deposit["total"]["time"]);

                $databaseLogByDatabaseId = DatabaseLogRepository::findLastByDatabaseId($databaseAccountById->database["_id"], $websiteId);

                if(!empty($databaseLogByDatabaseId)) {

                    $databaseLogByDatabaseId->status = "Deposited";
                    DatabaseLogRepository::update(DataComponent::initializeSystemAccount(), $databaseLogByDatabaseId, $websiteId);

                    $websiteById = WebsiteRepository::findOneById($websiteId);
                    $account = UserRepository::findOneById($databaseLogByDatabaseId->user["_id"]);
                    WorksheetService::generateReport($account, new UTCDateTime(Carbon::now()->subDays(1)->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)), "Deposited", $websiteById);

                    NexusPlayerTransactionRepository::updateClaimById(true, $nexusPlayerTransactionToday[0]->_id, $websiteId);

                }

            }

            $nexusPlayerTransactionToday = NexusPlayerTransactionRepository::findPendingPlayerTransaction(new UTCDateTime(Carbon::now()->subDays(1)->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)), "W", $databaseAccountById->username, $websiteId);
            $withdrawal = [];

            if(!$nexusPlayerTransactionToday->isEmpty()) {

                $withdrawalFirst = self::initializeFirstTransaction($databaseAccountById->withdrawal["first"]["amount"], $databaseAccountById->withdrawal["first"]["timestamp"], $nexusPlayerTransactionToday[0]->amount["request"], $nexusPlayerTransactionToday[0]->requested["timestamp"]);
                $lastIndex = count($nexusPlayerTransactionToday) - 1;

                $dateDeposit = Carbon::createFromDate($lastTransaction->created["timestamp"]->toDateTime());
                $dateWithdrawal = Carbon::createFromDate($nexusPlayerTransactionToday[$lastIndex]->created["timestamp"]->toDateTime());

                if($dateWithdrawal->gt($dateDeposit)) {

                    $lastTransaction = $nexusPlayerTransactionToday[$lastIndex];

                }

                $withdrawal = [
                    "average" => [
                        "amount" => 0.00
                    ],
                    "first" => [
                        "amount" => $withdrawalFirst["amount"],
                        "timestamp" => $withdrawalFirst["timestamp"]
                    ],
                    "last" => [
                        "amount" => $nexusPlayerTransactionToday[$lastIndex]->amount["request"],
                        "timestamp" => $nexusPlayerTransactionToday[$lastIndex]->requested["timestamp"]
                    ],
                    "total" => [
                        "amount" => $databaseAccountById->withdrawal["total"]["amount"] + $nexusPlayerTransactionToday->sum("amount.request"),
                        "time" => $databaseAccountById->withdrawal["total"]["time"] + count($nexusPlayerTransactionToday)
                    ]
                ];
                $withdrawal["average"]["amount"] = floatval($withdrawal["total"]["amount"] / $withdrawal["total"]["time"]);

            }

            if(!empty($lastTransaction)) {

                $databaseAccountById->sync = [
                    "_id" => DataComponent::initializeObjectId($lastTransaction->_id),
                    "timestamp" => $lastTransaction->created["timestamp"]
                ];

            }

            $databaseAccountById->deposit = $deposit;
            $databaseAccountById->withdrawal = $withdrawal;
            DatabaseAccountRepository::update(DataComponent::initializeSystemAccount(), $databaseAccountById, $websiteId);

        }

    }


}
