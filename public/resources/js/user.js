app.controller("user", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $scope.$on("initializeTable", function() {

            let columns = [
                {
                    "data": "_id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }, {
                    "data": "username",
                    "name": "username"
                }, {
                    "data": "name",
                    "name": "name"
                }, {
                    "data": "type",
                    "name": "type"
                }, {
                    "data": "group.name",
                    "name": "group._id"
                }, {
                    "data": "role.name",
                    "name": "role._id"
                }, {
                    "data": "status",
                    "name": "status"
                }, {
                    "data": "modified.timestamp",
                    "name": "modified.timestamp",
                    "render": function(data) {
                        return initializeTimestamp(data.$date.$numberLong);
                    }
                }, {
                    "data": "_id",
                    "render": function(data) {
                        return "<a href=\"" + $scope.global.url.base + "/user/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"delete('/user/delete/', '" + data + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
                    }
                }
            ];

            if($scope.account.nucode.value == "system") {

                columns.splice(3, 0, {
                    "data": "nucode",
                    "name": "nucode"
                });

            }

            let table = $("#user").DataTable({
                "ajax": {
                    "contentType": "application/json",
                    "data": function(data) {
                        data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                        return JSON.stringify(initializeFilter(data));
                    },
                    "datatype": "json",
                    "type": "POST",
                    "url": $scope.global.url.base + "/user/table/"
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

        $scope.initializeData = function(id) {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                    "id": id
                },
                "url": $scope.global.url.base + "/user/initialize-data"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    $scope.nucode.value = $scope.account.nucode.value;

                    if(response.user != null) {

                        $scope.id.value = response.user._id;
                        $scope.group.value = response.user.group._id.$oid;
                        $scope.name.value = response.user.name;
                        $scope.nucode.value = response.user.nucode;
                        $scope.password.value = response.user.password["main"];
                        $scope.password.confirm.value = response.user.password["main"];
                        $scope.role.value = response.user.role._id.$oid;
                        $scope.status.value = response.user.status;
                        $scope.type.value = response.user.type;
                        $scope.username.value = response.user.username;

                    }

                    $timeout(function() {

                        $("#user-group").val($scope.group.value);
                        $("#user-role").val($scope.role.value);
                        $("#user-status").val($scope.status.value);
                        $("#user-type").val($scope.type.value);

                        initializeThirdParty();

                    });

                } else {

                    sweetAlert("error", response.response);

                }

            });

        }

        $scope.initializeInputData = function() {

            return {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                "group": {
                    "id": $scope.initializeSelect($scope.group.value)
                },
                "name": $scope.name.value,
                "nucode": $scope.nucode.value,
                "password": {
                    "main": $scope.password.value
                },
                "role": {
                    "id": $scope.initializeSelect($scope.role.value)
                },
                "status": $scope.initializeSelect($scope.status.value),
                "type": $scope.initializeSelect($scope.type.value),
                "username": $scope.username.value
            };

        }

        $scope.initializeInputNewPassword = function() {

            return {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                "password": {
                    "main": $scope.password.value
                }
            };

        }

        $scope.insert = function(event) {

            let validation = $scope.validateData();

            if(validation) {

                let rest = {
                    "data": $scope.initializeInputData(),
                    "url": $scope.global.url.base + "/user/insert/"
                };
                global.rest(rest, function(response) {

                    if(response.result) {

                        sweetAlert("success", response.response);

                    } else {

                        sweetAlert("error", response.response);

                    }

                });

            } else {

                sweetAlert("error", "Please input valid data");

            }

            event.preventDefault();

        }

        $scope.profileInitializeData = function(id) {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                    "id": id
                },
                "url": $scope.global.url.base + "/user/profile/initialize-data"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    $scope.nucode.value = $scope.account.nucode.value;

                    if(response.user != null) {

                        $scope.id.value = response.user._id;
                        $scope.group.value = response.user.group._id.$oid;
                        $scope.name.value = response.user.name;
                        $scope.nucode.value = response.user.nucode;
                        $scope.password.value = response.user.password["main"];
                        $scope.password.confirm.value = response.user.password["main"];
                        $scope.role.value = response.user.role._id.$oid;
                        $scope.status.value = response.user.status;
                        $scope.type.value = response.user.type;
                        $scope.username.value = response.user.username;

                    }

                    $timeout(function() {

                        $("#user-group").val($scope.group.value);
                        $("#user-role").val($scope.role.value);
                        $("#user-status").val($scope.status.value);
                        $("#user-type").val($scope.type.value);

                        initializeThirdParty();

                    });

                } else {

                    sweetAlert("error", response.response);

                }

            });

        }

        $scope.update = function(event) {

            let validation = $scope.validateData();

            if(validation) {

                let data = $scope.initializeInputData();
                data.id = $scope.id.value;

                let rest = {
                    "data": data,
                    "url": $scope.global.url.base + "/user/update"
                };
                global.rest(rest, function(response) {

                    if(response.result) {

                        sweetAlert("success", response.response);

                    } else {

                        sweetAlert("error", response.response);

                    }

                });

            } else {

                sweetAlert("error", "Please input valid data")

            }

            event.preventDefault();

        }

        $scope.updatePassword = function(event) {

            let validation = $scope.validatePassword();

            if(validation) {

                let data = $scope.initializeInputNewPassword();
                data.id = $scope.id.value;

                let rest = {
                    "data": data,
                    "url": $scope.global.url.base + "/user/update-password"
                };
                global.rest(rest, function(response) {

                    if(response.result) {

                        sweetAlert("success", response.response);

                    } else {

                        sweetAlert("error", response.response);

                    }

                });

            } else {

                sweetAlert("error", "Please input valid data")

            }

            event.preventDefault();

        }

        $scope.validateData = function() {

            let result = true;

            let valid = {
                "group": $scope.checkFormSelectRequired("group.value", "user-group", "response-group", "Please select group"),
                "name": $scope.checkFormLengthRequired("name.value", "user-name", "response-name", 3, 50),
                "nucode": $scope.checkFormLength("nucode.value", "user-nucode", "response-nucode", 1, 50),
                "password": $scope.checkFormPassword("password.value", "user-password", "response-password"),
                "passwordConfirm": $scope.checkFormPasswordConfirm("password.confirm.value", "password.value", "user-password-confirm", "response-password-confirm"),
                "role": $scope.checkFormSelectRequired("role.value", "user-role", "response-role", "Please select role"),
                "status": $scope.checkFormSelectRequired("status.value", "user-status", "response-status", "Please select status"),
                "type": $scope.checkFormSelectRequired("type.value", "user-type", "response-type", "Please select type"),
                "username": $scope.checkFormLengthRequired("username.value", "user-username", "response-username", 3, 20)
            };

            angular.forEach(valid, function(value) {

                if(!value) {

                    result = false;

                    return false;

                }

            });

            return result;

        }

        $scope.validatePassword = function() {

            let result = true;

            let valid = {
                "passwordCurrent": $scope.checkFormPassword("password.current.value", "user-current-password", "response-current-password"),
                "password": $scope.checkFormPassword("password.value", "user-password", "response-password"),
                "passwordConfirm": $scope.checkFormPasswordConfirm("password.confirm.value", "password.value", "user-password-confirm", "response-password-confirm")
            };

            angular.forEach(valid, function(value) {

                if(!value) {

                    result = false;

                    return false;

                }

            });

            return result;

        }

    }
]);
