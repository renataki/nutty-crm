app.controller("license", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $scope.$on("initializeTable", function() {

            let columns = [
                {
                    "data": "_id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }, {
                    "data": "nucode",
                    "name": "nucode"
                }, {
                    "data": "user.total",
                    "name": "user.total"
                }, {
                    "data": "package.status",
                    "name": "package.status"
                }, {
                    "data": "modified.timestamp",
                    "name": "modified.timestamp",
                    "render": function(data) {
                        return initializeTimestamp(data.$date.$numberLong);
                    }
                }, {
                    "data": "_id",
                    "render": function(data, type, row) {
                        return "<a href=\"" + $scope.global.url.base + "/license/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"delete('" + data + "', '" + row.nucode + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
                    }
                }
            ];

            let table = $("#license").DataTable({
                "ajax": {
                    "contentType": "application/json",
                    "data": function(data) {
                        data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                        return JSON.stringify(initializeFilter(data));
                    },
                    "datatype": "json",
                    "type": "POST",
                    "url": $scope.global.url.base + "/license/table/"
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

        $scope.delete = function(id, nucode, event) {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                    "nucode": nucode
                },
                "url": $scope.global.url.base + "/license/delete"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    document.getElementById(id).remove();

                    sweetAlert("success", response.response);

                }

            });

            event.preventDefault();

        }

        $scope.initializeData = function(id) {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                    "id": id
                },
                "url": $scope.global.url.base + "/license/initialize-data"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    $scope.nucode.value = $scope.account.nucode.value;

                    if(response.license != null) {

                        $scope.id.value = response.license._id;
                        $scope.nucode.value = response.license.nucode;
                        $scope.user.total.value = response.license.user.total;

                    }

                    $timeout(function() {

                    });

                } else {

                    sweetAlert("error", response.response);

                }

            });

        }

        $scope.initializeInputData = function() {

            return {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                "nucode": $scope.nucode.value,
                "user": {
                    "total": $scope.user.total.value
                }
            };

        }

        $scope.update = function(event) {

            let validation = $scope.validateData();

            if(validation) {

                let data = $scope.initializeInputData();
                data.id = $scope.id.value;

                let rest = {
                    "data": data,
                    "url": $scope.global.url.base + "/license/update"
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
                "nucode": $scope.checkFormLength("nucode.value", "license-nucode", "response-nucode", 1, 50),
                "user-total": $scope.checkFormIntegerRequired("user.total.value", "license-user-total", "response-user-total", "Please input number only")
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
