app.controller("settingApi", ["$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

    $scope.$on("initializeTable", function() {

        let columns = [{
            "data": "_id", "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            "data": "name", "name": "name"
        }, {
            "data": "start", "name": "start", "render": function(data) {
                return initializeTimestamp(data.$date.$numberLong);
            }
        }, {
            "data": "api.nexus.code", "name": "api.nexus.code"
        }, {
            "data": "api.nexus.url", "name": "api.nexus.url"
        }, {
            "data": "api.nexus.salt", "name": "api.nexus.salt"
        }, {
            "data": "_id", "render": function(data) {
                return "<a href=\"" + $scope.global.url.base + "/setting/api/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>";
            }
        }];

        if($scope.account.nucode.value == "system") {

            columns.splice(2, 0, {
                "data": "nucode", "name": "nucode"
            });

        }

        let table = $("#setting-api").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/setting/api/table/"
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
            }, "url": $scope.global.url.base + "/setting/api/initialize-data"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                $scope.nucode.value = $scope.account.nucode.value;

                if(response.website != null) {

                    $scope.id.value = response.website._id;
                    $scope.api.nexus.code.value = response.website.api.nexus.code;
                    $scope.api.nexus.salt.value = response.website.api.nexus.salt;
                    $scope.api.nexus.url.value = response.website.api.nexus.url;
                    $scope.name.value = response.website.name;
                    $scope.nucode.value = response.website.nucode;
                    $scope.start.value = initializeDate(response.website.start.$date.$numberLong);

                }

            } else {

                sweetAlert("error", response.response);

            }

        });

    }

    $scope.initializeInputData = function() {

        return {
            "_token": $("meta[name=\"csrf-token\"]").attr("content"), "api": {
                "nexus": {
                    "code": $scope.api.nexus.code.value,
                    "salt": $scope.api.nexus.salt.value,
                    "url": $scope.api.nexus.url.value
                }
            }, "nucode": $scope.nucode.value, "start": $scope.start.value
        };

    }

    $scope.sync = function(event) {

        let rest = {
            "data": {
                "id": $scope.id.value
            }, "url": $scope.global.url.base + "/setting/api/sync/"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                sweetAlert("success", response.response);

            } else {

                sweetAlert("error", response.response);

            }

        });

        event.preventDefault();

    }

    $scope.update = function(event) {

        let validation = $scope.validateData();

        if(validation) {

            let data = $scope.initializeInputData();
            data.id = $scope.id.value;

            let rest = {
                "data": data, "url": $scope.global.url.base + "/setting/api/update"
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
            "api-nexus-code": $scope.checkFormLengthRequired("api.nexus.code.value", "setting-api-api-nexus-code", "response-api-nexus-code", 3, 3),
            "api-nexus-salt": $scope.checkFormLength("api.nexus.salt.value", "setting-api-api-nexus-salt", "response-api-nexus-salt", 3, 150),
            "api-nexus-url": $scope.checkFormLengthRequired("api.nexus.url.value", "setting-api-api-nexus-url", "response-api-nexus-url", 3, 50),
            "nucode": $scope.checkFormLength("nucode.value", "setting-api-nucode", "response-nucode", 1, 50),
            "start": $scope.checkFormLength("start.value", "setting-api-start", "response-start", 10, 10),
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
