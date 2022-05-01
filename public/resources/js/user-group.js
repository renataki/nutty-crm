app.controller("userGroup", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $scope.$on("initializeTable", function() {

            let columns = [
                {
                    "data": "_id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }, {
                    "data": "name",
                    "name": "name"
                }, {
                    "data": "website.names",
                    "name": "website.ids",
                    "render": function(data) {
                        let result = "";

                        data.forEach(function(value) {

                            result += ", " + value;

                        });

                        return result.substr(2);
                    }
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
                        return "<a href=\"" + $scope.global.url.base + "/user/group/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"delete('/user/group/delete/', '" + data + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
                    }
                }
            ];

            if($scope.account.nucode.value == "system") {

                columns.splice(3, 0, {
                    "data": "nucode",
                    "name": "nucode"
                });

            }

            let table = $("#user-group").DataTable({
                "ajax": {
                    "contentType": "application/json",
                    "data": function(data) {
                        data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                        return JSON.stringify(initializeFilter(data));
                    },
                    "datatype": "json",
                    "type": "POST",
                    "url": $scope.global.url.base + "/user/group/table/"
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
                "url": $scope.global.url.base + "/user/group/initialize-data"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    $scope.nucode.value = $scope.account.nucode.value;

                    if(response.userGroup != null) {

                        $scope.id.value = response.userGroup._id;
                        $scope.description.value = response.userGroup.description;
                        $scope.name.value = response.userGroup.name;
                        $scope.nucode.value = response.userGroup.nucode;
                        $scope.status.value = response.userGroup.status;
                        $scope.websites.value = response.userGroup.website.ids;

                    }

                    $scope.websites.option = response.websites;

                    $timeout(function() {

                        $("#user-group-status").val($scope.status.value);

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
                "status": $scope.initializeSelect($scope.status.value),
                "website": {
                    "ids": $scope.websites.value,
                    "names": []
                }
            };

        }

        $scope.insert = function(event) {

            let validation = $scope.validateData();

            if(validation) {

                let rest = {
                    "data": $scope.initializeInputData(),
                    "url": $scope.global.url.base + "/user/group/insert/"
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

        $scope.toggleWebsite = function(id) {

            if($scope.websites.value.includes(id)) {

                $scope.websites.value.splice($scope.websites.value.indexOf(id), 1);

            } else {

                $scope.websites.value.push(id);

            }

        }

        $scope.update = function(event) {

            let validation = $scope.validateData();

            if(validation) {

                let data = $scope.initializeInputData();
                data.id = $scope.id.value;

                let rest = {
                    "data": data,
                    "url": $scope.global.url.base + "/user/group/update"
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
                "description": $scope.checkFormLength("description.value", "user-group-description", "response-description", 3, 250),
                "name": $scope.checkFormLengthRequired("name.value", "user-group-name", "response-name", 3, 50),
                "nucode": $scope.checkFormLength("nucode.value", "user-group-nucode", "response-nucode", 1, 50),
                "status": $scope.checkFormSelectRequired("status.value", "user-group-status", "response-status", "Please select status"),
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
