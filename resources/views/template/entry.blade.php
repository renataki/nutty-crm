@include("global.head")
@include("global.header")
<div class="main-content" ng-controller="template">
    <div class="page-content" ng-init="initializeData('{{$model->template->_id}}')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">template Entry</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/template/">Template</a></li>
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
                                        <input id="template-name" class="form-control" name="template-name" type="text"
                                               placeholder="Name" ng-model="name.value"
                                               ng-keyup="checkFormLengthRequired('name.value', 'template-name', 'response-name', 3, 50)"/>
                                        <div id="response-name"></div>
                                    </div>
                                    @if(Session::has("account"))
                                        @if(Session::get("account")->nucode == "system")
                                            <div class="mb-3">
                                                <label class="form-label">Nucode</label>
                                                <input id="template-nucode" class="form-control" name="template-nucode"
                                                       type="text" placeholder="Nucode" ng-model="$parent.nucode.value"
                                                       ng-keyup="checkFormLength('nucode.value', 'template-nucode', 'response-nucode', 1, 50)"/>
                                                <div id="response-nucode"></div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea id="template-description" class="form-control"
                                                  name="template-description" type="text" placeholder="Description"
                                                  ng-model="description.value"
                                                  ng-keyup="checkFormLength('description.value', 'template-description', 'response-description', 3, 250)"></textarea>
                                        <div id="response-description"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Text Message</label>
                                        <textarea id="template-textMessage" class="form-control"
                                                  name="template-textMessage" type="text" placeholder="Text Message"
                                                  ng-model="textMessage.value"
                                                  ng-keyup="checkFormLength('textMessage.value', 'template-textMessage', 'response-textMessage', 3, 250)"></textarea>
                                        <div id="response-textMessage"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Media Type</label>
                                        <select id="template-mediaType" class="form-control select2"
                                                data-error="Please select Media Type" data-input="template-mediaType"
                                                data-required="true" data-response="response-mediaType"
                                                data-scope="mediaType.value">
                                            <option value="">Status</option>
                                            <option value="Video">Video</option>
                                            <option value="Image">Image</option>
                                        </select>
                                        <div id="response-mediaType"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Media URL</label>
                                        <input id="template-mediaUrl" class="form-control" name="template-mediaUrl"
                                               type="text"
                                               placeholder="Media URL" ng-model="mediaUrl.value"
                                               ng-keyup="checkFormLength('mediaUrl.value', 'template-mediaUrl', 'response-mediaUrl', 3, 50)"/>
                                        <div id="response-mediaUrl"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Defualt</label>
                                        <div>
                                            <input class="form-check-input" type="checkbox"
                                                   ng-checked="isDefult.value">
                                            <label class="form-check-label" ng-bind="isDefult.value"></label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select id="template-status" class="form-control select2"
                                                data-error="Please select status" data-input="template-status"
                                                data-required="true" data-response="response-status"
                                                data-scope="status.value">
                                            <option value="">Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <div id="response-status"></div>
                                    </div>

                                    <div class="mb-3">
                                        @if($model->template->_id != null)
                                            <button class="btn btn-warning waves-effect waves-light me-1"
                                                    ng-click="update($event)">Edit
                                            </button>
                                        @else
                                            <button class="btn btn-success waves-effect waves-light me-1"
                                                    ng-click="insert($event)">Add New
                                            </button>
                                        @endif
                                        <button type="reset" class="btn btn-secondary waves-effect me-1">Reset</button>
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
