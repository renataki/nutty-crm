let setting = {
    "table": {
        "length": {
            "default": 20, "option": [10, 20, 50, 100, 200, 500, 1000]
        }
    }
};


function initializeDate(timestamp) {

    let date = new Date();
    date.setTime(timestamp);

    return date.getFullYear() + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" + ("0" + date.getDate()).slice(-2);

}


function initializeFilter(data) {

    $(".dt-input").each(function() {

        data.columns[$(this).attr("data-column")]["search"]["regex"] = $(this).attr("data-regex");
        data.columns[$(this).attr("data-column")]["search"]["value"] = $(this).val();

    });

    $(".dt-select").each(function() {

        data.columns[$(this).attr("data-column")]["search"]["regex"] = $(this).attr("data-regex");
        data.columns[$(this).attr("data-column")]["search"]["value"] = $(this).val();

    });

    return data;

}


function initializeNumber(number, trim) {

    let result = "";

    number = number.toString().replace(/[^0-9.-]/g, "");

    let prefix = "";

    if(number.startsWith("-")) {

        prefix = "-";
        number = number.replace("-", "");

    }

    number = number.split(".");
    number[0] = number[0].split("");

    let index = 0;
    let separator = 3;

    for(let i = number[0].length - 1; i >= 0; i--) {

        if(index == separator) {

            result = "," + result;
            separator = separator + 3;

        }

        result = number[0][i] + result;

        index++;

    }

    if(number.length > 1) {

        if(trim) {

            number[1] = number[1].split("");

            let decimal = "";

            for(let i = number[1].length - 1; i >= 0; i--) {

                if(!trim || number[1][i] != "0") {

                    decimal = number[1][i] + decimal;
                    trim = false;

                }

            }

            if(decimal != "") {

                result = result + "." + decimal;

            }

        } else {

            result = result + "." + number[1];

        }

    }

    result = prefix + result;

    return result;

}


function initializeSelect2(id, data) {

    let select2 = null;

    if(data != null) {

        select2 = $("#" + id).select2({data: data});

    } else {

        select2 = $("#" + id).select2();

    }

    select2.on("change", function() {

        initializeSelect2Event(select2);

    });

}


function initializeSelect2Event(select2) {

    let element = angular.element(document.getElementById(select2.attr("id")));

    if(element) {

        element.scope().select2(select2.attr("data-error"), select2.attr("data-input"), select2.attr("data-required"), select2.attr("data-response"), select2.attr("data-scope"), select2.attr("data-success"), select2.val());

    }

}


function initializeThirdParty() {

    $(".select2").each(function() {

        if($(this).attr("data-value")) {

            $(this).val($(this).attr("data-value"));

        }

        $(this).select2().on("change", function() {

            initializeSelect2Event($(this));

        });

    });

    $(".flatpickr-date").flatpickr({
        "dateFormat": "Y/m/d"
    });

    $(".flatpickr-date-range").flatpickr({
        "mode": "range"
    });

}


function initializeTimestamp(timestamp) {

    let date = new Date();
    date.setTime(timestamp);

    return ("0" + date.getDate()).slice(-2) + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + ":" + ("0" + date.getSeconds()).slice(-2);

}


function standardCase(string) {

    return string.replace(/([A-Z]+)/g, " $1").replace(/([A-Z][a-z])/g, " $1").replace(/([0-9]+)/g, " $1").trim();

}


function sweetAlert(icon, title) {

    Swal.fire({
        icon: icon, title: title, showConfirmButton: !1, timer: 1000, customClass: {
            confirmButton: "btn btn-primary"
        }, buttonsStyling: !1
    });

}


function tableSearch(table) {

    $(".dt-input").on("change", function(event) {

        table.draw();

    });

    $(".dt-select").on("change", function(event) {

        table.draw();

    });

}


$(document).ready(function() {

    $(".header-item").click(function() {

        if($(this).next().hasClass("show")) {

            $(this).next().removeClass("show");

        } else {

            $(this).next().addClass("show");

        }

    });

    initializeThirdParty();

});

let app = angular.module("application", ["ngSanitize"]);

app.config(["$httpProvider", function($httpProvider) {

    $httpProvider.defaults.headers.post["X-XSRF-TOKEN"] = '';
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common["X-Requested-With"];

}]);

app.controller("global", ["$scope", "$window", "$parse", "global", function($scope, $window, $parse, global) {

    $scope.account = {
        "nucode": {
            "value": ""
        }, "type": {
            "value": ""
        }, "username": {
            "value": ""
        }
    };

    $scope.api = {
        "nexus": {
            "code": {
                "value": ""
            }, "salt": {
                "value": ""
            }, "url": {
                "value": ""
            }
        }
    };

    $scope.contact = {
        "email": {
            "value": ""
        }, "phone": {
            "value": "", "view": false
        }, "whatsapp": {
            "value": "", "view": false
        }
    };

    $scope.crm = {
        "value": ""
    };

    $scope.description = {
        "value": ""
    };
    $scope.textMessage = {
        "value": ""
    };
    $scope.global = {
        "application": {
            "name": ""
        }, "cookie": {
            "path": "", "prefix": ""
        }, "dateTime": {
            "format": "", "offset": "", "timezone": ""
        }, "url": {
            "audio": "", "base": "", "html": "", "image": "", "video": "", "websocket": ""
        }
    };

    $scope.group = {
        "value": ""
    };

    $scope.id = {
        "value": ""
    };

    $scope.name = {
        "value": ""
    };

    $scope.nucode = {
        "value": ""
    };

    $scope.password = {
        "current": {
            "value": ""
        }, "confirm": {
            "value": ""
        }, "value": ""
    };

    $scope.privileges = {
        "database": {
            "name": "Database", "value": "0000"
        }, "report": {
            "name": "ReportUser", "value": "0000"
        }, "setting": {
            "name": "Setting", "value": "0000"
        }, "settingApi": {
            "name": "Setting API", "value": "0000"
        }, "user": {
            "name": "User", "value": "0000"
        }, "userGroup": {
            "name": "User Group", "value": "0000"
        }, "userRole": {
            "name": "User Role", "value": "0000"
        }, "website": {
            "name": "Website", "value": "0000"
        }, "worksheet": {
            "name": "Worksheet", "value": "0000"
        }
    };

    $scope.reference = {
        "value": ""
    };

    $scope.role = {
        "value": ""
    };

    $scope.start = {
        "value": ""
    };

    $scope.status = {
        "value": ""
    };

    $scope.sync = {
        "value": "NoSync"
    };

    $scope.telemarketer = {
        "value": ""
    };

    $scope.type = {
        "value": ""
    };

    $scope.user = {
        "total": {
            "value": 0
        }
    };

    $scope.username = {
        "value": ""
    };

    $scope.website = {
        "value": ""
    };

    $scope.websites = {
        "option": [], "value": []
    };

    $scope.checkFormDecimalRequired = function(scope, input, response, error) {

        let result = false;

        if($scope.$eval(scope) != null) {

            result = $scope.checkNumber($scope.$eval(scope), true);

        }

        $scope.initializeResponse(input, response, result, error);

        return result;

    }

    $scope.checkFormEmail = function(scope, input, response) {

        let result = false;

        if($scope.$eval(scope) != "") {

            if($scope.$eval(scope).match(/^([0-9A-Za-z_\-\.]){1,}\@([0-9A-Za-z_\-\.]){1,}\.([A-Za-z]){2,}$/)) {

                result = true;

            }

        } else {

            result = true;

        }

        $scope.initializeResponse(input, response, result, "Please input valid email address")

        return result;

    }

    $scope.checkFormIntegerRequired = function(scope, input, response, error) {

        let result = false;

        if($scope.$eval(scope) != null) {

            result = $scope.checkNumber($scope.$eval(scope), false);

        }

        $scope.initializeResponse(input, response, result, error);

        return result;

    }

    $scope.checkFormLength = function(scope, input, response, min, max) {

        let result = true;

        if($scope.$eval(scope) != "") {

            result = $scope.checkFormLengthRequired(scope, input, response, min, max);

        } else {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback").addClass("valid-feedback").html("Look's good");

        }

        return result;

    }

    $scope.checkFormLengthRequired = function(scope, input, response, min, max) {

        let result = $scope.checkLength($scope.$eval(scope), min, max);

        $scope.initializeResponse(input, response, result, "Please input between " + min + " - " + max + " characters");

        return result;

    }

    $scope.checkFormPassword = function(scope, input, response) {

        let result = false;

        if($scope.$eval(scope).length < 3) {

            $("#" + input).removeClass("is-valid").addClass("is-invalid");
            $("#" + response).removeClass("valid-feedback").addClass("invalid-feedback").html("Please enter more than 2 characters");

        } else if(/[a-z]/.test($scope.$eval(scope)) && /[A-Z]/.test($scope.$eval(scope)) && /[0-9]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback text-warning").addClass("valid-feedback").html("Strong password");

            result = true;

        } else if((/[A-Z]/.test($scope.$eval(scope)) && /[0-9]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)) && /[0-9]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)) && /[A-Z]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)) && /[A-Z]/.test($scope.$eval(scope)) && /[0-9]/.test($scope.$eval(scope)))) {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback text-warning").addClass("valid-feedback").html("Secured password");

            result = true;

        } else if((/[0-9]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[A-Z]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[A-Z]/.test($scope.$eval(scope)) && /[0-9]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)) && /[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)) && /[0-9]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)) && /[A-Z]/.test($scope.$eval(scope)))) {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback").addClass("valid-feedback text-warning").html("Medium password");

            result = true;

        } else if((/[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/.test($scope.$eval(scope))) || (/[0-9]/.test($scope.$eval(scope))) || (/[A-Z]/.test($scope.$eval(scope))) || (/[a-z]/.test($scope.$eval(scope)))) {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback").addClass("valid-feedback text-warning").html("Low password");

            result = true;

        } else {

            result = true;

        }

        return result;

    }

    $scope.checkFormPasswordConfirm = function(scope, scopeConfirm, input, response) {

        let result = false;

        if($scope.$eval(scopeConfirm) != $scope.$eval(scope)) {

            $("#" + input).removeClass("is-valid").addClass("is-invalid");
            $("#" + response).removeClass("valid-feedback").addClass("invalid-feedback").html("Password doesn't match");

        } else {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback").addClass("valid-feedback").html("Look's good");

            result = true;

        }

        return result;

    }

    $scope.checkFormSelectRequired = function(scope, input, response, error) {

        let result = $scope.checkSelect($scope.$eval(scope));

        $scope.initializeResponse(input, response, result, error);

        return result;

    }

    $scope.checkLength = function(string, min, max) {

        let result = false;

        if(string != "") {

            if(string.length >= min && string.length <= max) {

                result = true;

            }

        }

        return result;

    }

    $scope.checkNumber = function(string, decimal) {

        let result = false;

        string = string.toString();

        if(string != "") {

            if(decimal && string.match(/^[0-9,.]+$/)) {

                result = true;

            } else if(!decimal && string.match(/^[0-9,]+$/)) {

                result = true;

            } else if(!decimal && string.match(/^[0-9]+$/)) {

                result = true;

            }

        }

        return result;

    }

    $scope.checkSelect = function(value) {

        let result = false;

        if(value != "") {

            result = true;

        }

        return result;

    }

    $scope.delete = function(url, id, event) {

        let rest = {
            "data": {
                "_token": $("meta[name=\"csrf-token\"]").attr("content"), "id": id
            }, "url": $scope.global.url.base + url
        };
        global.rest(rest, function(response) {

            if(response.result) {

                document.getElementById(id).remove();

                sweetAlert("success", response.response);

            }

        });

        event.preventDefault();

    }

    $scope.initializeAccount = function() {

        if($scope.account.nucode.value == "") {

            let rest = {
                "data": {
                    "_token": $("meta[name=\"csrf-token\"]").attr("content")
                }, "url": $scope.global.url.base + "/security/initialize-account"
            };
            global.rest(rest, function(response) {

                if(response.result) {

                    $scope.account.nucode.value = response.account.nucode;
                    $scope.account.type.value = response.account.type;

                    $scope.$broadcast("initializeTable");

                }

            });

        }

    }

    $scope.initializeGlobal = function() {

        let base = document.getElementsByTagName("base");

        if(base.length > 0) {

            $scope.global.application.name = base[0].getAttribute("data-application-name");
            $scope.global.cookie.path = base[0].getAttribute("data-cookie-path");
            $scope.global.cookie.prefix = base[0].getAttribute("data-cookie-prefix");

            $scope.global.dateTime.format = base[0].getAttribute("data-datetime-format");
            $scope.global.dateTime.offset = base[0].getAttribute("data-datetime-offset");
            $scope.global.dateTime.timezone = base[0].getAttribute("data-datetime-timezone");

            $scope.global.url.audio = base[0].getAttribute("data-url-audio");

            if(base[0].getAttribute("data-url-base") != null) {

                $scope.global.url.base = base[0].getAttribute("data-url-base");

            }

            $scope.global.url.html = base[0].getAttribute("data-url-html");
            $scope.global.url.image = base[0].getAttribute("data-url-image");
            $scope.global.url.video = base[0].getAttribute("data-url-video");
            $scope.global.url.websocket = base[0].getAttribute("data-url-websocket");

            $scope.initializeAccount();

        }

    }

    $scope.initializeResponse = function(input, response, result, error) {

        if(!result) {

            $("#" + input).removeClass("is-valid").addClass("is-invalid");
            $("#" + response).removeClass("valid-feedback").addClass("invalid-feedback").html(error);

        } else {

            $("#" + input).removeClass("is-invalid").addClass("is-valid");
            $("#" + response).removeClass("invalid-feedback").addClass("valid-feedback").html("Look's good");

        }

    }

    $scope.initializeSelect = function(value) {

        return value.replaceAll("string:?", "").replaceAll("string:", "").replaceAll("string", "").replaceAll("?", "").trim();

    }

    $scope.initializeSelect2Data = function(options, selected, id, text) {

        let result = [];

        if(options != null) {

            angular.forEach(options, function(value) {

                let data = {
                    "id": value, "text": value
                };

                if(value == selected) {

                    data.selected = true;

                }

                if(id != null && text != null) {

                    data = {
                        "id": value[id], "text": value[text]
                    };

                    if(value[id] == selected) {

                        data.selected = true;

                    }

                }

                result.push(data);

            });

        }

        return result;

    }

    $scope.logout = function(event) {

        let rest = {
            "data": {
                "_token": $("meta[name=\"csrf-token\"]").attr("content")
            }, "url": $scope.global.url.base + "/login/logout"
        };
        global.rest(rest, function(response) {

            if(response.result) {

                $window.location.reload();

            }

        });

        event.preventDefault();

    }

    $scope.select2 = function(error, input, required, response, scope, success, value) {

        if(scope != null) {

            $parse(scope).assign($scope, value);

            if(required) {

                $scope.checkFormSelectRequired(scope, input, response, error);

            }

        }

    }

    $scope.thirdParty = function(key, value) {

        if(key != null) {

            $parse(key).assign($scope, value);

        }

    }

}]);

app.provider("global", function() {

    this.$get = ["$http", function($http) {

        return {
            "rest": function(rest, callback) {

                $http({
                    "data": rest.data,
                    "headers": {"Content-Type": "application/json"},
                    "method": "POST",
                    "url": rest.url
                }).then(function(response) {

                    callback(response.data);

                });

            }, "restMultipart": function(rest, callback) {

                $http({
                    "data": rest.data, "headers": {
                        "Content-Type": undefined, "Process-Data": false
                    }, "method": "POST", "transformRequest": angular.identity, "url": rest.url
                }).then(function(response) {

                    callback(response.data);

                });

            }
        };

    }];

});
