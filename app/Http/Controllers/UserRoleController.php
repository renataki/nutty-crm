<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\UserRole;
use App\Services\UserRoleService;
use Illuminate\Http\Request;
use stdClass;


class UserRoleController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "view")) {

            $model = new stdClass();

            return view("user.role", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user-role.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function add(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "add")) {

            $model = new stdClass();
            $model->userRole = new UserRole();

            return view("user.role-entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user-role.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "userRole", "view")) {

            $model = new stdClass();
            $model->userRole = new UserRole();
            $model->userRole->_id = $id;

            return view("user.role-entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user-role.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "delete")) {

            return response()->json(UserRoleService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "view")) {

            return response()->json(UserRoleService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function insert(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "add")) {

            return response()->json(UserRoleService::insert($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "view")) {

            return response()->json(UserRoleService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "userRole", "edit")) {

            return response()->json(UserRoleService::update($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
