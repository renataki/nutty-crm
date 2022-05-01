<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\UserLog;


class UserLogRepository {


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByNucode($nucode) {

        return UserLog::where("nucode", $nucode)->delete();

    }


    public static function findOneByAuthentication($authentication) {

        return UserLog::where([
            ["authentication", "=", $authentication]
        ])->orderBy("created.timestamp", "DESC")->first();

    }


    public static function findOneByAuthenticationInType($authentication, $types) {

        return UserLog::where([
            ["authentication", "=", $authentication]
        ])->whereIn("type", $types)->orderBy("created.timestamp", "DESC")->first();

    }


    public static function findOneByUserIdInType($userId, $types) {

        return UserLog::where([
            ["user._id", "=", $userId]
        ])->whereIn("type", $types)->orderBy("created.timestamp", "DESC")->first();

    }


    public static function insert($account, $data) {

        $data->created = DataComponent::initializeTimestamp($account);
        $data->modified = $data->created;

        $data->save();

        return $data;

    }


}
