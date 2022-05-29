<?php

namespace App\Jobs;

use App\Models\DatabaseAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;


class MigrationJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $page;

    public $size;

    public $websiteId;


    public function __construct($page, $size, $websiteId) {

        $this->page = $page;
        $this->size = $size;
        $this->websiteId = $websiteId;

    }


    public function handle() {

        $data = [
            "sync" => [
                "_id" => "0",
                "timestamp" => new UTCDateTime(Carbon::createFromFormat("Y-m-d H:i:s", "1970-01-10 00:00:00"))
            ]
        ];
        $databaseAccount = new DatabaseAccount();
        $databaseAccount->setTable("databaseAccount_" . $this->websiteId);
        $databaseAccount->where([
            ["sync.timestamp", "=", null]
        ])->orderBy("created.timestamp", "ASC")->take($this->size)->update($data, ["upsert" => false]);

    }


}
