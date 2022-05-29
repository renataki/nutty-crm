app.controller("reportWebsite", ["$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

    $scope.$on("initializeTable", function() {

        let columns = [{
            "data": "_id", "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            "data": "website", "name": "website.name", "render": function(data) {
                return data[0].name;
            }
        }, {
            "data": "total", "render": function(data) {
                return data;
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
                return "<a href=\"" + $scope.global.url.base + "/report/website/" + row.website[0]._id.$oid + "/\" class=\"btn btn-outline-secondary btn-sm me-2\" title=\"Analytics\">" + "<i class=\"uil-analytics\"></i>" + "</a>";
            }
        }];

        if($scope.account.nucode.value == "system") {

            columns.splice(2, 0, {
                "data": "nucode", "name": "nucode", "render": function(data) {
                    return data[0];
                }
            });

        }

        let table = $("#report-website").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/report/website/table/"
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

    $scope.initializeTableStatus = function(name, names, total, totals) {

        let index = names.indexOf(name);

        if(index >= 0) {

            total += totals[index];

        }

        return total;

    }

}

]);
