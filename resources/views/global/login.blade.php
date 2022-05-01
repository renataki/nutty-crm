@include("global.head")
<body class="authentication-bg">
<div class="account-pages my-5 pt-sm-5" ng-controller="login">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{config("app.url")}}/" class="mb-5 d-block auth-logo">
                        <img src="{{asset("resources/images/logo-dark.png")}}" alt="" height="22"
                             class="logo logo-dark">
                        <img src="{{asset("resources/images/logo-light.png")}}" alt="" height="22"
                             class="logo logo-light">
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue to {{Component::appName()}}.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form>
                                @if(config("app.nucode") == "PUBLIC")
                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <input id="nutty-crm-nucode" class="form-control" type="text"
                                               placeholder="Company" ng-model="nucode.value"/>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input id="nutty-crm-username" class="form-control" type="text"
                                           placeholder="Username" ng-model="username.value"/>
                                </div>
                                <div class="mb-3">
                                    <div class="float-end">
                                        <a href="#" class="text-muted">Forgot password?</a>
                                    </div>
                                    <label class="form-label">Password</label>
                                    <input id="nutty-crm-password" class="form-control" type="password"
                                           placeholder="Password" ng-model="password.value" ng-keyup="login($event)">
                                </div>
                                <div class="form-check">
                                    <input id="nutty-crm-remember-me" class="form-check-input" type="checkbox"/>
                                    <label class="form-check-label">Remember me</label>
                                </div>
                                <div class="mt-3 text-end">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"
                                            ng-click="login($event)">Log In
                                    </button>
                                </div>
                                @if(config("app.nucode") == "PUBLIC")
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">
                                            Don't have an account ?
                                            <a href="{{config("app.url")}}/register/" class="fw-medium text-primary">Signup
                                                now</a>
                                        </p>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>© {{date("Y")}} {{Component::appName()}}. Crafted with <i class="mdi mdi-heart text-danger"></i>
                        by Nutty Developer</p>
                </div>
            </div>
        </div>
    </div>
</div>
@include("global.foot")
