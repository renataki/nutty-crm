<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\ReportUser;
use MongoDB\BSON\Regex;


class ReportUserRepository {


    public static function countByUserIdBetweenDate($endDate, $nucode, $startDate, $userId) {

        $reportUser = new ReportUser();
        $reportUser->setTable("reportUser_" . $nucode);

        return $reportUser->where([
            ["date", ">=", $startDate],
            ["date", "<=", $endDate],
            ["user._id", "=", $userId]
        ])->count("_id");

    }


    public static function delete($id) {

        ReportUser::find($id)->delete();

    }


    public static function findOneByDateUserId($date, $nucode, $userId) {

        $reportUser = new ReportUser();
        $reportUser->setTable("reportUser_" . $nucode);

        return $reportUser->where([
            ["date", "=", $date],
            ["user._id", "=", $userId]
        ])->first();

    }


    public static function findOneByUserId($nucode, $userId) {

        $reportUser = new ReportUser();
        $reportUser->setTable("reportUser_" . $nucode);

        return $reportUser->where([
            ["user._id", "=", $userId]
        ])->first();

    }


    public static function findByUserIdBetweenDate($endDate, $length, $nucode, $page, $startDate, $userId) {

        $reportUser = new ReportUser();
        $reportUser->setTable("reportUser_" . $nucode);

        return $reportUser->where([
            ["date", ">=", $startDate],
            ["date", "<=", $endDate],
            ["user._id", "=", $userId]
        ])->forPage($page, $length)->get();

    }


    public static function findUserTable($date, $name, $nucode, $username) {

        $reportUser = new ReportUser();
        $reportUser->setTable("reportUser_" . $nucode);

        return $reportUser->raw(function($collection) use ($date, $name, $nucode, $username) {

            $query = DataComponent::initializeReportFilterDateRange($date, []);

            if(!is_null($name)) {

                array_push($query, [
                    '$match' => [
                        "user.name" => new Regex($name)
                    ]
                ]);

            }

            if(!is_null($username)) {

                array_push($query, [
                    '$match' => [
                        "user.username" => new Regex($username)
                    ]
                ]);

            }

            array_push($query, [
                '$group' => [
                    "_id" => '$user._id',
                    "date" => [
                        '$push' => '$date'
                    ],
                    "status" => [
                        '$push' => '$status'
                    ],
                    "total" => [
                        '$sum' => '$total'
                    ],
                    "user" => [
                        '$push' => '$user'
                    ],
                    "website" => [
                        '$push' => '$website'
                    ]
                ]
            ]);

            return $collection->aggregate($query, ["allowDiskUse" => true]);

        });

    }


    public static function insert($account, $data) {

        $data->created = DataComponent::initializeTimestamp($account);
        $data->modified = $data->created;

        $data->setTable("reportUser_" . $account->nucode);

        $data->save();

        return $data;

    }


    public static function update($account, $data) {

        if($account != null) {

            $data->modified = DataComponent::initializeTimestamp($account);

        }

        $data->setTable("reportUser_" . $account->nucode);

        return $data->save();

    }


}
