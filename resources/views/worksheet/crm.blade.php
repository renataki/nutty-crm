@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="worksheet">
    <div class="page-content" ng-init="initializeData(null)">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Worksheet CRM</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/worksheet/">Worksheet</a>
                                </li>
                                <li class="breadcrumb-item active">CRM</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if($model->websiteId != null)
                                <form class="row g-1 mb-3" method="POST" action="">
                                    <div class="col-md-3">
                                        <select id="worksheet-crm-filter-type"
                                                class="select2 form-select dt-select"
                                                name="worksheet-crm-filter-type"
                                                data-column="1" data-regex="false">
                                            <option value="1">Today no deposit</option>
                                            <option value="3">3 days no deposit</option>
                                            <option value="7">7 days no deposit</option>
                                            <option value="10">10 days no deposit</option>
                                            <option value="14">14 days no deposit</option>
                                            <option value="20">20 days no deposit</option>
                                            <option value="25">25 days no deposit</option>
                                            <option value="30">30 days no deposit</option>
                                            <option value="60">60 days no deposit</option>
                                            <option value="90">90 days no deposit</option>
                                        </select>
                                    </div>
                                    <!--<div class="col-md-3">
                                        <select id="worksheet-crm-filter-status"
                                                class="select2 form-select dt-select"
                                                name="worksheet-crm-filter-status"
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
                                    </div>-->
                                    <div class="col-md-6"></div>
                                </form>
                                <div class="col-12 overflow-auto">
                                    <table id="worksheet-crm" class="table table-striped table-bordered nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Phone</th>
                                            <th>Whatsapp</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Last Deposit</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Phone</th>
                                            <th>Whatsapp</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Last Deposit</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <h5 class="mb-3" style="text-align: center;">
                                    Select one of website below
                                </h5>
                                <div ng-repeat="(key, value) in websites.option" class="col-2 mb-3">
                                    <button class="btn btn-primary waves-effect waves-light me-1"
                                            ng-click="startCrm(value._id, $event)" ng-bind="value.name">
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include("global.footer")
@include("global.foot")
