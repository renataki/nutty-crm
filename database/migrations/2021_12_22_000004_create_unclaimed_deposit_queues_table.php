<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUnclaimedDepositQueuesTable extends Migration {


    private function createIndex($table) {

        $table->string("date")->index();
        $table->string("nucode")->index();
        $table->string("status")->index();
        $table->string("website._id")->index();
        $table->string("website.name")->index();
        $table->date("created.timestamp")->index();
        $table->date("modified.timestamp")->index();

    }


    public function up() {

        if(!Schema::hasTable("unclaimedDepositQueue")) {

            Schema::create("unclaimedDepositQueue", function(Blueprint $table) {

                $this->createIndex($table);

            });

        } else {

            Schema::table("unclaimedDepositQueue", function(Blueprint $table) {

                $this->createIndex($table);

            });

        }

    }


    public function down() {

        Schema::dropIfExists("unclaimedDepositQueue");

    }


}
