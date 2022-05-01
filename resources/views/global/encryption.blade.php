@include("global.head")
<body class="authentication-bg" ng-controller="encryption">
<div class="my-5 pt-sm-5" ng-init="initializeData()">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Action</label>
                            <select id="encryption-action" class="form-control select2" ng-model="action.value"
                                    ng-change="checkFormSelectRequired('action.value', 'encryption-action', 'response-action', 'Please select action')"
                                    data-scope="action.value">
                                <option value="">Action</option>
                                <option value="Encrypt">Encrypt</option>
                                <option value="Decrypt">Decrypt</option>
                            </select>
                            <div id="response-action"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">String</label>
                            <input id="encryption-string" class="form-control" type="text" ng-model="string.value"/>
                            <div id="response-string"></div>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-warning waves-effect waves-light me-1" ng-click="encrypt($event)">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                        </div>
                        <div class="mb-3">
                            <p ng-bind="result.value"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include("global.foot")
