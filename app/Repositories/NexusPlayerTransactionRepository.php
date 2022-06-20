<?php

namespace App\Repositories;

use App\Models\NexusPlayerTransaction;


class NexusPlayerTransactionRepository {


    public static function findPlayerTransaction($referencePrefix, $username, $websiteId) {

        $nexusPlayerTransaction = new NexusPlayerTransaction();
        $nexusPlayerTransaction->setTable("nexusPlayerTransaction_" . $websiteId);

        return $nexusPlayerTransaction->where([
            ["reference", "LIKE", $referencePrefix . "%"],
            ["username", "=", $username]
        ])->orderBy("approved.timestamp", "ASC")->get(["amount.request", "requested.timestamp"]);

    }


    public static function findPendingPlayerTransaction($createdTimestamp, $referencePrefix, $username, $websiteId) {

        $nexusPlayerTransaction = new NexusPlayerTransaction();
        $nexusPlayerTransaction->setTable("nexusPlayerTransaction_" . $websiteId);

        return $nexusPlayerTransaction->where([
            ["created.timestamp", ">", $createdTimestamp],
            ["reference", "LIKE", $referencePrefix . "%"],
            ["username", "LIKE", $username]
        ])->whereNull("claim")->orderBy("approved.timestamp", "ASC")->get(["amount.request", "requested.timestamp", "created.timestamp"]);

    }


    public static function insertMany($data, $websiteId) {

        $nexusPlayerTransaction = new NexusPlayerTransaction();
        $nexusPlayerTransaction->setTable("nexusPlayerTransaction_" . $websiteId);
        $nexusPlayerTransaction->insert($data);

    }


    public static function updateClaimById($claim, $id, $websiteId) {

        $nexusPlayerTransaction = new NexusPlayerTransaction();
        $nexusPlayerTransaction->setTable("nexusPlayerTransaction_" . $websiteId);
        $nexusPlayerTransaction->where("_id", $id)->update(["claim" => $claim], ["upsert" => false]);

    }


}
