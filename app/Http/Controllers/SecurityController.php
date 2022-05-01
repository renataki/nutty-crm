<?php

namespace App\Http\Controllers;

use App\Components\DataComponent;
use App\Services\SecurityService;
use Illuminate\Http\Request;
use stdClass;


class SecurityController extends Controller {


    public function encryption() {

        $model = new stdClass();

        return view("global.encryption", [
            "layout" => (object)[
                "css" => [],
                "js" => ["encryption.js"]
            ],
            "model" => $model
        ]);

    }


    public function encrypt(Request $request) {

        if($request->session()->has("account")) {

            return response()->json(SecurityService::encrypt($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


    public function initializeAccount(Request $request) {

        if($request->session()->has("account")) {

            return response()->json(SecurityService::initializeAccount($request), 200);

        } else {

            return response()->json(DataComponent::initializeAccessDenied(), 200);

        }

    }


}
