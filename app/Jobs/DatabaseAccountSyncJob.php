<?php

namespace App\Jobs;

use App\Repositories\DatabaseAccountRepository;
use App\Services\DatabaseAccountService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class DatabaseAccountSyncJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $loop;

    public $page;

    public $websiteId;


    public function __construct($loop, $page, $websiteId) {

        $this->loop = $loop;
        $this->page = $page;
        $this->websiteId = $websiteId;

    }


    public function handle() {

        $sort = [
            "direction" => "ASC",
            "field" => "created.timestamp"
        ];
        $databaseAccounts = DatabaseAccountRepository::findPageSort($this->page, config("app.api.nexus.batch.size.player"), $sort, $this->websiteId);

        if(!$databaseAccounts->isEmpty()) {

            foreach($databaseAccounts as $value) {

                DatabaseAccountService::sync($value->_id, $this->websiteId);

            }

        }

    }


}
