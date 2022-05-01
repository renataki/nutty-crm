<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use stdClass;


class MigrationService {


    public static function migrate() {

        $result = new stdClass();
        $result->response = "Failed to migrate data";
        $result->result = false;

        $users = User::where([])->get();

        foreach($users as $value) {

            $userById = User::where([
                ["_id", "=", $value->_id]
            ])->first();

            if(!empty($userById)) {

                $userById->privilege = [
                    "database" => $userById->privilege["database"],
                    "report" => $userById->privilege["report"],
                    "setting" => "0000",
                    "settingApi" => "0000",
                    "user" => $userById->privilege["user"],
                    "userGroup" => $userById->privilege["userGroup"],
                    "userRole" => $userById->privilege["userRole"],
                    "website" => $userById->privilege["website"],
                    "worksheet" => $userById->privilege["worksheet"],
                ];
                $userById->save();

            }

        }

        $userRoles = UserRole::where([])->get();

        foreach($userRoles as $value) {

            $userRoleById = UserRole::where([
                ["_id", "=", $value->_id]
            ])->first();

            if(!empty($userRoleById)) {

                $userRoleById->privilege = [
                    "database" => $userById->privilege["database"],
                    "report" => $userById->privilege["report"],
                    "setting" => "0000",
                    "settingApi" => "0000",
                    "user" => $userById->privilege["user"],
                    "userGroup" => $userById->privilege["userGroup"],
                    "userRole" => $userById->privilege["userRole"],
                    "website" => $userById->privilege["website"],
                    "worksheet" => $userById->privilege["worksheet"],
                ];
                $userRoleById->save();

            }

        }

        $result->response = "Data migrated";
        $result->result = true;

        return $result;

    }


}
