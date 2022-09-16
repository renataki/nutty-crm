<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class User extends Model {


    use HasFactory;


    protected $attributes = [

        "avatar" => "",
        "city" => "",
        "contact" => [
            "email" => "",
            "fax" => "",
            "line" => "",
            "michat" => "",
            "phone" => "",
            "telegram" => "",
            "wechat" => "",
            "whatsapp" => ""
        ],
        "country" => "",
        "gender" => "",
        "group" => [
            "_id" => "",
            "name" => ""
        ],
        "language" => "",
        "name" => "",
        "nucode" => "",
        "password" => [
            "main" => "",
            "recovery" => ""
        ],
        "privilege" => [
            "database" => "0000",
            "report" => "0000",
            "setting" => "0000",
            "settingApi" => "0000",
            "template" => "0000",
            "user" => "0000",
            "userGroup" => "0000",
            "userRole" => "0000",
            "website" => "0000",
            "worksheet" => "0000",
        ],
        "role" => [
            "_id" => "",
            "name" => ""
        ],
        "state" => "",
        "status" => "",
        "street" => "",
        "type" => "",
        "username" => "",
        "zip" => "",
        "created" => [
            "timestamp" => "",
            "user" => [
                "_id" => "0",
                "username" => "System"
            ]
        ],
        "modified" => [
            "timestamp" => "",
            "user" => [
                "_id" => "0",
                "username" => "System"
            ]
        ]
    ];

    protected $fillable = [
        "avatar",
        "city",
        "contact->email",
        "contact->fax",
        "contact->line",
        "contact->michat",
        "contact->phone",
        "contact->telegram",
        "contact->wechat",
        "contact->whatsapp",
        "country",
        "gender",
        "group->_id",
        "group->name",
        "language",
        "name",
        "nucode",
        "password->main",
        "password->recovery",
        "privilege->database",
        "privilege->report",
        "privilege->setting",
        "privilege->settingApi",
        "privilege->template",
        "privilege->user",
        "privilege->userGroup",
        "privilege->userRole",
        "privilege->website",
        "privilege->worksheet",
        "role->_id",
        "role->name",
        "state",
        "status",
        "street",
        "type",
        "username",
        "zip",
        "created->timestamp",
        "created->user->_id",
        "created->user->username",
        "modified->timestamp",
        "modified->user->_id",
        "modified->user->username"
    ];

    protected $table = "user";

    public $timestamps = false;


}
