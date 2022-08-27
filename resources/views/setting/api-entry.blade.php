@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="settingApi">
    <div class="page-content" ng-init="initializeData('{{$model->website->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Setting API Entry</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/setting/">Setting</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/setting/api/">API</a></li>
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
                                        <input id="setting-api-name" class="form-control" name="setting-api-name"
                                               type="text" placeholder="Name" readonly="readonly"
                                               ng-model="name.value"/>
                                        <div id="response-name"></div>
                                    </div>
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <div class="mb-3">
                                                <label class="form-label">Nucode</label>
                                                <input id="setting-api-nucode" class="form-control"
                                                       name="setting-api-nucode" type="text" placeholder="Nucode"
                                                       readonly="readonly" ng-model="nucode.value"/>
                                                <div id="response-nucode"></div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input id="setting-api-start" class="form-control flatpickr-date"
                                               name="setting-api-start" type="text" placeholder="Start Date"
                                               ng-model="start.value"
                                               ng-keyup="checkFormLength('start.value', 'setting-api-start', 'response-start', 10, 10)"/>
                                        <div id="response-start"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nexus Code</label>
                                        <input id="setting-api-api-nexus-code" class="form-control"
                                               name="setting-api-api-nexus-code" type="text" placeholder="Nexus Code"
                                               ng-model="api.nexus.code.value"
                                               ng-keyup="checkFormLengthRequired('api.nexus.code.value', 'setting-api-api-nexus-code', 'response-api-nexus-code', 3, 3)"/>
                                        <div id="response-api-nexus-code"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nexus URL</label>
                                        <input id="setting-api-api-nexus-url" class="form-control"
                                               name="setting-api-api-nexus-url" type="text" placeholder="Nexus URL"
                                               ng-model="api.nexus.url.value"
                                               ng-keyup="checkFormLengthRequired('api.nexus.url.value', 'setting-api-api-nexus-url', 'response-api-nexus-url', 3, 50)"/>
                                        <div id="response-api-nexus-url"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nexus API Salt</label>
                                        <input id="setting-api-api-nexus-salt" class="form-control"
                                               name="setting-api-api-nexus-salt" type="text"
                                               placeholder="Nexus API Salt" ng-model="api.nexus.salt.value"
                                               ng-keyup="checkFormLength('api.nexus.salt.value', 'setting-api-api-nexus-salt', 'response-api-nexus-salt', 3, 150)"/>
                                        <div id="response-api-nexus-salt"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-warning waves-effect waves-light me-1"
                                                ng-click="update($event)">Edit
                                        </button>
                                        <button type="reset" class="btn btn-secondary waves-effect me-1">Reset</button>
                                        @if($model->website->sync == "NoSync")
                                            <button class="btn btn-success waves-effect me-1" ng-click="sync($event)">
                                                Sync
                                            </button>
                                        @elseif($model->website->sync == "OnGoing")
                                            <button class="btn btn-success waves-effect me-1" disabled="disabled">Sync
                                                On
                                                Going
                                            </button>
                                        @else
                                            <button class="btn btn-success waves-effect me-1" disabled="disabled">Synced
                                            </button>
                                        @endif
                                        @if($model->syncQueue != null)
                                            <span>{{$model->syncQueue->date}}</span>
                                        @endif
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
