<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSyncQueuesTable extends Migration {


    private function createIndex($table) {

        $table->date("date")->index();
        $table->string("nucode")->index();
        $table->string("status")->index();
        $table->string("website._id")->index();
        $table->string("website.name")->index();
        $table->date("created.timestamp")->index();
        $table->date("modified.timestamp")->index();

    }


    public function up() {

        if(!Schema::hasTable("syncQueue")) {

            Schema::create("syncQueue", function(Blueprint $table) {

                $this->createIndex($table);

            });

        } else {

            Schema::table("syncQueue", function(Blueprint $table) {

                $this->createIndex($table);

            });

        }

    }


    public function down() {

        Schema::dropIfExists("syncQueue");

    }


}
