<?php

namespace App\Jobs;

use App\Components\DataComponent;
use App\Models\Database;
use App\Models\DatabaseAccount;
use App\Models\DatabaseAttempt;
use App\Models\DatabaseLog;
use App\Models\Report;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;


class MigrationJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $page;

    public $size;


    public function __construct($page, $size) {

        $this->page = $page;
        $this->size = $size;

    }


    public function handle() {

        $databases = Database::where([])->orderBy("created.timestamp", "ASC")->forPage($this->page, $this->size)->get();

        if(!$databases->isEmpty()) {

            foreach($databases as $value) {

                $databaseAccounts = DatabaseAccount::where([
                    ["database._id", "=", $value->_id]
                ])->first();

                foreach($value->website["ids"] as $keyChild1 => $valueChild1) {

                    if(!empty($databaseAccounts)) {

                        $database = new Database();
                        $database->city = $databaseAccounts->city;
                        $database->contact = [
                            "email" => strval($value->contact["email"]),
                            "line" => strval($value->contact["line"]),
                            "michat" => strval($value->contact["michat"]),
                            "phone" => strval($value->contact["phone"]),
                            "telegram" => strval(""),
                            "wechat" => strval($value->contact["wechat"]),
                            "whatsapp" => strval($value->contact["whatsapp"])
                        ];
                        $database->country = $databaseAccounts->country;

                        if(array_key_exists($keyChild1, $value->crm["ids"])) {

                            $database->crm = [
                                "_id" => DataComponent::initializeObjectId($value->crm["ids"][$keyChild1]),
                                "avatar" => $value->crm["avatars"][$keyChild1],
                                "name" => $value->crm["names"][$keyChild1],
                                "username" => $value->crm["usernames"][$keyChild1]
                            ];

                        } else {

                            $database->crm = [
                                "_id" => "0",
                                "avatar" => "",
                                "name" => "System",
                                "username" => "system"
                            ];

                        }

                        $database->gender = $databaseAccounts->gender;
                        $database->group = $value->group;
                        $database->import = $value->import;
                        $database->language = $databaseAccounts->language;
                        $database->name = $value->name;
                        $database->reference = $value->reference;
                        $database->state = $databaseAccounts->state;

                        $index = array_search($valueChild1, $value->attempt["website"]["ids"]);

                        if(gettype($index) == "integer") {

                            if($value->attempt["statuses"][$index] == "Pending") {

                                $database->status = "Reserved";

                            } else {

                                $database->status = "Processed";

                            }

                        } else {

                            $database->status = "Available";

                        }

                        $database->street = $databaseAccounts->street;

                        if(array_key_exists($keyChild1, $value->telemarketer["ids"])) {

                            $database->telemarketer = [
                                "_id" => DataComponent::initializeObjectId($value->telemarketer["ids"][$keyChild1]),
                                "avatar" => $value->telemarketer["avatars"][$keyChild1],
                                "name" => $value->telemarketer["names"][$keyChild1],
                                "username" => $value->telemarketer["usernames"][$keyChild1]
                            ];

                        } else {

                            $database->telemarketer = [
                                "_id" => "0",
                                "avatar" => "",
                                "name" => "System",
                                "username" => "system"
                            ];

                        }

                        $database->zip = $databaseAccounts->zip;
                        $database->created = $value->created;
                        $database->modified = $value->modified;
                        $database->setTable("database_" . $valueChild1);

                        try {

                            $database->save();

                        } catch(Exception $exception) {

                            Log::error($database->contact["phone"] . " " . $exception->getMessage());

                        }

                        if(!empty($database->_id)) {

                            $index = array_search($valueChild1, $databaseAccounts->account["website"]["ids"]);

                            if(gettype($index) == "integer") {

                                if(!empty($databaseAccounts->account["usernames"][$index])) {

                                    $databaseAccount = new DatabaseAccount();
                                    $databaseAccount->database = [
                                        "_id" => DataComponent::initializeObjectId($database->_id),
                                        "name" => $database->name
                                    ];
                                    $databaseAccount->deposit = [
                                        "average" => [
                                            "amount" => $databaseAccounts->deposit["average"]["amounts"][$index]
                                        ],
                                        "first" => [
                                            "amount" => $databaseAccounts->deposit["first"]["amounts"][$index],
                                            "timestamp" => $databaseAccounts->deposit["first"]["timestamps"][$index]
                                        ],
                                        "last" => [
                                            "amount" => $databaseAccounts->deposit["last"]["amounts"][$index],
                                            "timestamp" => $databaseAccounts->deposit["last"]["timestamps"][$index]
                                        ],
                                        "total" => [
                                            "amount" => $databaseAccounts->deposit["total"]["amounts"][$index]
                                        ]
                                    ];
                                    $databaseAccount->games = [];
                                    $databaseAccount->login = [
                                        "average" => [
                                            "daily" => $databaseAccounts->login["average"]["dailies"][$index],
                                            "monthly" => $databaseAccounts->login["average"]["monthlies"][$index],
                                            "weekly" => $databaseAccounts->login["average"]["weeklies"][$index],
                                            "yearly" => $databaseAccounts->login["average"]["yearlies"][$index]
                                        ],
                                        "first" => [
                                            "timestamp" => $databaseAccounts->login["first"]["timestamps"][$index]
                                        ],
                                        "last" => [
                                            "timestamp" => $databaseAccounts->login["last"]["timestamps"][$index]
                                        ],
                                        "total" => [
                                            "amount" => $databaseAccounts->login["total"]["amounts"][$index]
                                        ]
                                    ];
                                    $databaseAccount->reference = $databaseAccounts->references[$index];
                                    $databaseAccount->register = [
                                        "timestamp" => $databaseAccounts->register["timestamps"][$index]
                                    ];
                                    $databaseAccount->username = $databaseAccounts->account["usernames"][$index];
                                    $databaseAccount->withdrawal = [
                                        "average" => [
                                            "amount" => $databaseAccounts->withdrawal["average"]["amounts"][$index]
                                        ],
                                        "first" => [
                                            "amount" => $databaseAccounts->withdrawal["first"]["amounts"][$index],
                                            "timestamp" => $databaseAccounts->withdrawal["first"]["timestamps"][$index]
                                        ],
                                        "last" => [
                                            "amount" => $databaseAccounts->withdrawal["last"]["amounts"][$index],
                                            "timestamp" => $databaseAccounts->withdrawal["last"]["timestamps"][$index]
                                        ],
                                        "total" => [
                                            "amount" => $databaseAccounts->withdrawal["total"]["amounts"][$index]
                                        ]
                                    ];
                                    $databaseAccount->created = $value->created;
                                    $databaseAccount->modified = $value->modified;
                                    $databaseAccount->setTable("databaseAccount_" . $valueChild1);

                                    try {

                                        $databaseAccount->save();

                                    } catch(Exception $exception) {

                                        Log::error($database->contact["phone"] . " " . $exception->getMessage());

                                    }

                                }

                            }

                            $databaseAttemptByContactPhone = new DatabaseAttempt();
                            $databaseAttemptByContactPhone->setTable("databaseAttempt_" . config("app.nucode"));
                            $databaseAttemptByContactPhone = $databaseAttemptByContactPhone->where([
                                ["contact.phone", "=", $database->contact["phone"]]
                            ])->first();

                            $databaseAttempt = new DatabaseAttempt();
                            $databaseAttempt->setTable("databaseAttempt_" . config("app.nucode"));
                            $status = [
                                "names" => [],
                                "totals" => []
                            ];
                            $total = 0;
                            $website = [
                                "ids" => [],
                                "names" => [],
                                "totals" => []
                            ];

                            if(!empty($databaseAttemptByContactPhone)) {

                                $databaseAttempt = $databaseAttemptByContactPhone;
                                $status = $databaseAttemptByContactPhone->status;
                                $total = $databaseAttemptByContactPhone->total;
                                $website = $databaseAttemptByContactPhone->website;

                            }

                            foreach($value->attempt["statuses"] as $valueChild2) {

                                $index = array_search($valueChild2, $status["names"]);

                                if(gettype($index) == "integer") {

                                    $status["totals"][$index]++;

                                } else {

                                    array_push($status["names"], $valueChild2);
                                    array_push($status["totals"], 1);

                                }

                                $total++;

                            }

                            foreach($value->attempt["website"]["ids"] as $keyChild2 => $valueChild2) {

                                $index = array_search($valueChild2, $website["ids"]);

                                if(gettype($index) == "integer") {

                                    $website["totals"][$index]++;

                                } else {

                                    array_push($website["ids"], $valueChild2);
                                    array_push($website["names"], $value->attempt["website"]["names"][$keyChild2]);
                                    array_push($website["totals"], 1);

                                }

                            }

                            $databaseAttempt->contact = $database->contact;
                            $databaseAttempt->status = $status;
                            $databaseAttempt->total = $total;
                            $databaseAttempt->website = $website;
                            $databaseAttempt->created = $value->created;
                            $databaseAttempt->modified = $value->modified;

                            try {

                                $databaseAttempt->save();

                            } catch(Exception $exception) {

                                Log::error($database->contact["phone"] . " " . $exception->getMessage());

                            }

                            $index = array_search($valueChild1, $value->attempt["website"]["ids"]);

                            if(gettype($index) == "integer") {

                                $userById = UserRepository::findOneById($value->attempt["user"]["ids"][$index]);

                                if(!empty($userById)) {

                                    $reference = "";

                                    $report = Report::where([
                                        [
                                            "date",
                                            "=",
                                            new UTCDateTime(Carbon::create($value->attempt["timestamps"][$index]->toDateTime()->getTimestamp())->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0))
                                        ],
                                        ["created.user._id", "=", $userById->_id]
                                    ])->first();

                                    if(!empty($report)) {

                                        $index = array_search($valueChild1, $report->attempt["website"]["ids"]);

                                        if(gettype($index) == "integer") {

                                            $reference = $report->database["references"][$index];

                                        }

                                    }

                                    $databaseLog = new DatabaseLog();
                                    $databaseLog->database = [
                                        "_id" => DataComponent::initializeObjectId($database->_id),
                                        "name" => $database->name
                                    ];
                                    $databaseLog->reference = $reference;
                                    $databaseLog->status = $value->attempt["statuses"][$index];
                                    $databaseLog->user = [
                                        "_id" => DataComponent::initializeObjectId($userById->_id),
                                        "avatar" => $userById->avatar,
                                        "name" => $userById->name,
                                        "username" => $userById->username
                                    ];
                                    $databaseLog->website = [
                                        "_id" => DataComponent::initializeObjectId($valueChild1),
                                        "name" => $value->attempt["website"]["names"][$index]
                                    ];
                                    $databaseLog->created = [
                                        "timestamp" => $value->attempt["timestamps"][$index],
                                        "user" => [
                                            "_id" => DataComponent::initializeObjectId($userById->_id),
                                            "avatar" => $userById->avatar,
                                            "name" => $userById->name,
                                            "username" => $userById->username
                                        ]
                                    ];
                                    $databaseLog->modified = [
                                        "timestamp" => $value->attempt["timestamps"][$index],
                                        "user" => [
                                            "_id" => DataComponent::initializeObjectId($userById->_id),
                                            "avatar" => $userById->avatar,
                                            "name" => $userById->name,
                                            "username" => $userById->username
                                        ]
                                    ];
                                    $databaseLog->setTable("databaseLog_" . $valueChild1);

                                    try {

                                        $databaseLog->save();

                                    } catch(Exception $exception) {

                                        Log::error($database->contact["phone"] . " " . $exception->getMessage());

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

    }


}
