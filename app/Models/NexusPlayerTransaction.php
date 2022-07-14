<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class NexusPlayerTransaction extends Model {


    use HasFactory;


    protected $attributes = [
        "adjustment" => [
            "reference" => ""
        ],
        "amount" => [
            "final" => 0,
            "request" => 0
        ],
        "approved" => [
            "timestamp" => "",
            "user" => [
                "_id" => "0",
                "username" => "System"
            ]
        ],
        "bank" => [
            "account" => [
                "from" => [
                    "name" => "",
                    "number" => ""
                ],
                "to" => [
                    "name" => "",
                    "number" => ""
                ]
            ],
            "from" => "",
            "to" => ""
        ],
        "claim" => false,
        "fee" => [
            "admin" => 0
        ],
        "reference" => "",
        "requested" => [
            "timestamp" => "",
            "user" => [
                "_id" => "0",
                "username" => "System"
            ]
        ],
        "transaction" => [
            "code" => "",
            "type" => ""
        ],
        "user" => [
            "_id" => "0",
            "avatar" => "",
            "name" => "System",
            "username" => "system"
        ],
        "username" => "",
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
        "adjustment->reference",
        "amount->final",
        "amount->request",
        "approved->timestamp",
        "approved->user->_id",
        "approved->user->username",
        "bank->account->from->name",
        "bank->account->from->number",
        "bank->account->to->name",
        "bank->account->to->number",
        "bank->from",
        "bank->to",
        "claim",
        "fee->admin",
        "reference",
        "requested->timestamp",
        "requested->user->_id",
        "requested->user->username",
        "transaction->code",
        "transaction->type",
        "user->_id",
        "user->avatar",
        "user->name",
        "user->username",
        "username",
        "created->timestamp",
        "created->user->_id",
        "created->user->username",
        "modified->timestamp",
        "modified->user->_id",
        "modified->user->username"
    ];

    protected $table = "nexusPlayerTransactionHistory";

    public $timestamps = false;


}
