<?php

namespace App\Services;

use App\Components\DataComponent;
use App\Models\DatabaseLog;
use App\Models\Report;
use App\Models\User;
use App\Repositories\DatabaseAccountRepository;
use App\Repositories\DatabaseAttemptRepository;
use App\Repositories\DatabaseLogRepository;
use App\Repositories\DatabaseRepository;
use App\Repositories\PlayerAttemptRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserGroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;
use stdClass;


class WorksheetService {


    public static function callInitializeData($request) {

        $result = new stdClass();
        $result->back = false;
        $result->databaseAccount = [];
        $result->databaseLog = null;
        $result->reference = "";
        $result->response = "Failed to initialize call worksheet data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        $result->database = DatabaseRepository::findOneById($request->id, $request->websiteId);

        if(!empty($result->database)) {

            $result->databaseAccount = DatabaseAccountRepository::findOneByDatabaseId($result->database->_id, $request->websiteId);

            $result->databaseLog = DatabaseLogRepository::findLastByDatabaseIdUserId($result->database->_id, $account->_id, $request->websiteId);

            if(!empty($result->databaseLog)) {

                $result->reference = $result->databaseLog->reference;

                if($result->databaseLog->status != "FollowUp" && $result->databaseLog->status != "Registered") {

                    $result->back = true;

                }

            }

        }

        $result->response = "Call worksheet data initialized";
        $result->result = true;

        return $result;

    }


    public static function findFilter($request, $id) {

        $result = new stdClass();
        $result->filterDate = "";
        $result->response = "Failed to find filter worksheet data";
        $result->result = false;
        $result->websites = [];

        $account = DataComponent::initializeAccount($request);

        if($request->session()->has("reportDateRangeFilter")) {

            $result->filterDate = $request->session()->get("reportDateRangeFilter");

        }

        $result->users = UserRepository::findByNucode($account->nucode);

        if($id != null) {

            $userById = UserRepository::findOneById($id);

            if(empty($userById)) {

                $reportByUserId = ReportRepository::findOneByUserId($account->nucode, $id);

                if(!empty($reportByUserId)) {

                    $user = new User();
                    $user->_id = $reportByUserId->user["_id"];
                    $user->name = $reportByUserId->user["name"];
                    $user->username = $reportByUserId->user["username"];

                    $result->users = $result->users->push($user);

                }

            }

        }

        $userGroupById = UserGroupRepository::findOneById($account->group["_id"]);

        if(!empty($userGroupById)) {

            $result->websites = WebsiteRepository::findInId($userGroupById->website["ids"]);

        }

        $result->response = "Filter report data found";
        $result->result = true;

        return $result;

    }


    public static function initializeData($request) {

        $result = new stdClass();
        $result->back = false;
        $result->database = null;
        $result->databaseAccount = null;
        $result->databaseLog = null;
        $result->reference = "";
        $result->response = "Failed to initialize worksheet data";
        $result->result = false;
        $result->userGroup = null;

        $account = DataComponent::initializeAccount($request);

        if($request->session()->has("websiteId")) {

            $websiteById = WebsiteRepository::findOneById($request->session()->get("websiteId"));

            if(!empty($websiteById)) {

                if($account->type == "CRM") {

                    $result->database = DatabaseRepository::findOneWorksheetCrm($account->_id, "Available", $websiteById->_id);

                } else if($account->type == "Telemarketer") {

                    $result->database = DatabaseRepository::findOneWorksheetTelemarketer("Available", $account->_id, $websiteById->_id);

                }

                if(empty($result->database)) {

                    $result->database = DatabaseRepository::findOneWorksheetGroup($account->group["_id"], "Available", $websiteById->_id);

                    if(empty($result->database)) {

                        $result->database = DatabaseRepository::findOneWorksheetWebsite("Available", $websiteById->_id);

                    }

                }

                if(!empty($result->database)) {

                    $result->databaseAccount = DatabaseAccountRepository::findOneByDatabaseId($result->database->_id, $websiteById->_id);

                    $databaseLogByDatabaseIdUserId = DatabaseLogRepository::findLastByDatabaseIdUserId($result->database->_id, $account->_id, $websiteById->_id);

                    if(!empty($databaseLogByDatabaseIdUserId)) {

                        $result->reference = $databaseLogByDatabaseIdUserId->reference;

                    }

                    $result->database->status = "Reserved";

                    if($account->type == "Telemarketer") {

                        $result->database->telemarketer = [
                            "_id" => $account->_id,
                            "avatar" => $account->avatar,
                            "name" => $account->name,
                            "username" => $account->username
                        ];

                    }

                    DatabaseRepository::update($account, $result->database, $websiteById->_id);

                    $result->databaseAccount = DatabaseAccountRepository::findOneByDatabaseId($result->database->_id, $websiteById->_id);

                    $databaseLog = new DatabaseLog();
                    $databaseLog->database = [
                        "_id" => DataComponent::initializeObjectId($result->database->_id),
                        "name" => $result->database->name
                    ];
                    $databaseLog->status = "Pending";
                    $databaseLog->user = [
                        "_id" => DataComponent::initializeObjectId($account->_id),
                        "avatar" => $account->avatar,
                        "name" => $account->name,
                        "username" => $account->username
                    ];
                    $databaseLog->website = [
                        "_id" => DataComponent::initializeObjectId($websiteById->_id),
                        "name" => $websiteById->name
                    ];
                    $result->databaseLog = DatabaseLogRepository::insert($account, $databaseLog, $websiteById->_id);

                    $result->response = "Worksheet data initialized";
                    $result->result = true;

                } else {

                    $result->response = "Database empty";

                }

            } else {

                $result->response = "Website doesn't exist";

            }

        } else {

            $result->userGroup = UserGroupRepository::findOneById($account->group["_id"]);

            $result->response = "Worksheet data initialized";
            $result->result = true;

        }

        return $result;

    }


    private static function initializeStatusData($data, $status) {

        $result = $data->status;

        $index = array_search($status, $data->status["names"]);

        if(gettype($index) == "integer") {

            $result["totals"][$index]++;

        } else {

            array_push($result["names"], $status);
            array_push($result["totals"], 1);

        }

        return $result;

    }


    private static function initializeWebsiteData($data, $website) {

        $result = $data->website;

        $index = array_search($website->_id, $data->website["ids"]);

        if(gettype($index) == "integer") {

            $result["totals"][$index]++;

        } else {

            array_push($result["ids"], $website->_id);
            array_push($result["names"], $website->name);
            array_push($result["totals"], 1);

        }

        return $result;

    }


    public static function resultFindTable($request) {

        $result = new stdClass();
        $result->draw = $request->draw;

        $account = DataComponent::initializeAccount($request);

        $filter = DataComponent::initializeObject($request->columns);
        $count = 0;
        $data = new Collection();

        $filterDate = $filter[1]->search->value;
        $filterGroup = $account->group["_id"];
        $filterName = $filter[3]->search->value;
        $filterStatus = $filter[5]->search->value;
        $filterUser = $account->_id;
        $filterUsername = $filter[2]->search->value;
        $filterWebsite = $filter[4]->search->value;

        if($account->type == "Administrator") {

            $userById = UserRepository::findOneById($filter[2]->search->value);

            if(!empty($userById)) {

                $filterGroup = $userById->group["_id"];

            }

            $filterName = $filter[4]->search->value;
            $filterStatus = $filter[6]->search->value;
            $filterUser = $filter[2]->search->value;
            $filterUsername = $filter[3]->search->value;
            $filterWebsite = $filter[5]->search->value;

        }

        $userGroupById = UserGroupRepository::findOneById($filterGroup);

        if(!empty($userGroupById)) {

            $date = Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0);
            $filterDateRange = DataComponent::initializeFilterDateRange($filterDate, new UTCDateTime($date->addDays(1)), new UTCDateTime($date));

            foreach($userGroupById->website["ids"] as $value) {

                $retrieve = true;

                if(!empty($filterWebsite) && $value != $filterWebsite) {

                    $retrieve = false;

                }

                if($retrieve) {

                    $countResultTable = DatabaseLogRepository::countDatabaseAccountTable($filterDateRange->end, $filterDateRange->start, $filterName, $filterStatus, $filterUser, $filterUsername, $value);

                    if(!$countResultTable->isEmpty()) {

                        $count += $countResultTable[0]->count;

                    }

                }

                $sorts = [
                    [
                        "field" => "created.timestamp",
                        "direction" => 1
                    ]
                ];

                $order = DataComponent::initializeObject($request->order);

                if($order[0]->column != 0) {

                    if(strtoupper($order[0]->dir) == "ASC" || strtoupper($order[0]->dir) == "DESC") {

                        $direction = 1;

                        if(strtoupper($order[0]->dir) == "DESC") {

                            $direction = -1;

                        }

                        $sorts = [
                            [
                                "field" => $order[0]->column->data,
                                "direction" => $direction
                            ]
                        ];

                    }

                }

                if($retrieve) {

                    $data = $data->merge(DatabaseLogRepository::findDatabaseAccountTable($filterDateRange->end, $filterDateRange->start, $request->length, $filterName, $request->start, $sorts, $filterStatus, $filterUser, $filterUsername, $value));

                }

            }

        }

        $result->recordsTotal = $count;
        $result->recordsFiltered = $result->recordsTotal;

        $result->data = $data;

        return $result;

    }


    public static function start($request) {

        $result = new stdClass();
        $result->response = "Failed to start worksheet";
        $result->result = false;

        $request->session()->put("websiteId", $request->website["id"]);

        $result->response = "Database worksheet initialized";
        $result->result = true;

        return $result;

    }


    public static function update($request) {

        $result = new stdClass();
        $result->response = "Failed to update worksheet data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        $databaseById = DatabaseRepository::findOneById($request->id, $request->session()->get("websiteId"));

        if(!empty($databaseById)) {

            $databaseAttemptByContactPhone = DatabaseAttemptRepository::findOneByContactPhone($databaseById->contact["phone"], $account->nucode);

            if(!empty($databaseAttemptByContactPhone)) {

                $result = self::updateDatabase($request, $databaseById, $databaseAttemptByContactPhone);

            }

        }

        return $result;

    }


    private static function updateDatabase($request, $database, $databaseAttempt) {

        $result = new stdClass();
        $result->response = "Failed to update worksheet database data";
        $result->result = false;

        $account = DataComponent::initializeAccount($request);

        $database->name = $request->name;
        $database->status = "Processed";
        DatabaseRepository::update($account, $database, $request->session()->get("websiteId"));

        if(is_null($request->status)) {

            $request->status = "Pending";

        }

        $websiteById = WebsiteRepository::findOneById($request->session()->get("websiteId"));

        if(!empty($websiteById)) {

            $databaseAccountByUsername = DatabaseAccountRepository::findOneByUsernameNotDatabaseId($database->_id, $request->account["username"], $websiteById->_id);

            if(empty($databaseAccountByUsername)) {

                if(!empty($request->account["username"])) {

                    $databaseAccountById = DatabaseAccountRepository::findOneByDatabaseId($database->_id, $websiteById->_id);

                    if(!empty($databaseAccountById)) {

                        $databaseAccountById->username = $request->account["username"];
                        DatabaseAccountRepository::update($account, $databaseAccountById, $websiteById->_id);

                    }

                    $playerAttemptByUsername = PlayerAttemptRepository::findOneByUsername($account->nucode, $request->account["username"]);

                    if(!empty($playerAttemptByUsername)) {

                        $playerAttemptByUsername->status = self::initializeStatusData($playerAttemptByUsername, $request->status);
                        $playerAttemptByUsername->total += 1;
                        $playerAttemptByUsername->website = self::initializeWebsiteData($playerAttemptByUsername, $websiteById);
                        PlayerAttemptRepository::update($account, $playerAttemptByUsername);

                    }

                }

                $databaseAttempt->status = self::initializeStatusData($databaseAttempt, $request->status);
                $databaseAttempt->total += 1;
                $databaseAttempt->website = self::initializeWebsiteData($databaseAttempt, $websiteById);
                DatabaseAttemptRepository::update($account, $databaseAttempt);

                if(is_null($request->reference)) {

                    $request->reference = "";

                }

                $databaseLogById = DatabaseLogRepository::findOneById($request->log["id"], $websiteById->_id);

                if(!empty($databaseLogById)) {

                    $databaseLogById->status = $request->status;
                    DatabaseLogRepository::update($account, $databaseLogById, $websiteById->_id);

                } else {

                    $databaseLog = new DatabaseLog();
                    $databaseLog->database = [
                        "_id" => DataComponent::initializeObjectId($database->_id),
                        "name" => $database->name
                    ];
                    $databaseLog->status = $request->status;
                    $databaseLog->user = [
                        "_id" => DataComponent::initializeObjectId($account->_id),
                        "avatar" => $account->avatar,
                        "name" => $account->name,
                        "username" => $account->username
                    ];
                    $databaseLog->website = [
                        "_id" => DataComponent::initializeObjectId($websiteById->_id),
                        "name" => $websiteById->name
                    ];
                    DatabaseLogRepository::insert($account, $databaseLog, $websiteById->_id);

                }

                $reportByDateUserId = ReportRepository::findOneByDateUserId(new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0)), $account->nucode, $account->_id);

                if(!empty($reportByDateUserId)) {

                    $reportByDateUserId->status = self::initializeStatusData($reportByDateUserId, $request->status);
                    $reportByDateUserId->total += 1;
                    $reportByDateUserId->website = self::initializeWebsiteData($reportByDateUserId, $websiteById);
                    ReportRepository::update($account, $reportByDateUserId);

                } else {

                    $report = new Report();
                    $report->date = new UTCDateTime(Carbon::now()->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0));
                    $report->status = [
                        "names" => [$request->status],
                        "totals" => [1]
                    ];
                    $report->total = 1;
                    $report->user = [
                        "_id" => DataComponent::initializeObjectId($account->_id),
                        "avatar" => $account->avatar,
                        "name" => $account->name,
                        "username" => $account->username
                    ];
                    $report->website = [
                        "ids" => [$websiteById->_id],
                        "names" => [$websiteById->name],
                        "totals" => [1]
                    ];
                    ReportRepository::insert($account, $report);

                }

                $result->response = "Worksheet data updated";
                $result->result = true;

            } else {

                $result->response = "Username already exist";

            }

        }

        return $result;

    }


}
