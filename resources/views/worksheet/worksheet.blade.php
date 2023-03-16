@include("global.head")
@include("global.header")


<div class="main-content" ng-controller="worksheet">
    <div class="page-content" ng-init="initializeData(null)">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Worksheet</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{config("app.url")}}/">Home</a></li>
                                <li class="breadcrumb-item active">Worksheet</li>
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
                                    @if($model->websiteId != null)
                                    <input type="hidden" value="{{$model->websiteId}}" id="website_id">
                                    <input type="hidden" value="" id="single_phone" data-scope="contact.phone.value">
                                    <div class="col-lg-3">
                                        <div class="mb-3" style="text-align: center;">
                                            <a ng-show="contact.phone.view" class="btn btn-primary waves-effect waves-light" onclick="sendSms()">
                                                Send SMS
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3" style="text-align: center;">
                                            <a ng-show="contact.phone.view" id="worksheet-skype-call" class="btn btn-primary waves-effect waves-light">Skype Call</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3" style="text-align: center;">
                                            <a ng-show="contact.whatsapp.view" id="worksheet-whatsapp-call" class="btn btn-primary waves-effect waves-light" target="_blank">Whatsapp
                                                Call</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3" style="text-align: center;">
                                            @if(Session::has("account"))
                                            @if(Session::get("account")->type != 'CRM')
                                            <button class="btn btn-primary waves-effect waves-light" ng-click="copyPhoneNumber()">Copy Phone Number
                                            </button>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input class="form-control" type="text" placeholder="Name" ng-model="name.value" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Username</label>
                                            <input class="form-control" type="text" placeholder="Account Username" ng-model="account.username.value" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Group</label>
                                            <input class="form-control" type="text" placeholder="Group" readonly="readonly" ng-model="group.value" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Response</label>
                                            <select id="worksheet-status" class="form-control select2" data-scope="status.value">
                                                <option value="">Response</option>
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
                                            <input class="form-control" type="text" placeholder="Remark" ng-model="reference.value" />
                                        </div>
                                    </div>
                                    <div ng-show="telemarketer.view" class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Telemarketer</label>
                                            <input class="form-control" type="text" placeholder="Telemarketer" readonly="readonly" ng-model="telemarketer.value" />
                                        </div>
                                    </div>
                                    <div ng-show="crm.view" class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">CRM</label>
                                            <input class="form-control" type="text" placeholder="CRM" readonly="readonly" ng-model="crm.value" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary waves-effect waves-light me-1" ng-click="update($event)">Next
                                        </button>
                                    </div>
                                    @else
                                    <h5 class="mb-3" style="text-align: center;">
                                        Select one of website below
                                    </h5>
                                    <div ng-repeat="(key, value) in websites.option" class="col-2 mb-3">
                                        <button class="btn btn-primary waves-effect waves-light me-1" ng-click="start(value._id, $event)" ng-bind="value.name">
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- code for modal --->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Select Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($model->templates)
                    <select id="worksheet-template" class="form-select">
                        <option value="">Choose Template</option>
                        @foreach($model->templates as $val)
                        <option value="{{$val->_id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="return validate_sms()">Send SMS</button>
                </div>
            </div>
        </div>
    </div>

    <!-- code for modal --->
    <script>
        function validate_sms() {
            var template = $('#worksheet-template').val();
            if (template == "") {

                Swal.fire({
                    title: 'Error!',
                    text: 'Please Choose Template',
                    icon: 'error'
                });
                return false;
            } else {
                sendSms();

            }
        }

        function sendSms() {
            var website_id = $('#website_id').val();

            var single_phone = $('#single_phone').val();

            var template = $('#worksheet-template').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: "{{config('app.url')}}/send-sms/",
                method: "post",
                data: {
                    'id': website_id,
                    'single_phone': single_phone,
                    'template': template,
                },
                dataType: "JSON",
                success: function(data) {
                    //success
                    if (data == 1) {
                        $('#staticBackdrop').modal('show');
                    } else if (Number(data.status) === 200) {
                        $('#staticBackdrop').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: 'Successfully sent',
                            icon: 'success'
                        });


                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error'
                        });

                    }
                },
                error: function(e) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong . Please try again later!!',
                        icon: 'error'
                    });

                }
            });
            return false;
        }
    </script>
    @include("global.footer")
    @include("global.foot")