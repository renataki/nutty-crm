<?php

namespace App\Repositories;

use App\Models\UnclaimedDeposit;


class UnclaimedDepositRepository {


    public static function findByStatus($status, $websiteId) {

        $unclaimedDeposit = new UnclaimedDeposit();
        $unclaimedDeposit->setTable("unclaimedDeposit_" . $websiteId);

        return $unclaimedDeposit->where([
            ["status", "=", $status]
        ])->get();

    }


    public static function insertMany($data, $websiteId) {

        $unclaimedDeposit = new UnclaimedDeposit();
        $unclaimedDeposit->setTable("unclaimedDeposit_" . $websiteId);
        $unclaimedDeposit->insert($data);

    }


    public static function updateByUsername($username, $data, $websiteId) {

        $unclaimedDeposit = new UnclaimedDeposit();
        $unclaimedDeposit->setTable("unclaimedDeposit_" . $websiteId);
        $unclaimedDeposit->where([
            ["username", "=", $username]
        ])->update($data, ["upsert" => false]);

    }


}
