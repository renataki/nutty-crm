<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use stdClass;


class RegisterController extends Controller {


    public function index() {

        if(config("app.nucode") == "PUBLIC") {

            $model = new stdClass();

            return view("global.register", [
                "layout" => (object)[
                    "css" => [],
                    "js" => ["register.js"]
                ],
                "model" => $model
            ]);

        } else {

            return abort(404);

        }

    }


    public function register(Request $request) {

        return UserService::register($request);

    }


}
