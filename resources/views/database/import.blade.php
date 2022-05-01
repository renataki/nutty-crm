@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="database">
    <div class="page-content" ng-init="initializeData({{$model->viewResult}})">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Database Import</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/database/">Database</a></li>
                                <li class="breadcrumb-item active">Import</li>
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
                                        <label class="form-label me-3">Download File Format</label>
                                        <a href="{{asset("resources/excels/Nutty%20CRM%20Import%20Database.xlsx")}}">Download
                                            here</a>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Website <span class="text-danger">*</span></label>
                                        <select id="database-website" class="form-control select2"
                                                data-scope="website.value">
                                            <option value="">Website</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Group</label>
                                        <select id="database-group" class="form-control select2"
                                                data-scope="group.value">
                                            <option value="">Group</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input id="database-import-data" style="display: none;" type="file"
                                               database-import-data="files"/>
                                        <button class="btn btn-primary waves-effect waves-light me-1"
                                                ng-click="selectFile()" ng-disabled="import.view">Import
                                        </button>
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
