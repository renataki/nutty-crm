<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\User;
use App\Services\ReportUserService;
use Illuminate\Http\Request;
use stdClass;


class ReportUserController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            $request->session()->forget("reportDateRangeFilter");

            $model = new stdClass();

            return view("report.user", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["report-user.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function detail(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            $reportUserResponse = ReportUserService::findFilter($request, $id);

            $model = new stdClass();
            $model->filterDate = $reportUserResponse->filterDate;
            $model->user = new User();
            $model->user->_id = $reportUserResponse->report->user["_id"];
            $model->user->username = $reportUserResponse->report->user["username"];

            return view("report.user-detail", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["report-user.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function detailTable(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            return response()->json(ReportUserService::detailFindTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            return response()->json(ReportUserService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
