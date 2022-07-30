<?php

namespace App\Http\Controllers;

use App\Services\SystemService;
use stdClass;


class SystemController extends Controller {


    public function findPlayerTransaction($date) {

        $model = new stdClass();

        SystemService::findPlayerTransaction($date);

        return view("global.migration", [
            "layout" => (object)[
                "css" => [],
                "js" => []
            ],
            "model" => $model
        ]);

    }


    public function generateUnclaimedDepositQueue($date) {

        $model = new stdClass();

        SystemService::generateUnclaimedDepositQueue($date);

        return view("global.migration", [
            "layout" => (object)[
                "css" => [],
                "js" => []
            ],
            "model" => $model
        ]);

    }


    public function info() {

        dd(phpinfo());

    }


    public function syncPlayerTransaction($websiteId) {

        $model = new stdClass();

        SystemService::syncPlayerTransaction($websiteId);

        return view("global.migration", [
            "layout" => (object)[
                "css" => [],
                "js" => []
            ],
            "model" => $model
        ]);

    }


}
