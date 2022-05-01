<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\License;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use stdClass;


class LicenseController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkSystemPrivilege($request)) {

            $model = new stdClass();

            return view("license.license", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["license.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkSystemPrivilege($request)) {

            $model = new stdClass();
            $model->license = new License();
            $model->license->_id = $id;

            return view("license.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["license.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkSystemPrivilege($request)) {

            return response()->json(LicenseService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkSystemPrivilege($request)) {

            return response()->json(LicenseService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkSystemPrivilege($request)) {

            return response()->json(LicenseService::findTable($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkSystemPrivilege($request)) {

            return response()->json(LicenseService::update($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
