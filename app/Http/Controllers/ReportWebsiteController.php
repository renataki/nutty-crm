<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Services\ReportWebsiteService;
use Illuminate\Http\Request;
use stdClass;


class ReportWebsiteController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            $request->session()->forget("reportDateRangeFilter");

            $reportWebsiteResponse = ReportWebsiteService::findFilter($request);

            $model = new stdClass();
            $model->websites = $reportWebsiteResponse->websites;

            return view("report.website", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["report-website.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "report", "view")) {

            return response()->json(ReportWebsiteService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
