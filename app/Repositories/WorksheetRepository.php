<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\Database;


class WorksheetRepository {


    public static function findDatabaseCrm($crmId, $nucode, $websiteId) {

        $database = new Database();
        $database->setTable("database_" . $websiteId);

        return $database->raw(function($collection) use ($crmId, $nucode, $websiteId) {

            return $collection->aggregate([
                [
                    '$lookup' => [
                        "from" => "databaseAttempt_" . $nucode,
                        "localField" => "_id",
                        "foreignField" => "database._id",
                        "as" => "attempt"
                    ]
                ],
                [
                    '$match' => [
                        "crm._id" => DataComponent::initializeObjectId($crmId)
                    ]
                ],
                [
                    '$match' => [
                        "attempt.website.ids" => [
                            '$ne' => DataComponent::initializeObjectId($websiteId)
                        ]
                    ]
                ],
                [
                    '$sort' => [
                        "created.timestamp" => 1
                    ]
                ],
                [
                    '$limit' => 1
                ]
            ], ["allowDiskUse" => true]);

        });

    }


}
