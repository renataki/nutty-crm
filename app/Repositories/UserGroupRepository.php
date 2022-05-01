<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\UserGroup;


class UserGroupRepository {


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByNucode($nucode) {

        return UserGroup::where("nucode", $nucode)->delete();

    }


    public static function findByNucodeStatus($nucode, $status) {

        return UserGroup::where([
            ["nucode", "=", $nucode],
            ["status", "=", $status]
        ])->get();

    }


    public static function findByStatus($status) {

        return UserGroup::where([
            ["status", "=", $status]
        ])->get();

    }


    public static function findOneById($id) {

        return UserGroup::where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByIdStatus($id, $status) {

        return UserGroup::where([
            ["_id", "=", $id],
            ["status", "=", $status]
        ])->first();

    }


    public static function findOneByNameNucode($name, $nucode) {

        return UserGroup::where([
            ["name", "=", $name],
            ["nucode", "=", $nucode]
        ])->first();

    }


    public static function findOneByWebsiteIdsNotWebsiteNames($websiteId, $websiteName) {

        return UserGroup::where([
            ["website.ids", "=", $websiteId],
            ["website.names", "!=", $websiteName]
        ])->first();

    }


    public static function insert($account, $data) {

        $data->created = DataComponent::initializeTimestamp($account);
        $data->modified = $data->created;

        $data->save();

        return $data;

    }


    public static function update($account, $data) {

        if($account != null) {

            $data->modified = DataComponent::initializeTimestamp($account);

        }

        return $data->save();

    }


}
