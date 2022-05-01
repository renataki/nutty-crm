<?php

namespace App\Http\Controllers;

use stdClass;


class IndexController extends Controller {


    public function index() {

        $model = new stdClass();

        return view("index.index", [
            "layout" => (object)[
                "css" => [],
                "js" => ["library/template/dashboard-init.js"]
            ],
            "model" => $model
        ]);

    }


}
