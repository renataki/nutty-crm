<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\User;


class UserRepository {


    public static function countByNucode($nucode) {

        return User::where([
            ["nucode", "=", $nucode]
        ])->count();

    }


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByNucode($nucode) {

        return User::where("nucode", $nucode)->delete();

    }


    public static function findByNucode($nucode) {

        return User::where([
            ["nucode", "=", $nucode]
        ])->get();

    }


    public static function findOneByContactEmail($contactEmail) {

        return User::where([
            ["contact.email", "=", $contactEmail]
        ])->first();

    }


    public static function findOneById($id) {

        return User::where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByIdStatus($id, $status) {

        return User::where([
            ["_id", "=", $id],
            ["status", "=", $status]
        ])->first();

    }


    public static function findOneByNucodeUsername($nucode, $username) {

        return User::where([
            ["nucode", "=", $nucode],
            ["username", "=", $username]
        ])->first();

    }


    public static function findOneByUsername($username) {

        return User::where([
            ["username", "=", $username]
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


    public static function updateByGroupId($groupId, $data) {

        User::where("group._id", $groupId)->update($data, ["upsert" => false]);

    }


    public static function updateByRoleId($roleId, $data) {

        User::where("role._id", $roleId)->update($data, ["upsert" => false]);

    }


}
