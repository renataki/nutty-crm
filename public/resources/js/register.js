app.controller("register", [
    "$scope", "$window", "$compile", "$timeout", "global", function($scope, $window, $compile, $timeout, global) {

        $scope.termsCondition = {
            "value": false
        };

        $scope.register = function(event) {

            if(event.which == 1 || event.which == 13) {

                let validation = $scope.validateData();

                if(validation) {

                    let rest = {
                        "data": {
                            "_token": $("meta[name=\"csrf-token\"]").attr("content"),
                            "contact": {
                                "email": $scope.contact.email.value
                            },
                            "name": $scope.name.value,
                            "nucode": $scope.nucode.value,
                            "password": {
                                "main": $scope.password.value
                            },
                            "username": $scope.username.value
                        },
                        "url": $scope.global.url.base + "/register/register"
                    };
                    global.rest(rest, function(response) {

                        if(response.result) {

                            $window.location.href = $scope.global.url.base + "/login/";

                        } else {

                            sweetAlert("error", response.response);

                        }

                    });

                } else {

                    sweetAlert("error", "Please input valid data")

                }

                event.preventDefault();

            }

        }

        $scope.toggleTermsCondition = function() {

            if($scope.termsCondition.value) {

                $scope.termsCondition.value = false;

            } else {

                $scope.termsCondition.value = true;

            }

        }

        $scope.validateData = function() {

            let result = true;

            let valid = {
                "email": $scope.checkFormEmail("contact.email.value", "register-contact-email", "response-contact-email"),
                "name": $scope.checkFormLengthRequired("name.value", "register-name", "response-name", 3, 50),
                "nucode": $scope.checkFormLength("nucode.value", "register-nucode", "response-nucode", 2, 50),
                "password": $scope.checkFormPassword("password.value", "register-password", "response-password"),
                "passwordConfirm": $scope.checkFormPasswordConfirm("password.confirm.value", "password.value", "register-password-confirm", "response-password-confirm"),
                "termsCondition": $scope.termsCondition.value,
                "username": $scope.checkFormLengthRequired("username.value", "register-username", "response-username", 3, 20)
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
