<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;


class AccessDeniedController extends Controller {


    public function index(Request $request) {

        $model = new stdClass();

        return view("global.access-denied", [
            "layout" => (object)[
                "css" => [],
                "js" => []
            ],
            "model" => $model
        ]);

    }


}
