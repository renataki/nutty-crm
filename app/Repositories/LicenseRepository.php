<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\License;


class LicenseRepository {


    public static function delete($data) {

        return $data->delete();

    }


    public static function findOneById($id) {

        return License::where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByIdStatus($id, $status) {

        return License::where([
            ["_id", "=", $id],
            ["status", "=", $status]
        ])->first();

    }


    public static function findOneByNucode($nucode) {

        return License::where([
            ["nucode", "=", $nucode]
        ])->first();

    }


    public static function findByStatus($status) {

        return License::where([
            ["status", "=", $status]
        ])->get();

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
