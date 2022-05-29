<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\Website;


class WebsiteRepository {


    public static function count() {

        return Website::where([])->count("_id");

    }


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByNucode($nucode) {

        return Website::where("nucode", $nucode)->delete();

    }


    public static function findAll() {

        return Website::where([])->get();

    }


    public static function findByNucode($nucode) {

        return Website::where([
            ["nucode", "=", $nucode]
        ])->get();

    }


    public static function findByNucodeStatus($nucode, $status) {

        return Website::where([
            ["nucode", "=", $nucode],
            ["status", "=", $status]
        ])->get();

    }


    public static function findByStatus($status) {

        return Website::where([
            ["status", "=", $status]
        ])->get();

    }


    public static function findIdAll() {

        return Website::where([])->pluck("_id")->toArray();

    }


    public static function findInId($ids) {

        return Website::whereIn("_id", $ids)->get();

    }


    public static function findBySyncNotApiNexusSaltStart($apiNexusSalt, $start, $sync) {

        return Website::where([
            ["api.nexus.salt", "!=", $apiNexusSalt],
            ["start", "!=", $start],
            ["sync", "=", $sync]
        ])->get();

    }


    public static function findOneById($id) {

        return Website::where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByIdNucodeStatus($id, $nucode, $status) {

        return Website::where([
            ["_id", "=", $id],
            ["nucode", "=", $nucode],
            ["status", "=", $status]
        ])->first();

    }


    public static function findOneByNameNucode($name, $nucode) {

        return Website::where([
            ["name", "=", $name],
            ["nucode", "=", $nucode]
        ])->first();

    }


    public static function findPageBySyncNotApiNexusSaltStart($apiNexusSalt, $start, $sync, $page, $size) {

        return Website::where([
            ["api.nexus.salt", "!=", $apiNexusSalt],
            ["start", "!=", $start],
            ["sync", "=", $sync]
        ])->forPage($page, $size)->get();

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
