@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="worksheet">
    <div class="page-content" ng-init="initializeData('{{$model->websiteId}}', '{{$model->id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Worksheet Follow Up Call</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/worksheet/">Worksheet</a>
                                </li>
                                <li class="breadcrumb-item active">Call</li>
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
                                    <div class="col-lg-4">
                                        <div class="mb-3" style="text-align: center;">
                                            <a ng-show="contact.phone.view" id="worksheet-skype-call"
                                               class="btn btn-primary waves-effect waves-light">Skype Call</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3" style="text-align: center;">
                                            <a ng-show="contact.whatsapp.view" id="worksheet-whatsapp-call"
                                               class="btn btn-primary waves-effect waves-light" target="_blank">Whatsapp
                                                Call</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3" style="text-align: center;">
                                            <button class="btn btn-primary waves-effect waves-light"
                                                    ng-click="copyPhoneNumber()">Copy Phone Number
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input class="form-control" type="text" placeholder="Name"
                                                   ng-model="name.value"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Username</label>
                                            <input class="form-control" type="text" placeholder="Account Username"
                                                   ng-model="account.username.value"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Group</label>
                                            <input class="form-control" type="text" placeholder="Group"
                                                   readonly="readonly" ng-model="group.value"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Response</label>
                                            <select id="worksheet-status" class="form-control select2"
                                                    data-scope="status.value">
                                                <option value="">Response</option>
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
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Remark</label>
                                            <input class="form-control" type="text" placeholder="Remark"
                                                   ng-model="reference.value"/>
                                        </div>
                                    </div>
                                    <div ng-show="telemarketer.view" class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Telemarketer</label>
                                            <input class="form-control" type="text" placeholder="Telemarketer"
                                                   readonly="readonly" ng-model="telemarketer.value"/>
                                        </div>
                                    </div>
                                    <div ng-show="crm.view" class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">CRM</label>
                                            <input class="form-control" type="text" placeholder="CRM"
                                                   readonly="readonly" ng-model="crm.value"/>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary waves-effect waves-light me-1"
                                                ng-click="update($event)">Next
                                        </button>
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
