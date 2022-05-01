app.controller("encryption", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $scope.action = {
            "value": ""
        };

        $scope.result = {
            "value": ""
        };

        $scope.string = {
            "value": ""
        };

        $scope.encrypt = function(event) {

            if(event.which == 1 || event.which == 13) {

                let validation = $scope.validateData();

                if(validation) {

                    let rest = {
                        "data": {
                            "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                            "action": $scope.action.value,
                            "string": $scope.string.value
                        },
                        "url": $scope.global.url.base + "/security/encryption/encrypt"
                    };
                    global.rest(rest, function(response) {

                        if(response.result) {

                            sweetAlert("success", response.response);

                            $scope.result.value = response.string;

                            $scope.$digest();

                        } else {

                            sweetAlert("error", response.response);

                        }

                    });

                } else {

                    sweetAlert("error", "Please input valid data");

                }

                event.preventDefault();

            }

        }

        $scope.initializeData = function() {

            initializeSelect2("encryption-action", null);

        }

        $scope.validateData = function() {

            let result = true;

            let valid = {
                "action": $scope.checkFormSelectRequired("action.value", "encryption-action", "response-action", "Please select action")
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
