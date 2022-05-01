@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="database">
    <div class="page-content" ng-init="initializeData()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Database Import History</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/database/">Database</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/database/import/">Import</a>
                                </li>
                                <li class="breadcrumb-item active">History</li>
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
                                <div class="col-md-10"></div>
                                <div class="col-md-2" style="text-align: right;">
                                </div>
                            </form>
                            <table id="database-import-history" class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>File Name</th>
                                    <th>Website</th>
                                    <th>Group</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Importer</th>
                                    <th>Modified</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>File Name</th>
                                    <th>Website</th>
                                    <th>Group</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Importer</th>
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
