app.controller("worksheet", ["$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

    $scope.$on("initializeTable", function() {

        let table = $("#worksheet-follow-up").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/worksheet/follow-up/table/"
            },
            "columns": [{
                "data": "database", "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            }, {
                "data": "databaseAccount", "name": "databaseAccount", "render": function(data) {
                    let result = "";

                    if(data.length > 0) {

                        result = data[0].username;

                    }

                    return result;
                }
            }, {
                "data": "database", "name": "database", "render": function(data) {
                    let result = "";

                    if(data.length > 0) {

                        result = data[0].name;

                    }

                    return result;
                }
            }, {
                "data": "database", "name": "database", "render": function(data) {
                    let result = "";

                    if(data.length > 0) {

                        result = data[0].group.name;

                    }

                    return result;
                }
            }, {
                "data": "website", "name": "website", "render": function(data) {
                    let result = "";

                    if(data.length > 0) {

                        result = data[0].name;

                    }

                    return result;
                }
            }, {
                "data": "status", "name": "status", "render": function(data) {
                    return data[data.length - 1];
                }
            }, {
                "data": "_id", "render": function(data) {
                    return "<a href=\"" + $scope.global.url.base + "/worksheet/follow-up/call/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 call\" title=\"Call\">" + "<i class=\"fas fa-phone-alt\"></i>" + "</a>";
                }
            }],
            "createdRow": function(row) {
                $compile(angular.element(row).contents())($scope);
            },
            "lengthMenu": setting.table.length.option,
            "pageLength": setting.table.length.default,
            "processing": !0,
            "rowId": "_id",
            "searching": false,
            "serverSide": !0
        });

        $(".dataTables_length select").addClass("form-select form-select-sm");

        tableSearch(table);

        let columns = [{
            "data": "database", "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            "data": "created.timestamp", "name": "created.timestamp", "render": function(data) {
                return initializeTimestamp(data.$date.$numberLong);
            }
        }, {
            "data": "databaseAccount", "name": "databaseAccount", "render": function(data) {
                let result = "";

                if(data.length > 0) {

                    result = data[0].username;

                }

                return result;
            }
        }, {
            "data": "database", "name": "database", "render": function(data) {
                let result = "";

                if(data.length > 0) {

                    result = data[0].name;

                }

                return result;
            }
        }, {
            "data": "website.name", "name": "website.name"
        }, {
            "data": "status", "name": "status", "render": function(data) {
                return standardCase(data);
            }
        }, {
            "data": "_id", "render": function(data, type, row) {
                let result = "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm me-2\" title=\"Locked\"><i class=\"fas fa-lock\"></i></a>";

                if($scope.account.type.value != "Administrator" && (row.status == "FollowUp" || row.status == "Registered")) {

                    result = "<a href=\"" + $scope.global.url.base + "/worksheet/call/" + row.website._id.$oid + "/" + row.database[0]._id.$oid + "/\" class=\"btn btn-outline-secondary btn-sm me-2 call\" title=\"Call\">" + "<i class=\"fas fa-phone-alt\"></i>" + "</a>";

                }

                return result;
            }
        }]

        if($scope.account.type.value == "Administrator") {

            columns.splice(2, 0, {
                "data": "user.username", "name": "user._id"
            });

        }

        table = $("#worksheet-result").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    if($scope.account.type.value != "Administrator") {

                        data["userId"] = $("#worksheet-result").attr("data-user-id");

                    }

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/worksheet/result/table/"
            },
            "columns": columns,
            "createdRow": function(row) {
                $compile(angular.element(row).contents())($scope);
            },
            "lengthMenu": setting.table.length.option,
            "pageLength": setting.table.length.default,
            "processing": !0,
            "rowId": "_id",
            "searching": false,
            "serverSide": !0
        });

        $(".dataTables_length select").addClass("form-select form-select-sm");

        tableSearch(table);

    });

    $scope.crm = {
        "value": "", "view": false
    };

    $scope.databaseLog = {
        "id": {
            "value": ""
        }
    };

    $scope.telemarketer = {
        "value": "", "view": false
    };

    $scope.copyPhoneNumber = function() {

        navigator.clipboard.writeText($scope.contact.phone.value);

        sweetAlert("success", "Phone Number Copied");

    }

    $scope.initializeData = function(websiteId, id) {

        let url = "/worksheet/initialize-data";

        if(id != null) {

            url = "/worksheet/call/initialize-data";

        }

        let rest = {
            "data": {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"), "id": id, "websiteId": websiteId
            }, "url": $scope.global.url.base + url
        };
        global.rest(rest, function(response) {

            if(response.result) {

                if(!response.back) {

                    if(response.database != null) {

                        $scope.id.value = response.database._id;
                        $scope.contact.phone.value = response.database.contact.phone;
                        $scope.contact.whatsapp.value = response.database.contact.whatsapp;
                        $scope.group.value = response.database.group.name;
                        $scope.name.value = response.database.name;
                        $scope.status.value = "";

                        if($scope.contact.phone.value != "") {

                            $scope.contact.phone.view = true;

                        }

                        if($scope.contact.whatsapp.value != "") {

                            $scope.contact.whatsapp.view = true;

                        }

                        $scope.crm.value = response.database.crm.username;

                        if($scope.crm.value != "system") {

                            $scope.crm.view = true;

                        }

                        $scope.telemarketer.value = response.database.telemarketer.username;

                        if($scope.telemarketer.value != "system") {

                            $scope.telemarketer.view = true;

                        }

                    }

                    if(response.databaseAccount != null) {

                        $scope.account.username.value = response.databaseAccount.username;

                    }

                    if(response.databaseLog != null) {

                        $scope.databaseLog.id.value = response.databaseLog._id;

                    }

                    $scope.reference.value = response.reference;

                    $scope.initializeWebsite(response.userGroup);

                    $timeout(function() {

                        initializeSelect2("worksheet-status", null);
                        $("#worksheet-status").val($scope.status.value).trigger("change");

                        $("#worksheet-skype-call").attr("href", "skype:" + $scope.contact.phone.value.toString().replaceAll("+", "") + "?call");
                        $("#worksheet-whatsapp-call").attr("href", "https://api.whatsapp.com/send?phone=" + $scope.contact.whatsapp.value.toString().replaceAll("+", ""));

                    });

                } else {

                    $window.location.href = $scope.global.url.base + "/worksheet/result/";

                }

            } else {

                sweetAlert("error", response.response);

            }

        });

    }

    $scope.initializeWebsite = function(userGroup) {

        if(userGroup != null) {

            angular.forEach(userGroup.website.ids, function(value, key) {

                $scope.websites.option.push({
                    "_id": value, "name": userGroup.website.names[key]
                });

            });

        }

    }

    $scope.followUpInitializeData = function() {

        let rest = {
            "data": {
                "_token": $("meta[name=\"csrf-token\"]").attr("content")
            }, "url": $scope.global.url.base + "/worksheet/follow-up/initialize-data"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                $scope.initializeWebsite(response.userGroup);

            } else {

                sweetAlert("error", response.response);

            }

        });

    }

    $scope.start = function(id, event) {

        let rest = {
            "data": {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"), "website": {
                    "id": id
                }
            }, "url": $scope.global.url.base + "/worksheet/start"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                $window.location.reload();

            } else {

                sweetAlert("error", response.response);

            }

        });

        event.preventDefault();

    }

    $scope.update = function(event) {

        let rest = {
            "data": {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"), "id": $scope.id.value, "account": {
                    "username": $scope.account.username.value
                }, "log": {
                    "id": $scope.databaseLog.id.value
                }, "name": $scope.name.value, "reference": $scope.reference.value, "status": $scope.status.value
            }, "url": $scope.global.url.base + "/worksheet/update"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                $window.location.reload();

            } else {

                sweetAlert("error", response.response);

            }

        });

        event.preventDefault();

    }

}]);
