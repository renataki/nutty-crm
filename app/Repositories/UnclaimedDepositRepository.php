<?php

namespace App\Repositories;

use App\Models\UnclaimedDeposit;


class UnclaimedDepositRepository {


    public static function findUsernameByStatus($status, $websiteId) {

        $unclaimedDeposit = new UnclaimedDeposit();
        $unclaimedDeposit->setTable("unclaimedDeposit_" . $websiteId);

        return $unclaimedDeposit->where([
            ["status", "=", $status]
        ])->pluck("username")->toArray();

    }


    public static function insertMany($data, $websiteId) {

        $unclaimedDeposit = new UnclaimedDeposit();
        $unclaimedDeposit->setTable("unclaimedDeposit_" . $websiteId);
        $unclaimedDeposit->insert($data);

    }


    public static function updateByUsername($usernames, $data, $websiteId) {

        $unclaimedDeposit = new UnclaimedDeposit();
        $unclaimedDeposit->setTable("unclaimedDeposit_" . $websiteId);
        $unclaimedDeposit->whereIn("username", $usernames)->update($data, ["upsert" => false]);

    }


}
