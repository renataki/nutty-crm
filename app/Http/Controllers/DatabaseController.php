<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Services\DatabaseService;
use Illuminate\Http\Request;
use stdClass;


class DatabaseController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            $filter = DatabaseService::findData($request);

            $model = new stdClass();
            $model->websites = $filter->websites;

            return view("database.database", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["database.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "delete")) {

            return response()->json(DatabaseService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            return response()->json(DatabaseService::initializeData(), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function insert(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "add")) {

            return response()->json(DatabaseService::insert($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            return response()->json(DatabaseService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "edit")) {

            return response()->json(DatabaseService::update($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
