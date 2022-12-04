app.controller("reportUser", ["$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

    $scope.$on("initializeTable", function() {

        $scope.initializeTable();

        $scope.initializeUserTable();

    });

    $scope.initializeTable = function() {

        let columns = [{
            "data": "_id", "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            "data": "user", "name": "user.username", "render": function(data) {
                return data[0].username;
            }
        }, {
            "data": "user", "name": "user.name", "render": function(data) {
                return data[0].name;
            }
        }, {
            "data": "total", "render": function(data) {
                return data;
            }
        }, {
            "data": "website", "render": function(data) {
                let result = "";

                let website = {};

                angular.forEach(data, function(value) {

                    website = $scope.initializeTableWebsite(value.ids, value.names, value.totals, website);

                });

                angular.forEach(website, function(value) {

                    result += value.name + " : " + value.total + "<br/>";

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("Deposited", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("Redeposited", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("Registered", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("Interested", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("FollowUp", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("NotActive", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("NotPickedUp", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("NotInterested", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                let result = 0;

                angular.forEach(data, function(value) {

                    result = $scope.initializeTableStatus("InvalidNumber", value.names, result, value.totals);

                });

                return result;
            }
        }, {
            "data": "_id", "render": function(data, type, row) {
                return "<a href=\"" + $scope.global.url.base + "/report/user/" + row.user[0]._id.$oid + "/\" class=\"btn btn-outline-secondary btn-sm me-2\" title=\"Analytics\">" + "<i class=\"uil-analytics\"></i>" + "</a>" + "<a href=\"" + $scope.global.url.base + "/worksheet/result/" + row.user[0]._id.$oid + "/\" class=\"btn btn-outline-secondary btn-sm\" title=\"Detail\">" + "<i class=\"uil-file-info-alt\"></i>" + "</a>";
            }
        }];

        if($scope.account.nucode.value == "system") {

            columns.splice(3, 0, {
                "data": "nucode", "name": "nucode", "render": function(data) {
                    return data[0];
                }
            });

        }

        let table = $("#report-user").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/report/user/table/"
            },
            "columns": columns,
            "createdRow": function(row) {
                $compile(angular.element(row).contents())($scope);
            },
            "fnInitComplete": function(response) {

                initializeSelect2("report-filter-group", $scope.initializeSelect2Data(response.json.userGroups, "", "_id", "name"));

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

    }

    $scope.initializeUserTable = function() {

        let columns = [{
            "data": "_id", "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            "data": "date", "name": "date", "render": function(data) {
                return initializeTimestamp(data.$date.$numberLong);
            }
        }, {
            "data": "total", "render": function(data) {
                return data;
            }
        }, {
            "data": "website", "render": function(data) {
                let result = "";
                let website = $scope.initializeTableWebsite(data.ids, data.names, data.totals, {});

                angular.forEach(website, function(value) {

                    result += value.name + " : " + value.total + "<br/>";

                });

                return result;
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("Registered", data.names, 0, data.totals);
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("Interested", data.names, 0, data.totals);
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("FollowUp", data.names, 0, data.totals);
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("NotActive", data.names, 0, data.totals);
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("NotPickedUp", data.names, 0, data.totals);
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("NotInterested", data.names, 0, data.totals);
            }
        }, {
            "data": "status", "render": function(data) {
                return $scope.initializeTableStatus("InvalidNumber", data.names, 0, data.totals);
            }
        }];

        let table = $("#report-user-detail").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");
                    data["userId"] = $("#report-user-detail").attr("data-user-id");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/report/user/detail/table/"
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

        $(".flatpickr-date-range").on("change", function() {

            table.draw();

        });

    }

    $scope.initializeTableStatus = function(name, names, total, totals) {

        let index = names.indexOf(name);

        if(index >= 0) {

            total += totals[index];

        }

        return total;

    }

    $scope.initializeTableWebsite = function(ids, names, totals, website) {

        angular.forEach(ids, function(value, key) {

            if(website.hasOwnProperty(value)) {

                website[value] = {
                    "name": names[key], "total": website[value].total + totals[key]
                };

            } else {

                website[value] = {
                    "name": names[key], "total": totals[key]
                };

            }

        });

        return website;

    }

}

]);
