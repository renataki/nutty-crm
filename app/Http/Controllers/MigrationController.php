<?php

namespace App\Http\Controllers;

use App\Services\MigrationService;
use Illuminate\Http\Request;
use stdClass;


class MigrationController extends Controller {


    public function generateUnclaimedDeposit(Request $request) {

        $model = new stdClass();

        MigrationService::generateUnclaimedDeposit();

        return view("global.migration", [
            "layout" => (object)[
                "css" => [],
                "js" => []
            ],
            "model" => $model
        ]);

    }


    public function migrate(Request $request) {

        $model = new stdClass();

        MigrationService::migrate();

        return view("global.migration", [
            "layout" => (object)[
                "css" => [],
                "js" => []
            ],
            "model" => $model
        ]);

    }


}
