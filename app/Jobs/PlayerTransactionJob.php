<?php

namespace App\Jobs;

use App\Repositories\WebsiteRepository;
use App\Services\ApiNexusService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class PlayerTransactionJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $fromDate;

    public $page;

    public $toDate;


    public function __construct($fromDate, $page, $toDate) {

        $this->fromDate = $fromDate;
        $this->page = $page;
        $this->toDate = $toDate;

    }


    public function handle() {

        $websites = WebsiteRepository::findPageNotApiNexusSaltStart("", "", $this->page, config("app.api.nexus.batch.size.website"));

        if(!$websites->isEmpty()) {

            foreach($websites as $value) {

                if(!empty($value->api["nexus"]["code"]) && !empty($value->api["nexus"]["salt"]) && !empty($value->api["nexus"]["url"])) {

                    $fromDate = $this->fromDate . "T00:00:00";
                    $toDate = $this->toDate . "T00:00:00";
                    $apiNexusPlayerTransaction = ApiNexusService::findPlayerTransaction($value->api["nexus"]["code"], $fromDate, $toDate, $value->api["nexus"]["salt"], $value->api["nexus"]["url"]);

                    if($apiNexusPlayerTransaction->result) {

                        ApiNexusService::savePlayerTransaction($apiNexusPlayerTransaction->content->data->bankTransactionList, $value->_id);

                    }

                }

            }

        }

    }


}
