<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration {

    private function createIndex($table) {

        $table->string("name")->index();
        $table->string("nucode")->index();
        $table->string("description")->index();
        $table->string("textMessage")->index();
        $table->string("media")->index();
        $table->string("isDefault")->index();
        $table->string("status")->index();
        $table->date("created.timestamp")->index();
        $table->date("modified.timestamp")->index();
    }

    public function up() {

        if(!Schema::hasTable("template")) {

            Schema::create("template", function(Blueprint $table) {

                $this->createIndex($table);

            });

        } else {

            Schema::table("template", function(Blueprint $table) {

                $this->createIndex($table);

            });

        }

    }


    public function down() {
        Schema::dropIfExists("template");
    }
}
