@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="user">
    <div class="page-content" ng-init="initializeData('{{$model->user->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User Entry</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/user/">User</a></li>
                                <li class="breadcrumb-item active">Entry</li>
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
                                        <label class="form-label">Username</label>
                                        <input id="user-username" class="form-control" type="text"
                                               ng-model="username.value"
                                               ng-keyup="checkFormLengthRequired('username.value', 'user-username', 'response-username', 3, 20)"/>
                                        <div id="response-username"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input id="user-name" class="form-control" type="text" ng-model="name.value"
                                               ng-keyup="checkFormLengthRequired('name.value', 'user-name', 'response-name', 3, 50)"/>
                                        <div id="response-name"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
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
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <div class="mb-3">
                                                <label class="form-label">Nucode</label>
                                                <input id="user-nucode" class="form-control" type="text"
                                                       ng-model="nucode.value"
                                                       ng-keyup="checkFormLength('nucode.value', 'user-nucode', 'response-nucode', 2, 50)"/>
                                                <div id="response-nucode"></div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <select id="user-type" class="form-control select2"
                                                data-error="Please select type" data-input="user-type"
                                                data-required="true" data-response="response-type"
                                                data-scope="type.value">
                                            <option value="">Type</option>
                                            <option value="Administrator">Administrator</option>
                                            <option value="CRM">CRM</option>
                                            <option value="Telemarketer">Telemarketer</option>
                                        </select>
                                        <div id="response-type"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select id="user-role" class="form-control select2"
                                                data-error="Please select role" data-input="user-role"
                                                data-required="true" data-response="response-role"
                                                data-scope="role.value">
                                            <option value="">Role</option>
                                            @foreach($model->userRoles as $value)
                                                <option value="{{$value->_id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <div id="response-role"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Group</label>
                                        <select id="user-group" class="form-control select2"
                                                data-error="Please select group" data-input="user-group"
                                                data-required="true" data-response="response-group"
                                                data-scope="group.value">
                                            <option value="">Group</option>
                                            @foreach($model->userGroups as $value)
                                                <option value="{{$value->_id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <div id="response-group"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select id="user-status" class="form-control select2"
                                                data-error="Please select status" data-input="user-status"
                                                data-required="true" data-response="response-status"
                                                data-scope="status.value">
                                            <option value="">Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <div id="response-status"></div>
                                    </div>
                                    <div class="mb-3">
                                        @if($model->user->_id != null)
                                            <button class="btn btn-warning waves-effect waves-light me-1"
                                                    ng-click="update($event)">Edit
                                            </button>
                                        @else
                                            <button class="btn btn-success waves-effect waves-light me-1"
                                                    ng-click="insert($event)">Add New
                                            </button>
                                        @endif
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
