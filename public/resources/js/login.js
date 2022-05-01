app.controller("login", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $scope.login = function(event) {

            if(event.which == 1 || event.which == 13) {

                let rest = {
                    "data": {
                        "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                        "nucode": $scope.nucode.value,
                        "password": $scope.password.value,
                        "username": $scope.username.value
                    },
                    "url": $scope.global.url.base + "/login/login"
                };
                global.rest(rest, function(response) {

                    if(response.result) {

                        angular.element(document).ready(function() {

                            document.getElementsByTagName("form")[0].submit();

                        });

                    } else {

                        sweetAlert("error", response.response);

                    }

                });

                event.preventDefault();

            }

        }

    }
]);
