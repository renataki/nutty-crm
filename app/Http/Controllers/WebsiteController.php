<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\Website;
use App\Services\WebsiteService;
use Illuminate\Http\Request;
use stdClass;


class WebsiteController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "view")) {

            $model = new stdClass();

            return view("website.website", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["website.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function add(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "add")) {

            $model = new stdClass();
            $model->website = new Website();

            return view("website.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["website.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "website", "view")) {

            $model = new stdClass();
            $model->website = new Website();
            $model->website->_id = $id;

            return view("website.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["website.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "delete")) {

            return response()->json(WebsiteService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "view")) {

            return response()->json(WebsiteService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function insert(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "add")) {

            return response()->json(WebsiteService::insert($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "view")) {

            return response()->json(WebsiteService::findTable($request, false), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "website", "edit")) {

            return response()->json(WebsiteService::update($request, false), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
