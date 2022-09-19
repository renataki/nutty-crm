<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Models\Template;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use stdClass;


class TemplateController extends Controller {


    public function index(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "view")) {

            $model = new stdClass();

            return view("template.template", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["template.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function add(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "add")) {

            $model = new stdClass();
            $model->template = new Template();

            return view("template.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["template.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function edit(Request $request, $id) {

        if(DataComponent::checkPrivilege($request, "template", "view")) {

            $model = new stdClass();
            $model->template = new Template();
            $model->template->_id = $id;

            return view("template.entry", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["template.js"]
                ],
                "model" => $model
            ]);

        } else {

            return redirect("/access-denied/");

        }

    }


    public function delete(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "delete")) {

            return response()->json(TemplateService::delete($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeData(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "view")) {

            return response()->json(TemplateService::initializeData($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function insert(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "add")) {

            return response()->json(TemplateService::insert($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function table(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "view")) {

            return response()->json(TemplateService::findTable($request, false), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function update(Request $request) {

        if(DataComponent::checkPrivilege($request, "template", "edit")) {

            return response()->json(TemplateService::update($request, false), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);
            
        }

    }


}
