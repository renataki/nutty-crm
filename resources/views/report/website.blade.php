@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="reportWebsite">
    <div class="page-content" ng-init="initializeData()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Report Website</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/report/">Report</a></li>
                                <li class="breadcrumb-item active">Website</li>
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
                                    <select class="select2 form-select dt-select"
                                            data-column="1" data-regex="false">
                                        <option value="">Website</option>
                                        @foreach($model->websites as $value)
                                            <option value="{{$value->_id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            <div class="col-12 overflow-auto">
                                <table id="report-website" class="table table-striped table-bordered nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Website</th>
                                        @if(Session::has("account"))
                                            @if(Session::get("account")->nucode == "system")
                                                <th>Nucode</th>
                                            @endif
                                        @endif
                                        <th>Total Call</th>
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
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Website</th>
                                        @if(Session::has("account"))
                                            @if(Session::get("account")->nucode == "system")
                                                <th>Nucode</th>
                                            @endif
                                        @endif
                                        <th>Total Call</th>
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
