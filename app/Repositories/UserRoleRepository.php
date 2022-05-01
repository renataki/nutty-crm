<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\UserRole;


class UserRoleRepository {


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByNucode($nucode) {

        return UserRole::where("nucode", $nucode)->delete();

    }


    public static function findByNucodeStatus($nucode, $status) {

        return UserRole::where([
            ["nucode", "=", $nucode],
            ["status", "=", $status]
        ])->get();

    }


    public static function findByStatus($status) {

        return UserRole::where([
            ["status", "=", $status]
        ])->get();

    }


    public static function findOneById($id) {

        return UserRole::where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByIdStatus($id, $status) {

        return UserRole::where([
            ["_id", "=", $id],
            ["status", "=", $status]
        ])->first();

    }


    public static function findOneByNameNucode($name, $nucode) {

        return UserRole::where([
            ["name", "=", $name],
            ["nucode", "=", $nucode]
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
