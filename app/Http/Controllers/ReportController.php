<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Http\Request;
use stdClass;


class ReportController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            $request->session()->forget("reportDateRangeFilter");

            $model = new stdClass();

            return view("report.report", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["report.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function user(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            $reportResponse = ReportService::findFilter($request, $id);

            $model = new stdClass();
            $model->filterDate = $reportResponse->filterDate;
            $model->user = new User();
            $model->user->_id = $reportResponse->report->user["_id"];
            $model->user->username = $reportResponse->report->user["username"];

            return view("report.user", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["report.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            return response()->json(ReportService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function userTable(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            return response()->json(ReportService::findUserTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
