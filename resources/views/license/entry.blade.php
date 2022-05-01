@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="license">
    <div class="page-content" ng-init="initializeData('{{$model->license->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">License Entry</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/license/">License</a></li>
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
                                        <label class="form-label">Nucode</label>
                                        <input id="user-nucode" class="form-control" type="text"
                                               ng-model="nucode.value"
                                               ng-keyup="checkFormLength('nucode.value', 'user-nucode', 'response-nucode', 2, 50)"/>
                                        <div id="response-nucode"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Total Seat</label>
                                        <input id="license-user-total" class="form-control" type="text"
                                               ng-model="user.total.value"
                                               ng-keyup="$scope.checkFormIntegerRequired('user.total.value', 'license-user-total', 'response-user-total', 'Please input number only')"/>
                                        <div id="response-name"></div>
                                    </div>
                                    <div class="mb-3">
                                        @if($model->license->_id != null)
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
