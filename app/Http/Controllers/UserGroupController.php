<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\UserGroup;
use App\Services\UserGroupService;
use Illuminate\Http\Request;
use stdClass;


class UserGroupController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "view")) {

            $userGroupResponse = UserGroupService::findData($request);

            $model = new stdClass();
            $model->websites = $userGroupResponse->websites;

            return view("user.group", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user-group.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function add(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "add")) {

            $model = new stdClass();
            $model->userGroup = new UserGroup();

            return view("user.group-entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user-group.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "userGroup", "view")) {

            $model = new stdClass();
            $model->userGroup = new UserGroup();
            $model->userGroup->_id = $id;

            return view("user.group-entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["user-group.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "delete")) {

            return response()->json(UserGroupService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "view")) {

            return response()->json(UserGroupService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function insert(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "add")) {

            return response()->json(UserGroupService::insert($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "view")) {

            return response()->json(UserGroupService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "userGroup", "edit")) {

            return response()->json(UserGroupService::update($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
