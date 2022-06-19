<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Services\DatabaseImportService;
use App\Services\DatabaseService;
use Illuminate\Http\Request;
use stdClass;


class DatabaseImportController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            $model = new stdClass();
            $model->viewResult = false;

            if($request->session()->get("databaseImportResult") != null) {

                if(count($request->session()->get("databaseImportResult")) > 0) {

                    $model->viewResult = true;

                }

            }

            return view("database.import", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["database-import.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function history(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            $model = new stdClass();

            return view("database.import-history", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["database-import.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function historyDelete(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "delete")) {

            return response()->json(DatabaseImportService::historyDelete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function historyTable(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            return response()->json(DatabaseImportService::historyFindTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function import(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "add")) {

            $result = new stdClass();
            $result->response = "Failed to import database data";
            $result->result = false;

            if(!empty($request->file)) {

                $result = DatabaseService::importData($request);

            }

            return response()->json($result, 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "database", "view")) {

            return response()->json(DatabaseImportService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
