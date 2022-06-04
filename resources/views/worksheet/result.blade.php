@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="worksheet">
    <div class="page-content" ng-init="initializeData()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Worksheet Result</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/worksheet/">Worksheet</a>
                                </li>
                                <li class="breadcrumb-item active">Result</li>
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
                                           placeholder="Date" value="{{$model->filterDate}}" data-column="1"
                                           data-regex="false"/>
                                </div>
                                @if(Session::has("account"))
                                    @if(Session::get("account")->username == "system" || Session::get("account")->type == "Administrator")
                                        <div class="col-md-2">
                                            <select id="worksheet-result-filter-user"
                                                    class="select2 form-select dt-select"
                                                    name="worksheet-result-filter-user" data-column="2"
                                                    data-regex="false" data-value="{{$model->userId}}">
                                                <option value="">User</option>
                                                @foreach($model->users as $value)
                                                    <option value="{{$value->_id}}">{{$value->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control dt-input" type="text" placeholder="Username"
                                                   data-column="3" data-regex="true"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control dt-input" type="text" placeholder="Name"
                                                   data-column="4" data-regex="true"/>
                                        </div>
                                        <div class="col-md-2">
                                            <select id="worksheet-result-filter-website"
                                                    class="select2 form-select dt-select"
                                                    name="worksheet-result-filter-status"
                                                    data-column="5" data-regex="false">
                                                <option value="">Website</option>
                                                @foreach($model->websites as $value)
                                                    <option value="{{$value->_id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select id="worksheet-result-filter-status"
                                                    class="select2 form-select dt-select"
                                                    name="worksheet-result-filter-status"
                                                    data-column="6" data-regex="false">
                                                <option value="">Status</option>
                                                <option value="Deposited">Deposited</option>
                                                <option value="Registered">Registered</option>
                                                <option value="Interested">Interested</option>
                                                <option value="FollowUp">Follow Up</option>
                                                <option value="NotActive">Not Active</option>
                                                <option value="NotPickedUp">Not Picked Up</option>
                                                <option value="NotInterested">Not Interested</option>
                                                <option value="InvalidNumber">Invalid Number</option>
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-2">
                                            <input class="form-control dt-input" type="text" placeholder="Username"
                                                   data-column="2" data-regex="true"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control dt-input" type="text" placeholder="Name"
                                                   data-column="3" data-regex="true"/>
                                        </div>
                                        <div class="col-md-2">
                                            <select id="worksheet-result-filter-website"
                                                    class="select2 form-select dt-select"
                                                    name="worksheet-result-filter-status"
                                                    data-column="4" data-regex="false">
                                                <option value="">Website</option>
                                                @foreach($model->websites as $value)
                                                    <option value="{{$value->_id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select id="worksheet-result-filter-status"
                                                    class="select2 form-select dt-select"
                                                    name="worksheet-result-filter-status"
                                                    data-column="5" data-regex="false">
                                                <option value="">Status</option>
                                                <option value="Deposited">Deposited</option>
                                                <option value="Registered">Registered</option>
                                                <option value="Interested">Interested</option>
                                                <option value="FollowUp">Follow Up</option>
                                                <option value="NotActive">Not Active</option>
                                                <option value="NotPickedUp">Not Picked Up</option>
                                                <option value="NotInterested">Not Interested</option>
                                                <option value="InvalidNumber">Invalid Number</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"></div>
                                    @endif
                                @endif
                            </form>
                            <div class="col-12 overflow-auto">
                                <table id="worksheet-result" class="table table-striped table-bordered nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        @if(Session::has("account"))
                                            @if(Session::get("account")->type == "Administrator")
                                                <th>User</th>
                                            @endif
                                        @endif
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Website</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        @if(Session::has("account"))
                                            @if(Session::get("account")->type == "Administrator")
                                                <th>User</th>
                                            @endif
                                        @endif
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Website</th>
                                        <th>Status</th>
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
