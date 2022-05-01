<?php

namespace App\Services;

use App\Components\DataComponent;
use App\Repositories\ReportRepository;
use App\Repositories\UserGroupRepository;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;
use stdClass;


class ReportService {


    public static function findFilter($request, $userId) {

        $result = new stdClass();
        $result->filterDate = "";
        $result->response = "Failed to find filter report data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        $result->report = ReportRepository::findOneByUserId($account->nucode, $userId);

        if($request->session()->has("reportDateRangeFilter")) {

            $result->filterDate = $request->session()->get("reportDateRangeFilter");

        }

        $result->response = "Filter report data found";
        $result->result = true;

        return $result;

    }


    public static function findTable($request) {

        $result = new stdClass();
        $result->draw = $request->draw;

        $account = DataComponent::initializeAccount($request);

        $reports = ReportRepository::findRawTable($request->columns[0]["search"]["value"], $request->columns[2]["search"]["value"], $account->nucode, $request->columns[1]["search"]["value"]);

        $result->recordsTotal = $reports->count("_id");
        $result->recordsFiltered = $result->recordsTotal;

        $result->data = $reports->forPage(DataComponent::initializePage($request->start, $request->length), $request->length);

        if($account->nucode != "system") {

            $result->userGroups = UserGroupRepository::findByNucodeStatus($account->nucode, "Active");

        } else {

            $result->userGroups = UserGroupRepository::findByStatus("Active");

        }

        if(!empty($request->columns[0]["search"]["value"])) {

            $request->session()->put("reportDateRangeFilter", $request->columns[0]["search"]["value"]);

        }

        return $result;

    }


    public static function findUserTable($request) {

        $result = new stdClass();
        $result->draw = $request->draw;

        $account = DataComponent::initializeAccount($request);

        $filterDateRange = DataComponent::initializeFilterDateRange($request->columns[1]["search"]["value"], new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)->addDays(1)), new UTCDateTime(Carbon::createFromFormat("Y-m-d H:i:s", "1970-01-10 00:00:00")));
        $result->recordsTotal = ReportRepository::countByUserIdBetweenDate($filterDateRange->end, $account->nucode, $filterDateRange->start, $request->userId);
        $result->recordsFiltered = $result->recordsTotal;

        $result->data = ReportRepository::findByUserIdBetweenDate($filterDateRange->end, $request->length, $account->nucode, DataComponent::initializePage($request->start, $request->length), $filterDateRange->start, $request->userId);

        return $result;

    }


}
