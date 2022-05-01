@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="userGroup">
    <div class="page-content" ng-init="initializeData()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User Group</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/user/">User</a></li>
                                <li class="breadcrumb-item active">Group</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-1 mb-3" method="POST" action="">
                                <div class="col-md-2">
                                    <input class="form-control dt-input" type="text" placeholder="Name" data-column="1"
                                           data-regex="true"/>
                                </div>
                                <div class="col-md-2">
                                    <select id="user-group-filter-website" class="select2 form-select dt-select"
                                            data-column="2" data-regex="false">
                                        <option value="">Website</option>
                                        @foreach($model->websites as $value)
                                            <option value="{{$value->_id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(Session::has("account"))
                                    @if(Session::get("account")->nucode == "system")
                                        <div class="col-md-2">
                                            <input class="form-control dt-input" type="text" placeholder="Nucode"
                                                   data-column="3" data-regex="false"/>
                                        </div>
                                        <div class="col-md-2">
                                            <select id="user-group-filter-status" class="select2 form-select dt-select"
                                                    data-column="4" data-regex="false">
                                                <option value="">Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"></div>
                                    @else
                                        <div class="col-md-2">
                                            <select id="user-group-filter-status" class="select2 form-select dt-select"
                                                    data-column="3" data-regex="false">
                                                <option value="">Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4"></div>
                                    @endif
                                @endif
                                <div class="col-md-2" style="text-align: right;">
                                    <a href="{{config("app.url")}}/user/group/entry/"
                                       class="btn btn-success waves-effect waves-light">
                                        <i class="mdi mdi-plus me-2"></i> Add New
                                    </a>
                                </div>
                            </form>
                            <table id="user-group" class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <th>Nucode</th>
                                        @endif
                                    @endif
                                    <th>Status</th>
                                    <th>Modified</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <th>Nucode</th>
                                        @endif
                                    @endif
                                    <th>Status</th>
                                    <th>Modified</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include("global.footer")
@include("global.foot")
