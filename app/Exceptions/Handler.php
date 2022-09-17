<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;


class Handler extends ExceptionHandler {


    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [//
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {

        $this->reportable(function(Throwable $e) {

            $text = urlencode("<b>" . config("app.name") . "</b>\n\n" . $e->getMessage() . "\n\nPlease check the details on \"storage > logs > nutty-crm-" . date("Y-m-d") . ".log\"");
            $content = config("app.bot.telegram.url") . "/bot" . config("app.bot.telegram.token") . "/sendMessage?chat_id=" . config("app.bot.telegram.chatid") . "&text=" . $text . "&parse_mode=html";
            file_get_contents($content, true);

        });
    }


}
