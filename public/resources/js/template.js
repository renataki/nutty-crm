app.controller("template", ["$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

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
                return "<a href=\"" + $scope.global.url.base + "/template/entry/" + data + "/\" class=\"btn btn-outline-secondary btn-sm me-2 edit\" title=\"Edit\">" + "<i class=\"fas fa-pencil-alt\"></i>" + "</a>" + "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm delete\" title=\"Delete\" ng-click=\"delete('/template/delete/', '" + data + "', $event)\"'>" + "<i class=\"fas fa-trash-alt\"></i>" + "</a>";
            }
        }];

        if($scope.account.nucode.value == "system") {

            columns.splice(2, 0, {
                "data": "nucode", "name": "nucode"
            });

        }

        let table = $("#template").DataTable({
            "ajax": {
                "contentType": "application/json", "data": function(data) {
                    data["_token"] = $("meta[name=\"csrf-token\"]").attr("content");

                    return JSON.stringify(initializeFilter(data));
                }, "datatype": "json", "type": "POST", "url": $scope.global.url.base + "/template/table/"
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
            }, "url": $scope.global.url.base + "/template/initialize-data"
        };
        global.rest(rest, function(response) {
            if(response.result) {

                $scope.nucode.value = $scope.account.nucode.value;

                if(response.template != null) {
                    $scope.name.value = response.template.name;
                    $scope.id.value = response.template._id;
                    $scope.description.value = response.template.description;
                    $scope.textMessage.value = response.template.textMessage;
                    $scope.isDefault.value = response.template.isDefault;
                    $scope.nucode.value = response.template.nucode;
                    $scope.mediaType.value = response.template.media.mediaType;
                    $scope.mediaUrl.value = response.template.media.mediaUrl;
                    $scope.status.value = response.template.status;
                }

                $timeout(function() {

                    $("#template-status").val($scope.status.value);
                    $("#template-mediaType").val($scope.mediaType.value);

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
            "textMessage": $scope.textMessage.value,
            "name": $scope.name.value,
            "nucode": $scope.nucode.value,
            "isDefault": $scope.isDefault.value,
            "media": {
                "mediaType": $scope.initializeSelect($scope.mediaType.value), "mediaUrl": $scope.mediaUrl.value
            },
            "status": $scope.initializeSelect($scope.status.value)
        };

    }

    $scope.insert = function(event) {
        //console.warn($scope.initializeInputData());
        let validation = $scope.validateData();

        if(validation) {

            let rest = {
                "data": $scope.initializeInputData(), "url": $scope.global.url.base + "/template/insert/"
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

    $scope.toggleIsDefault = function() {

        let current = "false";
        let isDefault = "false";

        current = $scope.isDefault.value;

        if(current == "false") {

            isDefault = "true";

        }

        $scope.isDefault.value = isDefault;

    }

    $scope.update = function(event) {
        //console.warn($scope.initializeInputData());
        let validation = $scope.validateData();

        if(validation) {

            let data = $scope.initializeInputData();
            data.id = $scope.id.value;

            let rest = {
                "data": data, "url": $scope.global.url.base + "/template/update"
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
            "description": $scope.checkFormLength("description.value", "template-description", "response-description", 3, 250),
            "textMessage": $scope.checkFormLengthRequired("textMessage.value", "template-textMessage", "response-textMessage", 3, 250),
            "name": $scope.checkFormLengthRequired("name.value", "template-name", "response-name", 3, 50),
            "nucode": $scope.checkFormLength("nucode.value", "template-nucode", "response-nucode", 1, 50),
            "status": $scope.checkFormSelectRequired("status.value", "template-status", "response-status", "Please select status")
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
