<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\DatabaseAccount;


class DatabaseAccountRepository {


    public static function count($websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([])->count("_id");

    }


    public static function countCrmTable($endDepositLastTimestamp, $limit, $startDepositLastTimestamp, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->raw(function($collection) use ($endDepositLastTimestamp, $limit, $startDepositLastTimestamp, $websiteId) {

            $query = [
                [
                    '$lookup' => [
                        "from" => "database_" . $websiteId,
                        "localField" => "database._id",
                        "foreignField" => "_id",
                        "pipeline" => [],
                        "as" => "database"
                    ]
                ]
            ];

            if($endDepositLastTimestamp != null && $startDepositLastTimestamp != null) {

                array_push($query, [
                    '$match' => [
                        "deposit.last.timestamp" => [
                            '$gte' => $startDepositLastTimestamp,
                            '$lte' => $endDepositLastTimestamp
                        ]
                    ]
                ]);

            }

            array_push($query, [
                '$limit' => $limit
            ]);

            array_push($query, [
                '$count' => "count"
            ]);

            return $collection->aggregate($query, ["allowDiskUse" => true]);

        });

    }


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByDatabaseId($databaseId, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["database._id", "=", $databaseId]
        ])->delete();

    }


    public static function findCrmTable($endDepositLastTimestamp, $limit, $sorts, $start, $startDepositLastTimestamp, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->raw(function($collection) use ($endDepositLastTimestamp, $limit, $sorts, $start, $startDepositLastTimestamp, $websiteId) {

            $query = [
                [
                    '$lookup' => [
                        "from" => "database_" . $websiteId,
                        "localField" => "database._id",
                        "foreignField" => "_id",
                        "pipeline" => [],
                        "as" => "database"
                    ]
                ],
                [
                    '$addFields' => [
                        "website" => [
                            "_id" => $websiteId
                        ]
                    ]
                ]
            ];

            if($endDepositLastTimestamp != null && $startDepositLastTimestamp != null) {

                array_push($query, [
                    '$match' => [
                        "deposit.last.timestamp" => [
                            '$gte' => $startDepositLastTimestamp,
                            '$lte' => $endDepositLastTimestamp
                        ]
                    ]
                ]);

            }

            foreach($sorts as $sort) {

                array_push($query, [
                    '$sort' => [
                        $sort["field"] => $sort["direction"]
                    ]
                ]);

            }

            array_push($query, [
                '$skip' => $start
            ]);

            array_push($query, [
                '$limit' => $limit
            ]);

            return $collection->aggregate($query, ["allowDiskUse" => true]);

        });

    }


    public static function findOneByDatabaseId($databaseId, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["database._id", "=", $databaseId]
        ])->first();

    }


    public static function findOneById($id, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByUsername($username, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["username", "=", $username]
        ])->first();

    }


    public static function findOneByUsernameNotDatabaseId($databaseId, $username, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["database._id", "!=", $databaseId],
            ["username", "=", $username]
        ])->first();

    }


    public static function insert($account, $data, $websiteId) {

        $data->created = DataComponent::initializeTimestamp($account);
        $data->modified = $data->created;

        $data->setTable("databaseAccount_" . $websiteId);

        $data->save();

        return $data;

    }


    public static function update($account, $data, $websiteId) {

        if($account != null) {

            $data->modified = DataComponent::initializeTimestamp($account);

        }

        $data->setTable("databaseAccount_" . $websiteId);

        return $data->save();

    }


}
