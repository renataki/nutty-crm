<?php

namespace App\Http\Middleware;

use App\Components\GlobalComponent;
use App\Repositories\UserLogRepository;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class Authentication {


    public function handle(Request $request, Closure $next) {

        $result = "Logged Out";

        if($request->session()->has("account")) {

            $result = "Logged In";

        } else {

            if($request->hasCookie(GlobalComponent::appPrefix() . "sid")) {

                $authentication = $request->cookie(GlobalComponent::appPrefix() . "sid");

                $types = [
                    "Login",
                    "Logout"
                ];
                $userLogByAuthenticationInType = UserLogRepository::findOneByAuthenticationInType($authentication, $types);

                if(!empty($userLogByAuthenticationInType)) {

                    if($userLogByAuthenticationInType->type == "Login") {

                        $userByIdStatus = UserRepository::findOneByIdStatus($userLogByAuthenticationInType->user["_id"], "Active");

                        if(!empty($userByIdStatus)) {

                            $request->session()->put("account", $userByIdStatus);

                            $result = "Logged In";

                        }

                    } else {

                        $request->session()->forget("account");
                        $request->session()->forget("websiteId");
                        $request->session()->flush();

                        Cookie::queue(Cookie::forget(GlobalComponent::appPrefix() . "sid"));

                    }

                }

            }

        }

        if($result == "Logged In") {

            if(str_contains($request->getPathInfo(), "/login")) {

                return redirect("/");

            }

        } else {

            if(!str_contains($request->getPathInfo(), "/login") && !str_contains($request->getPathInfo(), "/register")) {

                return redirect("/login/");

            }

        }

        return $next($request);

    }


}
