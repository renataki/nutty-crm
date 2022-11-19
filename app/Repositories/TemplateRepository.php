<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\Template;


class TemplateRepository {


    public static function count() {

        return Template::where([])->count("_id");

    }


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByNucode($nucode) {

        return Template::where("nucode", $nucode)->delete();

    }


    public static function findAll() {

        return Template::where([])->get();

    }


    public static function findByNucode($nucode) {

        return Template::where([
            ["nucode", "=", $nucode]
        ])->get();

    }


    public static function findByNucodeStatus($nucode, $status) {

        return Template::where([
            ["nucode", "=", $nucode],
            ["status", "=", $status]
        ])->get();

    }


    public static function findByStatus($status) {

        return Template::where([
            ["status", "=", $status]
        ])->get();

    }


    public static function findIdAll() {

        return Template::where([])->pluck("_id")->toArray();

    }


    public static function findInId($ids) {

        return Template::whereIn("_id", $ids)->get();

    }


    public static function findOneById($id) {

        return Template::where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByIdNucodeStatus($id, $nucode, $status) {

        return Template::where([
            ["_id", "=", $id],
            ["nucode", "=", $nucode],
            ["status", "=", $status]
        ])->first();

    }


    public static function findOneByNameNucode($name, $nucode) {

        return Template::where([
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
