<?php

namespace App\Services;

use App\Components\DataComponent;
use App\Models\License;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserRole;
use App\Repositories\LicenseRepository;
use App\Repositories\UserGroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;
use stdClass;


class UserService {


    public static function delete($request) {

        $result = new stdClass();
        $result->response = "Failed to delete user data";
        $result->result = false;

        $userById = UserRepository::findOneById($request->id);

        if(!empty($userById)) {

            UserRepository::delete($userById);

            $result->response = "User data deleted";
            $result->result = true;

        } else {

            $result->response = "User doesn't exist";

        }

        return $result;

    }


    public static function findData($request) {

        $result = new stdClass();
        $result->response = "Failed to find user data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        if($account->nucode != "system") {

            $result->userGroups = UserGroupRepository::findByNucodeStatus($account->nucode, "Active");
            $result->userRoles = UserRoleRepository::findByNucodeStatus($account->nucode, "Active");

        } else {

            $result->userGroups = UserGroupRepository::findByStatus("Active");
            $result->userRoles = UserRoleRepository::findByStatus("Active");

        }

        $result->response = "User data found";
        $result->result = true;

        return $result;

    }


    public static function findTable($request) {

        $result = new stdClass();
        $result->draw = $request->draw;

        $account = DataComponent::initializeAccount($request);

        $defaultOrder = ["created.timestamp"];
        $users = DataComponent::initializeTableQuery(new User(), DataComponent::initializeObject($request->columns), DataComponent::initializeObject($request->order), $defaultOrder);

        $users = DataComponent::initializeTableData($account, $users);
        $users = $users->where([
            ["group._id", "!=", "0"],
            ["role._id", "!=", "0"]
        ]);

        $result->recordsTotal = $users->count("_id");
        $result->recordsFiltered = $result->recordsTotal;

        $result->data = $users->forPage(DataComponent::initializePage($request->start, $request->length), $request->length)->get();

        return $result;

    }


    public static function initializeData($request) {

        $result = new stdClass();
        $result->response = "Failed to initialize user data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        $result->user = UserRepository::findOneById($request->id);

        if(!empty($result->user)) {

            try {

                $result->user->password = [
                    "main" => Crypt::decryptString($result->user->password["main"]),
                    "recovery" => Crypt::decryptString($result->user->password["recovery"])
                ];

            } catch(Exception $exception) {

                Log::error($exception->getMessage());

            }

        }

        $result->response = "User data initialized";
        $result->result = true;

        return $result;

    }


    public static function insert($request) {

        $result = new stdClass();
        $result->response = "Failed to insert user data";
        $result->result = false;

        $validation = self::validateData($request);

        if($validation->result) {

            UserRepository::insert(DataComponent::initializeAccount($request), $validation->user);

            $result->response = "User data inserted";
            $result->result = true;

        } else {
            $result->response = $validation->response;
        }

        return $result;

    }


    public static function register($request) {

        $result = new stdClass();
        $result->response = "Failed to register user";
        $result->result = false;

        $validation = [];

        $licenseByNucode = LicenseRepository::findOneByNucode($request->nucode);

        if(!empty($licenseByNucode)) {

            array_push($validation, false);

            $result->response = "Company already exist";

        }

        $userByContactEmail = UserRepository::findOneByContactEmail($request->contact["email"]);

        if(!empty($userByContactEmail)) {

            array_push($validation, false);

            $result->response = "Email already exist";

        }

        if(empty($validation)) {

            $account = DataComponent::initializeSystemAccount();

            $userGroup = new UserGroup();
            $userGroup->description = "";
            $userGroup->name = "Super Administrator";
            $userGroup->nucode = $request->nucode;
            $userGroup->status = "Active";
            $userGroup->website = [
                "ids" => [],
                "names" => []
            ];
            $userGroupLast = UserGroupRepository::insert($account, $userGroup);

            $userRole = new UserRole();
            $userRole->description = "";
            $userRole->name = "Super Administrator";
            $userRole->nucode = $request->nucode;
            $userRole->privilege = [
                "database" => "7777",
                "report" => "7777",
                "setting" => "7777",
                "settingApi" => "7777",
                "template" => "7777",
                "user" => "7777",
                "userGroup" => "7777",
                "userRole" => "7777",
                "website" => "7777",
                "worksheet" => "7777",
                "worksheetCrm" => "7777"
            ];
            $userRole->status = "Active";
            $userRoleLast = UserRoleRepository::insert($account, $userRole);

            $user = new User();

            if($userGroupLast->_id != null && $userRoleLast->_id != null) {

                $user->avatar = "";
                $user->city = "";
                $user->contact = [
                    "email" => $request->contact["email"],
                    "fax" => "",
                    "line" => "",
                    "michat" => "",
                    "phone" => "",
                    "telegram" => "",
                    "wechat" => "",
                    "whatsapp" => ""
                ];
                $user->country = "";
                $user->gender = "";
                $user->group = [
                    "_id" => DataComponent::initializeObjectId($userGroupLast->_id),
                    "name" => $userGroupLast->name
                ];
                $user->language = "";
                $user->name = $request->name;
                $user->nucode = $request->nucode;
                $user->password = [
                    "main" => Crypt::encryptString($request->password["main"]),
                    "recovery" => Crypt::encryptString($request->password["main"])
                ];
                $user->privilege = [
                    "database" => "7777",
                    "report" => "7777",
                    "setting" => "7777",
                    "settingApi" => "7777",
                    "template" => "7777",
                    "user" => "7777",
                    "userGroup" => "7777",
                    "userRole" => "7777",
                    "website" => "7777",
                    "worksheet" => "7777",
                    "worksheetCrm" => "7777"
                ];
                $user->role = [
                    "_id" => DataComponent::initializeObjectId($userRoleLast->_id),
                    "name" => $userRoleLast->name
                ];
                $user->state = "";
                $user->status = "Active";
                $user->street = "";
                $user->type = "Administrator";
                $user->username = $request->username;
                $user->zip = "";
                UserRepository::insert($account, $user);

            }

            if($user->_id != null) {

                $license = new License();
                $license->nucode = $request->nucode;
                $license->package = [
                    "expired" => new UTCDateTime(),
                    "payment" => [
                        "last" => new UTCDateTime(),
                        "next" => new UTCDateTime()
                    ],
                    "start" => new UTCDateTime(),
                    "status" => "Trial",
                    "trial" => new UTCDateTime(Carbon::now()->addDays(30))
                ];
                $license->user = [
                    "primary" => [
                        "_id" => DataComponent::initializeObjectId($user->_id),
                        "avatar" => $user->avatar,
                        "name" => $user->name,
                        "username" => $user->username
                    ],
                    "total" => 1
                ];
                LicenseRepository::insert($account, $license);

                DataComponent::initializeCollectionByNucode($request->nucode);

            }

            $result->response = "User registered";
            $result->result = true;

        }

        return $result;

    }


    public static function update($request) {

        $result = new stdClass();
        $result->response = "Failed to update user data";
        $result->result = false;

        $validation = self::validateData($request);

        if($validation->result) {

            UserRepository::update(DataComponent::initializeAccount($request), $validation->user);

            $result->response = "User data updated";
            $result->result = true;

        }

        return $result;

    }


    public static function updatePassword($request, $id) {

        $result = new stdClass();
        $result->response = "Failed to change password";
        $result->result = false;

        $validation = self::validateChangePassword($request, $id);

        if($validation->result) {

            $userById = UserRepository::findOneById($id);

            if(!empty($userById)) {

                $userById->password = [
                    "main" => Crypt::encryptString($request->password["main"]),
                    "recovery" => Crypt::encryptString($request->password["main"])
                ];
                UserRepository::update(DataComponent::initializeAccount($request), $userById);

                $result->response = "Change password success";
                $result->result = true;

            } else {
                $result->response = "User not exist";
                $result->result = false;
            }

        }

        return $result;

    }


    public static function validateChangePassword($request, $id) {

        $result = new stdClass();
        $result->response = "Failed to validate user data";
        $result->result = false;

        $userById = UserRepository::findOneById($id);

        if(!empty($userById)) {
            $passwordCurrent = $request->password["main"];
            $passwordMain = Crypt::decryptString($userById->password["main"]);

            if($passwordCurrent = $passwordMain) {
                $result->response = "User data validated";
                $result->result = true;

            } else {
                $result->response = "Current password is wrong";
                $result->result = false;
            }

        } else {
            $result->response = "User not exist";
            $result->result = false;
        }

        return $result;
    }


    public static function validateData($request) {

        $result = new stdClass();
        $result->response = "Failed to validate user data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        $validation = DataComponent::checkNucode($request, $request->nucode, []);

        $result->user = new User();

        if(!is_null($request->id)) {

            $result->user = UserRepository::findOneById($request->id);

            if(empty($result->user)) {

                array_push($validation, false);

                $result->response = "User doesn't exist";

            }

        }

        $result->user->avatar = "";
        $result->user->city = "";
        $result->user->contact = [
            "email" => "",
            "fax" => "",
            "line" => "",
            "michat" => "",
            "phone" => "",
            "telegram" => "",
            "wechat" => "",
            "whatsapp" => ""
        ];
        $result->user->country = "";
        $result->user->gender = "";
        $result->user->group = [
            "_id" => DataComponent::initializeObjectId($request->group["id"]),
            "name" => ""
        ];
        $result->user->language = "";
        $result->user->name = $request->name;
        $result->user->nucode = $request->nucode;
        $result->user->password = [
            "main" => Crypt::encryptString($request->password["main"]),
            "recovery" => Crypt::encryptString($request->password["main"])
        ];
        $result->user->privilege = [
            "database" => "0000",
            "report" => "0000",
            "setting" => "0000",
            "settingApi" => "0000",
            "template" => "0000",
            "user" => "0000",
            "userGroup" => "0000",
            "userRole" => "0000",
            "website" => "0000",
            "worksheet" => "0000",
            "worksheetCrm" => "0000"
        ];
        $result->user->role = [
            "_id" => DataComponent::initializeObjectId($request->role["id"]),
            "name" => ""
        ];
        $result->user->state = "";
        $result->user->status = $request->status;
        $result->user->street = "";
        $result->user->type = $request->type;
        $result->user->username = $request->username;
        $result->user->zip = "";

        if(config("app.nucode") == "PUBLIC") {

            $licenseByNucode = LicenseRepository::findOneByNucode($request->nucode);

            if(!empty($licenseByNucode)) {

                $countUsersByNucode = UserRepository::countByNucode($request->nucode);

                if($licenseByNucode->user["total"] < $countUsersByNucode) {

                    array_push($validation, false);

                    $result->response = "Not enough seat";

                }

            } else {

                array_push($validation, false);

                $result->response = "Nucode doesn't exist";

            }

        }

        $userByNucodeUsername = UserRepository::findOneByNucodeUsername($request->nucode, $request->name);

        if(!empty($userByNucodeUsername)) {

            if(!$request->id == $userByNucodeUsername->_id) {

                array_push($validation, false);

                $result->response = "User username already exist";

            }

        }

        if(empty($validation)) {

            $userGroupByIdStatus = UserGroupRepository::findOneByIdStatus($result->user->group["_id"], "Active");

            if(!empty($userGroupByIdStatus)) {

                $result->user->group = [
                    "_id" => DataComponent::initializeObjectId($userGroupByIdStatus->_id),
                    "name" => $userGroupByIdStatus->name
                ];

            }

            $userRoleByIdStatus = UserRoleRepository::findOneByIdStatus($result->user->role["_id"], "Active");

            if(!empty($userRoleByIdStatus)) {

                $result->user->privilege = $userRoleByIdStatus->privilege;
                $result->user->role = [
                    "_id" => DataComponent::initializeObjectId($userRoleByIdStatus->_id),
                    "name" => $userRoleByIdStatus->name
                ];

            }

            $result->response = "User data validated";
            $result->result = true;

        }

        return $result;

    }


}
