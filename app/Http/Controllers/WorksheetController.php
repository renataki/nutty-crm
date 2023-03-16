<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Services\WorksheetService;
use Illuminate\Http\Request;
use App\Models\Template;
use stdClass;


class WorksheetController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {
            $templates = Template::latest()->where('status','Active')->get();
            $model = new stdClass();
            $model->websiteId = $request->session()->get("websiteId");
            $model->templates = $templates;
            return view("worksheet.worksheet", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["worksheet.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function call(Request $request, $websiteId, $id) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            $request->session()->put("websiteId", $websiteId);
            $templates = Template::latest()->where('status','Active')->get();
            $model = new stdClass();
            $model->id = $id;
            $model->websiteId = $websiteId;
            $model->templates = $templates;
            
            return view("worksheet.call", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["worksheet.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function crm(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheetCrm", "view")) {

            $worksheetResponse = WorksheetService::findFilter($request, null);
            $templates = Template::latest()->where('status','Active')->get();
            $model = new stdClass();
            $model->websiteId = $request->session()->get("websiteId");
            $model->templates = $templates;

            return view("worksheet.crm", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["worksheet.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function crmTable(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            return response()->json(WorksheetService::crmFindTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function result(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            $worksheetResponse = WorksheetService::findFilter($request, null);

            $model = new stdClass();
            $model->filterDate = "";
            $model->userId = "";
            $model->users = $worksheetResponse->users;
            $model->websites = $worksheetResponse->websites;

            return view("worksheet.result", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["worksheet.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function resultUser(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            $worksheetResponse = WorksheetService::findFilter($request, $id);

            $model = new stdClass();
            $model->filterDate = $worksheetResponse->filterDate;
            $model->userId = $id;
            $model->users = $worksheetResponse->users;
            $model->websites = $worksheetResponse->websites;

            return view("worksheet.result", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["worksheet.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function callInitializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            return response()->json(WorksheetService::callInitializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            return response()->json(WorksheetService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function resultTable(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "view")) {

            return response()->json(WorksheetService::resultFindTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function start(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "edit")) {

            return response()->json(WorksheetService::start($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function startCrm(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheetCrm", "edit")) {

            return response()->json(WorksheetService::start($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "worksheet", "edit")) {

            return response()->json(WorksheetService::update($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function sendSms(Request $request) {
        return response()->json(WorksheetService::sendSms($request), 200);
    }

    public function sendGroupSms(Request $request) {
        return response()->json(WorksheetService::sendGroupSms($request), 200);
    }
}
