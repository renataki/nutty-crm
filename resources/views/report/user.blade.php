@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="reportUser">
    <div class="page-content" ng-init="initializeData()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Report User</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/report/">Report</a></li>
                                <li class="breadcrumb-item active">User</li>
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
                                    <input class="form-control dt-input flatpickr-date-range" type="text"
                                           placeholder="Date" data-column="0" data-regex="false"/>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control dt-input" type="text" placeholder="Username"
                                           data-column="1" data-regex="true"/>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control dt-input" type="text" placeholder="Name"
                                           data-column="2" data-regex="true"/>
                                </div>
                                @if(Session::has("account"))
                                    @if(Session::get("account")->nucode == "system")
                                        <div class="col-md-2">
                                            <input class="form-control dt-input" type="text" placeholder="Nucode"
                                                   data-column="3" data-regex="false"/>
                                        </div>
                                        <div class="col-md-4"></div>
                                    @else
                                        <div class="col-md-6"></div>
                                    @endif
                                @endif
                            </form>
                            <div class="col-12 overflow-auto">
                                <table id="report-user" class="table table-striped table-bordered nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        @if(Session::has("account"))
                                            @if(Session::get("account")->nucode == "system")
                                                <th>Nucode</th>
                                            @endif
                                        @endif
                                        <th>Total Call</th>
                                        <th>Website Call</th>
                                        <th>Deposited</th>
                                        <th>Redeposited</th>
                                        <th>Registered</th>
                                        <th>Interested</th>
                                        <th>Follow Up</th>
                                        <th>Not Active</th>
                                        <th>Not Picked Up</th>
                                        <th>Not Interested</th>
                                        <th>Invalid Number</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        @if(Session::has("account"))
                                            @if(Session::get("account")->nucode == "system")
                                                <th>Nucode</th>
                                            @endif
                                        @endif
                                        <th>Total Call</th>
                                        <th>Website Call</th>
                                        <th>Deposited</th>
                                        <th>Registered</th>
                                        <th>Interested</th>
                                        <th>Follow Up</th>
                                        <th>Not Active</th>
                                        <th>Not Picked Up</th>
                                        <th>Not Interested</th>
                                        <th>Invalid Number</th>
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
    </div>
@include("global.footer")
@include("global.foot")
