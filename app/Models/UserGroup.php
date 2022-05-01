<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class UserGroup extends Model {


    use HasFactory;


    protected $attributes = [
        "description" => "",
        "name" => "",
        "nucode" => "",
        "status" => "",
        "website" => [
            "ids" => [],
            "names" => []
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
        "status",
        "website->ids",
        "website->names",
        "created->timestamp",
        "created->user->_id",
        "created->user->username",
        "modified->timestamp",
        "modified->user->_id",
        "modified->user->username"
    ];

    protected $table = "userGroup";

    public $timestamps = false;


}
