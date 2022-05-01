@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="userRole">
    <div class="page-content" ng-init="initializeData('{{$model->userRole->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User Role Entry</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/user/">User</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/user/role/">Role</a></li>
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
                                        <label class="form-label">Name</label>
                                        <input id="user-role-name" class="form-control" type="text"
                                               ng-model="name.value"
                                               ng-keyup="checkFormLengthRequired('name.value', 'user-role-name', 'response-name', 3, 50)"/>
                                        <div id="response-name"></div>
                                    </div>
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <div class="mb-3">
                                                <label class="form-label">Nucode</label>
                                                <input id="user-role-nucode" class="form-control" type="text"
                                                       ng-model="nucode.value"
                                                       ng-keyup="checkFormLength('nucode.value', 'user-role-nucode', 'response-nucode', 2, 50)"/>
                                                <div id="response-nucode"></div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input id="user-role-description" class="form-control" type="text"
                                               ng-model="description.value"
                                               ng-keyup="checkFormLength('description.value', 'user-role-description', 'response-description', 3, 250)"/>
                                        <div id="response-description"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select id="user-role-status" class="form-control select2"
                                                data-error="Please select status" data-input="user-role-status"
                                                data-required="true" data-response="response-status"
                                                data-scope="status.value">
                                            <option value="">Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <div id="response-status"></div>
                                    </div>
                                    <h6 class="mt-3 mb-3">Privileges</h6>
                                    <div ng-repeat="(key, value) in privileges" class="row mb-3">
                                        <div class="col-2">
                                            <label class="form-label" ng-bind="value.name"></label>
                                        </div>
                                        <div class="col-10">
                                            <input class="form-check-input" type="checkbox"
                                                   ng-checked="privileges[key].value.substr(0, 1) == '7'"
                                                   ng-click="togglePrivilege(key, 'view')"/>
                                            <label class="form-check-label me-3">View</label>
                                            <input class="form-check-input" type="checkbox"
                                                   ng-checked="privileges[key].value.substr(1, 1) == '7'"
                                                   ng-click="togglePrivilege(key, 'add')"/>
                                            <label class="form-check-label me-3">Add</label>
                                            <input class="form-check-input" type="checkbox"
                                                   ng-checked="privileges[key].value.substr(2, 1) == '7'"
                                                   ng-click="togglePrivilege(key, 'edit')"/>
                                            <label class="form-check-label me-3">Edit</label>
                                            <input class="form-check-input" type="checkbox"
                                                   ng-checked="privileges[key].value.substr(3, 1) == '7'"
                                                   ng-click="togglePrivilege(key, 'delete')"/>
                                            <label class="form-check-label me-3">Delete</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        @if($model->userRole->_id != null)
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
