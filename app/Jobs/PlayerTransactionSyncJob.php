<?php

namespace App\Jobs;

use App\Components\DataComponent;
use App\Repositories\WebsiteRepository;
use App\Services\ApiNexusService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;


class PlayerTransactionSyncJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $dateEnd;

    public $dateStart;

    public $loop;

    public $merchantCode;

    public $number;

    public $salt;

    public $url;

    public $websiteId;


    public function __construct($dateEnd, $dateStart, $loop, $merchantCode, $number, $salt, $url, $websiteId) {

        $this->dateEnd = $dateEnd;
        $this->dateStart = $dateStart;
        $this->loop = $loop;
        $this->merchantCode = $merchantCode;
        $this->number = $number;
        $this->salt = $salt;
        $this->url = $url;
        $this->websiteId = $websiteId;

    }


    public function handle() {

        if(!empty($this->dateEnd) && !empty($this->dateStart) && !empty($this->merchantCode) && !empty($this->salt) && !empty($this->url)) {

            $fromDate = Carbon::createFromFormat("Y/m/d", $this->dateStart)->format("Y-m-d") . "T00:00:00";
            $toDate = Carbon::createFromFormat("Y/m/d", $this->dateEnd)->format("Y-m-d") . "T00:00:00";
            $apiNexusPlayerTransaction = ApiNexusService::findPlayerTransaction($this->merchantCode, $fromDate, $toDate, $this->salt, $this->url);

            if($apiNexusPlayerTransaction->result) {

                ApiNexusService::savePlayerTransaction($apiNexusPlayerTransaction->content->data->bankTransactionList, $this->websiteId);

            }

        }

        if($this->number == $this->loop) {

            $account = DataComponent::initializeSystemAccount();

            $websiteById = WebsiteRepository::findOneById($this->websiteId);

            if(!empty($websiteById)) {

                $websiteById->sync = "Synced";
                WebsiteRepository::update($account, $websiteById);

            }

        }

    }


}
