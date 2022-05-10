<?php

namespace App\Services;

use App\Components\RestComponent;
use App\Repositories\NexusPlayerTransactionRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;


class ApiNexusService {


    public static function findPlayerTransaction($merchantCode, $fromDate, $toDate, $salt, $url) {

        $timestamp = Carbon::now();
        $parameter = [
            "MerchantCode" => $merchantCode,
            "FromDate" => $fromDate,
            "ToDate" => $toDate,
            "Timestamp" => $timestamp->format("Y-m-d") . "T" . $timestamp->format("H:i:s"),
            "Checksum" => ""
        ];

        $md5 = md5($parameter["FromDate"] . "." . $parameter["ToDate"] . "." . $parameter["Timestamp"] . "." . $salt, true);
        $parameter["Checksum"] = base64_encode($md5);

        return RestComponent::send($url, "/api/v1/report/GetTransaction", "POST", [], $parameter);

    }


    public static function savePlayerTransaction($playerTransactions, $websiteId) {

        if(!empty($playerTransactions)) {

            $insert = [];

            foreach($playerTransactions as $value) {

                $timestamp = new UTCDateTime(Carbon::now());

                array_push($insert, [
                    "adjustment" => [
                        "reference" => $value->adjustmentRefNo
                    ],
                    "amount" => [
                        "final" => intval($value->finalAmount),
                        "request" => intval($value->amount)
                    ],
                    "approved" => [
                        "timestamp" => new UTCDateTime(Carbon::createFromFormat("Y-m-d H:i:s", str_replace("T", " ", $value->approvedDate))),
                        "user" => [
                            "_id" => "0",
                            "username" => $value->approvedBy
                        ]
                    ],
                    "bank" => [
                        "account" => [
                            "from" => [
                                "name" => $value->fromBankAccountName,
                                "number" => $value->fromBankAccountNo
                            ],
                            "to" => [
                                "name" => $value->toBankAccountName,
                                "number" => $value->toBankAccountNo
                            ]
                        ],
                        "from" => $value->bankFrom,
                        "to" => $value->bankTo
                    ],
                    "fee" => [
                        "admin" => intval($value->adminFee)
                    ],
                    "reference" => $value->refNo,
                    "requested" => [
                        "timestamp" => new UTCDateTime(Carbon::createFromFormat("Y-m-d H:i:s", str_replace("T", " ", $value->requestedDate))),
                        "user" => [
                            "_id" => "0",
                            "username" => $value->requestedBy
                        ]
                    ],
                    "transaction" => [
                        "code" => $value->transactionCode,
                        "type" => $value->transactionType
                    ],
                    "username" => $value->username,
                    "created" => [
                        "timestamp" => $timestamp,
                        "user" => [
                            "_id" => "0",
                            "username" => "System"
                        ]
                    ],
                    "modified" => [
                        "timestamp" => $timestamp,
                        "user" => [
                            "_id" => "0",
                            "username" => "System"
                        ]
                    ]
                ]);

                usleep(1000);

            }

            try {

                NexusPlayerTransactionRepository::insertMany($insert, $websiteId);

                Log::info("Nexus player transaction inserted");

            } catch(Exception $exception) {

                if($exception->getCode() == 11000) {

                    Log::error("Nexus player transaction already exist");

                } else {

                    Log::error($exception->getMessage());

                }

            }

        }

    }


}
