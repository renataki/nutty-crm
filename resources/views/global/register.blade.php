@include("global.head")
<body class="authentication-bg">
<div class="account-pages my-5 pt-sm-5" ng-controller="register">
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
                            <h5 class="text-primary">Register Account</h5>
                            <p class="text-muted">Get your {{Component::appName()}} account now.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Company</label>
                                    <input id="register-nucode" class="form-control" type="text"
                                           placeholder="Enter company name" ng-model="nucode.value"
                                           ng-keyup="checkFormLengthRequired('nucode.value', 'register-nucode', 'response-nucode', 2, 50)"/>
                                    <div id="response-nucode"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input id="register-name" class="form-control" type="text"
                                           placeholder="Enter name" ng-model="name.value"
                                           ng-keyup="checkFormLengthRequired('name.value', 'register-name', 'response-name', 3, 50)"/>
                                    <div id="response-name"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input id="register-contact-email" class="form-control" type="text"
                                           placeholder="Enter email" ng-model="contact.email.value"
                                           ng-keyup="checkFormEmail('contact.email.value', 'register-contact-email', 'response-contact-email')"/>
                                    <div id="response-contact-email"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input id="register-username" class="form-control" type="text"
                                           placeholder="Enter username" ng-model="username.value"
                                           ng-keyup="checkFormLengthRequired('username.value', 'register-username', 'response-username', 3, 20)"/>
                                    <div id="response-username"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input id="register-password" class="form-control" type="password"
                                           placeholder="Enter password" ng-model="password.value"
                                           ng-keyup="checkFormPassword('password.value', 'register-password', 'response-password')"/>
                                    <div id="response-password"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input id="register-password-confirm" class="form-control" type="password"
                                           placeholder="Confirm password" ng-model="password.confirm.value"
                                           ng-keyup="checkFormPasswordConfirm('password.confirm.value', 'password.value', 'register-password-confirm', 'response-password-confirm')"/>
                                    <div id="response-password-confirm"></div>
                                </div>
                                <div class="form-check">
                                    <input id="register-terms-condition" class="form-check-input" type="checkbox"
                                           ng-checked="termsCondition.value" ng-click="toggleTermsCondition()"/>
                                    <label class="form-check-label">
                                        I accept
                                        <a class="text-dark" ng-click="toggleTermsCondition()">Terms and Conditions</a>
                                    </label>
                                </div>
                                <div class="mt-3 text-end">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"
                                            ng-click="register($event)">
                                        Register
                                    </button>
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-muted mb-0">
                                        Already have an account ?
                                        <a href="{{config("app.url")}}/login/" class="fw-medium text-primary">Login</a>
                                    </p>
                                </div>
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
