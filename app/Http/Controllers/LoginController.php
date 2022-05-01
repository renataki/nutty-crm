<?php

namespace App\Http\Controllers;

use App\Services\UserLogService;
use Illuminate\Http\Request;
use stdClass;


class LoginController extends Controller {


    public function index() {

        $model = new stdClass();

        return view("global.login", [
            "layout" => (object)[
                "css" => [],
                "js" => ["login.js"]
            ],
            "model" => $model
        ]);

    }


    public function login(Request $request) {

        return UserLogService::login($request);

    }


    public function logout(Request $request) {

        return UserLogService::logout($request);

    }


}
