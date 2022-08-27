<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Services\WebsiteService;
use Illuminate\Http\Request;
use stdClass;


class SettingApiController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "settingApi", "view")) {

            $model = new stdClass();

            return view("setting.api", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["setting-api.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "settingApi", "view")) {

            $websiteResponse = WebsiteService::findData($id);

            $model = new stdClass();
            $model->syncQueue = $websiteResponse->syncQueue;
            $model->website = $websiteResponse->website;

            return view("setting.api-entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["setting-api.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "settingApi", "view")) {

            return response()->json(WebsiteService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function sync(Request $request) {

        if(DataComponent::checkPrivilege($request, "settingApi", "edit")) {

            return response()->json(WebsiteService::sync($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "settingApi", "view")) {

            return response()->json(WebsiteService::findTable($request, true), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "settingApi", "edit")) {

            return response()->json(WebsiteService::update($request, true), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
