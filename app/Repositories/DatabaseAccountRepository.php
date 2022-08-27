<?php

namespace App\Repositories;

use App\Components\DataComponent;
use App\Models\DatabaseAccount;


class DatabaseAccountRepository {


    public static function count($websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([])->count("_id");

    }


    public static function delete($data) {

        return $data->delete();

    }


    public static function deleteByDatabaseId($databaseId, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["database._id", "=", $databaseId]
        ])->delete();

    }


    public static function findOneByDatabaseId($databaseId, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["database._id", "=", $databaseId]
        ])->first();

    }


    public static function findOneById($id, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["_id", "=", $id]
        ])->first();

    }


    public static function findOneByUsername($username, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["username", "=", $username]
        ])->first();

    }


    public static function findOneByUsernameNotDatabaseId($databaseId, $username, $websiteId) {

        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $websiteId);

        return $databaseAccount->where([
            ["database._id", "!=", $databaseId],
            ["username", "=", $username]
        ])->first();

    }


    public static function insert($account, $data, $websiteId) {

        $data->created = DataComponent::initializeTimestamp($account);
        $data->modified = $data->created;

        $data->setTable("databaseAccount_" . $websiteId);

        $data->save();

        return $data;

    }


    public static function update($account, $data, $websiteId) {

        if($account != null) {

            $data->modified = DataComponent::initializeTimestamp($account);

        }

        $data->setTable("databaseAccount_" . $websiteId);

        return $data->save();

    }


}
