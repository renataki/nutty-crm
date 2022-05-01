app.controller("database", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $(document).ready(function() {

            let table = $("#database").DataTable({
                "ajax": {
                    "contentType": "application/json",
                    "data": function(data) {
                        data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                        return JSON.stringify(initializeFilter(data));
                    },
                    "datatype": "json",
                    "type": "POST",
                    "url": $scope.global.url.base + "/database/table/"
                },
                "columns": [
                    {
                        "data": "_id",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    }, {
                        "data": "name",
                        "name": "name"
                    }, {
                        "data": "contact.phone",
                        "name": "contact.phone",
                        "render": function(data) {
                            let result = "";

                            let dataArray = String(data).split("");

                            dataArray.forEach(function(value, key) {

                                if(key < dataArray.length - 3) {

                                    result += "*";

                                } else {

                                    result += value;

                                }

                            });

                            return result;
                        }
                    }, {
                        "data": "group.name",
                        "name": "group._id"
                    }, {
                        "data": "telemarketer.username",
                        "name": "telemarketer._id"
                    }, {
                        "data": "crm.username",
                        "name": "crm._id"
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
                            return "<a href=\"" + $scope.global.url.base + "/database/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"delete('/database/delete/', '" + data + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
                        }
                    }
                ],
                "createdRow": function(row) {
                    $compile(angular.element(row).contents())($scope);
                },
                "fnInitComplete": function(response) {

                    initializeSelect2("database-filter-website", null);

                },
                "lengthMenu": setting.table.length.option,
                "pageLength": setting.table.length.default,
                "processing": !0,
                "rowId": "_id",
                "searching": false,
                "serverSide": !0
            });

            tableSearch(table);

        });

    }
]);
