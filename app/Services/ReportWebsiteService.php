<?php

namespace App\Services;

use App\Components\DataComponent;
use App\Repositories\ReportWebsiteRepository;
use App\Repositories\UserGroupRepository;
use App\Repositories\WebsiteRepository;
use stdClass;


class ReportWebsiteService {


    public static function findFilter($request) {

        $result = new stdClass();
        $result->filterDate = "";
        $result->response = "Failed to find filter website report data";
        $result->result = false;
        $result->websites = [];

        $account = DataComponent::initializeAccount($request);

        if($request->session()->has("reportDateRangeFilter")) {

            $result->filterDate = $request->session()->get("reportDateRangeFilter");

        }

        $userGroupById = UserGroupRepository::findOneById($account->group["_id"]);

        if(!empty($userGroupById)) {

            $result->websites = WebsiteRepository::findInId($userGroupById->website["ids"]);

        }

        $result->response = "Filter website report data found";
        $result->result = true;

        return $result;

    }


    public static function findTable($request) {

        $result = new stdClass();
        $result->draw = $request->draw;

        $account = DataComponent::initializeAccount($request);

        $reportWebsites = ReportWebsiteRepository::findWebsiteTable($request->columns[0]["search"]["value"], $account->nucode, $request->columns[1]["search"]["value"]);

        $result->recordsTotal = $reportWebsites->count("_id");
        $result->recordsFiltered = $result->recordsTotal;

        $result->data = $reportWebsites->forPage(DataComponent::initializePage($request->start, $request->length), $request->length);

        if(!empty($request->columns[0]["search"]["value"])) {

            $request->session()->put("reportDateRangeFilter", $request->columns[0]["search"]["value"]);

        }

        return $result;

    }


}
