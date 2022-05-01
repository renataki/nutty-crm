@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="website">
    <div class="page-content" ng-init="initializeData('{{$model->website->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Website Entry</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/website/">Website</a></li>
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
                                        <input id="website-name" class="form-control" name="website-name" type="text"
                                               placeholder="Name" ng-model="name.value"
                                               ng-keyup="checkFormLengthRequired('name.value', 'website-name', 'response-name', 3, 50)"/>
                                        <div id="response-name"></div>
                                    </div>
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <div class="mb-3">
                                                <label class="form-label">Nucode</label>
                                                <input id="website-nucode" class="form-control" name="website-nucode"
                                                       type="text" placeholder="Nucode" ng-model="nucode.value"
                                                       ng-keyup="checkFormLength('nucode.value', 'website-nucode', 'response-nucode', 1, 50)"/>
                                                <div id="response-nucode"></div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea id="website-description" class="form-control"
                                                  name="website-description" type="text" placeholder="Description"
                                                  ng-model="description.value"
                                                  ng-keyup="checkFormLength('description.value', 'website-description', 'response-description', 3, 250)"></textarea>
                                        <div id="response-description"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select id="website-status" class="form-control select2"
                                                data-error="Please select status" data-input="website-status"
                                                data-required="true" data-response="response-status"
                                                data-scope="status.value">
                                            <option value="">Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <div id="response-status"></div>
                                    </div>
                                    <div class="mb-3">
                                        @if($model->website->_id != null)
                                            <button class="btn btn-warning waves-effect waves-light me-1"
                                                    ng-click="update($event)">Edit
                                            </button>
                                        @else
                                            <button class="btn btn-success waves-effect waves-light me-1"
                                                    ng-click="insert($event)">Add New
                                            </button>
                                        @endif
                                        <button type="reset" class="btn btn-secondary waves-effect me-1">Reset</button>
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
