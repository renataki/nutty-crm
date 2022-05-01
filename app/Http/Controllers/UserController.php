<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Session;
use stdClass;


class UserController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "view")) {

            $userResponse = UserService::findData($request);

            $model = new stdClass();
            $model->userGroups = $userResponse->userGroups;
            $model->userRoles = $userResponse->userRoles;

            return view("user.user", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function profile(Request $request) {

        $model = new stdClass();

        return view("user.profile", [
            "layout" => (object)[
                "css" => [],
                "js" => ["user.js"]
            ],
            "model" => $model
        ]);

    }


    public function add(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "add")) {

            $userResponse = UserService::findData($request);

            $model = new stdClass();
            $model->user = new User();
            $model->userGroups = $userResponse->userGroups;
            $model->userRoles = $userResponse->userRoles;

            return view("user.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "user", "view")) {

            $userResponse = UserService::findData($request);

            $model = new stdClass();
            $model->user = new User();
            $model->user->_id = $id;
            $model->userGroups = $userResponse->userGroups;
            $model->userRoles = $userResponse->userRoles;

            return view("user.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "delete")) {

            return response()->json(UserService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "view")) {

            return response()->json(UserService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function insert(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "add")) {

            return response()->json(UserService::insert($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "view")) {

            return response()->json(UserService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "user", "edit")) {

            return response()->json(UserService::update($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function updatePassword(Request $request) {

        $id = Session::get("account")->_id;

        return response()->json(UserService::updatePassword($request, $id), 200);

    }


}
