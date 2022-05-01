@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="user">
    <div class="page-content" ng-init="profileInitializeData('{{Session::get("account")->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Profile</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/user/">User</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input id="user-password-current" class="form-control" type="password"
                                               ng-model="password.current.value"
                                               ng-keyup="checkFormPassword('password.current.value', 'user-password-current', 'response-password-current')"/>
                                        <div id="response-password-current"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input id="user-password" class="form-control" type="password"
                                               ng-model="password.value"
                                               ng-keyup="checkFormPassword('password.value', 'user-password', 'response-password')"/>
                                        <div id="response-password"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input id="user-password-confirm" class="form-control" type="password"
                                               ng-model="password.confirm.value"
                                               ng-keyup="checkFormPasswordConfirm('password.confirm.value', 'password.value', 'user-password-confirm', 'response-password-confirm')"/>
                                        <div id="response-password-confirm"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-warning waves-effect waves-light me-1"
                                                ng-click="updatePassword($event)">Update
                                        </button>
                                        <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include("global.footer")
@include("global.foot")
