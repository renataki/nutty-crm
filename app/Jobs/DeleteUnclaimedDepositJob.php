<?php

namespace App\Jobs;

use App\Repositories\UnclaimedDepositRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;


class DeleteUnclaimedDepositJob implements ShouldQueue {


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $websiteId;


    public function __construct($websiteId) {

        $this->websiteId = $websiteId;

    }


    public function handle() {

        $createdTimestamp = Carbon::now()->subDays(30)->setHour(0)->setMinute(0)->setSecond(0)->setMicrosecond(0);
        UnclaimedDepositRepository::deleteLteCreatedTimestamp(new UTCDateTime($createdTimestamp), $this->websiteId);

    }


}
