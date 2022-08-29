@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="worksheet">
    <div class="page-content">
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
                            <form class="row g-1 mb-3" method="POST" action="">
                                <div class="col-md-3">
                                    <select id="worksheet-crm-filter-type"
                                            class="select2 form-select dt-select"
                                            name="worksheet-crm-filter-type"
                                            data-column="1" data-regex="false">
                                        <option value="">Type</option>
                                        <option value="1-7">No deposit 1 - 7 days</option>
                                        <option value="8-15">No deposit 8 - 15 days</option>
                                        <option value="16-30">No deposit 16 - 30 days</option>
                                        <option value="31-60">No deposit 31 - 60 days</option>
                                        <option value="61-90">No deposit 61 - 90 days</option>
                                    </select>
                                </div>
                                <div class="col-md-9"></div>
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
