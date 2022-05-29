app.controller("userRole", ["$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

    $scope.$on("initializeTable", function() {

        let columns = [{
            "data": "_id", "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            "data": "name", "name": "name"
        }, {
            "data": "status", "name": "status"
        }, {
            "data": "modified.timestamp", "name": "modified.timestamp", "render": function(data) {
                return initializeTimestamp(data.$date.$numberLong);
            }
        }, {
            "data": "_id", "render": function(data) {
                return "<a href=\"" + $scope.global.url.base + "/user/role/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"delete('/user/role/delete/', '" + data + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
            }
        }];

        if($scope.account.nucode.value == "system") {

            columns.splice(2, 0, {
                "data": "nucode", "name": "nucode"
            });

        }

        let table = $("#user-role").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/user/role/table/"
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
                "_token": $("meta[name=\"csrf-token\"]").attr("content"), "id": id
            }, "url": $scope.global.url.base + "/user/role/initialize-data"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                $scope.nucode.value = $scope.account.nucode.value;

                let privileges = null;

                if(response.userRole != null) {

                    $scope.id.value = response.userRole._id;
                    $scope.description.value = response.userRole.description;
                    $scope.name.value = response.userRole.name;
                    $scope.nucode.value = response.userRole.nucode;
                    $scope.status.value = response.userRole.status;

                    privileges = response.userRole.privilege;

                }

                $scope.initializePrivilege(privileges);

                $timeout(function() {

                    $("#user-role-status").val($scope.status.value);

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
            "description": $scope.description.value,
            "name": $scope.name.value,
            "nucode": $scope.nucode.value,
            "privilege": $scope.initializePrivilegeData(),
            "status": $scope.initializeSelect($scope.status.value)
        };

    }

    $scope.initializePrivilege = function(privileges) {

        if(privileges != null) {

            angular.forEach(privileges, function(value, key) {

                $scope.privileges[key].value = value;

            });

        }

    }

    $scope.initializePrivilegeData = function() {

        let result = {};

        angular.forEach($scope.privileges, function(value, key) {

            result[key] = value.value;

        });

        return result;

    }

    $scope.insert = function(event) {

        let validation = $scope.validateData();

        if(validation) {

            let rest = {
                "data": $scope.initializeInputData(), "url": $scope.global.url.base + "/user/role/insert/"
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

    $scope.togglePrivilege = function(key, action) {

        let current = "0";
        let privilege = "0";

        if(action.toLowerCase() == "view") {

            current = $scope.privileges[key].value.substr(0, 1);

        } else if(action.toLowerCase() == "add") {

            current = $scope.privileges[key].value.substr(1, 1);

        } else if(action.toLowerCase() == "edit") {

            current = $scope.privileges[key].value.substr(2, 1);

        } else if(action.toLowerCase() == "delete") {

            current = $scope.privileges[key].value.substr(3, 1);

        }

        if(current == "0") {

            privilege = "7";

        }

        if(action.toLowerCase() == "view") {

            $scope.privileges[key].value = privilege + $scope.privileges[key].value.substr(1);

        } else if(action.toLowerCase() == "add") {

            $scope.privileges[key].value = $scope.privileges[key].value.substr(0, 1) + privilege + $scope.privileges[key].value.substr(2);

        } else if(action.toLowerCase() == "edit") {

            $scope.privileges[key].value = $scope.privileges[key].value.substr(0, 2) + privilege + $scope.privileges[key].value.substr(3);

        } else if(action.toLowerCase() == "delete") {

            $scope.privileges[key].value = $scope.privileges[key].value.substr(0, 3) + privilege;

        }

    }

    $scope.update = function(event) {

        let validation = $scope.validateData();

        if(validation) {

            let data = $scope.initializeInputData();
            data.id = $scope.id.value;

            let rest = {
                "data": data, "url": $scope.global.url.base + "/user/role/update"
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
            "description": $scope.checkFormLength("description.value", "user-role-description", "response-description", 3, 250),
            "name": $scope.checkFormLengthRequired("name.value", "user-role-name", "response-name", 3, 50),
            "nucode": $scope.checkFormLength("nucode.value", "user-role-nucode", "response-nucode", 1, 50),
            "status": $scope.checkFormSelectRequired("status.value", "user-role-status", "response-status", "Please select status"),
        };

        angular.forEach(valid, function(value) {

            if(!value) {

                result = false;

                return false;

            }

        });

        return result;

    }

}]);
