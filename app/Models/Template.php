<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class Template extends Model {


    use HasFactory;


    protected $attributes = [
        "description" => "",
        "name" => "",
        "nucode" => "",
        "textMessage" => "",
        "isDefault" => "false",
        "status" => "Inactive",
        "media" => [
            "mediaType" => "",
            "mediaUrl" => ""
        ],
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
        "description",
        "name",
        "nucode",
        "textMessage",
        "isDefault",
        "status",
        "media",
        "created->timestamp",
        "created->user->_id",
        "created->user->username",
        "modified->timestamp",
        "modified->user->_id",
        "modified->user->username"
    ];

    protected $table = "template";

    public $timestamps = false;


}
