app.controller("database", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $(document).ready(function() {

            let table = $("#database-import-history").DataTable({
                "ajax": {
                    "contentType": "application/json",
                    "data": function(data) {
                        data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                        return JSON.stringify(initializeFilter(data));
                    },
                    "datatype": "json",
                    "type": "POST",
                    "url": $scope.global.url.base + "/database/import/history/table/"
                },
                "columns": [
                    {
                        "data": "_id",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    }, {
                        "data": "file",
                        "name": "file"
                    }, {
                        "data": "website.name",
                        "name": "website._id"
                    }, {
                        "data": "group.name",
                        "name": "group._id"
                    }, {
                        "data": "row",
                        "name": "row"
                    }, {
                        "data": "status",
                        "name": "status"
                    }, {
                        "data": "modified.user.username",
                        "name": "modified.user._id"
                    }, {
                        "data": "modified.timestamp",
                        "name": "modified.timestamp",
                        "render": function(data) {
                            return initializeTimestamp(data.$date.$numberLong);
                        }
                    }, {
                        "data": "_id",
                        "render": function(data) {
                            return "<a href=\"" + $scope.global.url.base + "/database/import/history/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"historyDelete('" + data + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
                        }
                    }
                ],
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

            tableSearch(table);

        });

        $scope.import = {
            "view": false
        };

        $scope.result = {
            "view": false
        };

        $scope.historyDelete = function(id, event) {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                    "id": id
                },
                "url": $scope.global.url.base + "/database/import/history/delete"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    document.getElementById(id).remove();

                    sweetAlert("success", response.response);

                } else {

                    sweetAlert("error", response.response);

                }

            });

            event.preventDefault();

        }

        $scope.import = function() {

            $scope.import.view = true;

            let formData = new FormData();

            formData.append("_token", $("meta[name=\"csrf-token\"]").attr("content"));
            formData.append("group", $scope.group.value);
            formData.append("website", $scope.website.value);

            angular.forEach($scope.files, function(value) {

                formData.append("file", value);

            });

            let rest = {
                "data": formData,
                "url": $scope.global.url.base + "/database/import/import"
            };
            global.restMultipart(rest, function(response) {

                if(response.result) {

                    $scope.import.view = false;

                    sweetAlert("success", response.response);

                } else {

                    sweetAlert("error", response.response);

                }

            });

        }

        $scope.initializeData = function(viewResult) {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content")
                },
                "url": $scope.global.url.base + "/database/import/initialize-data"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    $scope.result.view = Boolean(viewResult);

                    $timeout(function() {

                        initializeSelect2("database-group", $scope.initializeSelect2Data(response.userGroups, $scope.group.value, "_id", "name"));
                        initializeSelect2("database-website", $scope.initializeSelect2Data(response.websites, $scope.website.value, "_id", "name"));

                    });

                } else {

                    sweetAlert("error", response.response);

                }

            });

        }

        $scope.selectFile = function() {

            if($scope.website.value != "") {

                $("#database-import-data").click();

            } else {

                sweetAlert("error", "Please select database website");

            }

        }

    }
]);

app.directive("databaseImportData", function($parse) {

    return {
        "link": function($scope, element, attrs) {

            element.on("change", function(event) {

                $parse(attrs.databaseImportData).assign($scope, element[0].files);
                $scope.$digest();

                $scope.import();

            });

        }
    };

});
