<!doctype html>
<html lang="en" ng-app="application" ng-controller="global">
<head>
    <meta charset="utf-8"/>
    <title>{{Component::appName()}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta name="description" content="{{Component::appName()}}"/>
    <link rel="shortcut icon" href="{{asset("resources/images/favicon.ico")}}"/>
    <link id="bootstrap-style"
          href="{{asset("resources/css/library/bootstrap/bootstrap.min.css?v=" . config("app.version"))}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset("resources/css/library/datatables/datatables-bootstrap.min.css?v=" . config("app.version"))}}"
          rel="stylesheet" type="text/css"/>
    <link
        href="{{asset("resources/css/library/datatables/datatables-buttons-bootstrap.min.css?v=" . config("app.version"))}}"
        rel="stylesheet" type="text/css"/>
    <link
        href="{{asset("resources/css/library/datatables/datatables-responsive-bootstrap.min.css?v=" . config("app.version"))}}"
        rel="stylesheet" type="text/css"/>
    <link href="{{asset("resources/css/library/flatpickr/flatpickr.min.css?v=" . config("app.version"))}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset("resources/css/library/select2/select2.min.css?v=" . config("app.version"))}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset("resources/css/library/sweetalert2/sweetalert2.min.css?v=" . config("app.version"))}}"
          rel="stylesheet" type="text/css"/>
    <link id="app-style" href="{{asset("resources/css/library/template/app.min.css?v=" . config("app.version"))}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset("resources/css/library/template/icons.min.css?v=" . config("app.version"))}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset("resources/css/global.css?v=" . config("app.version"))}}" rel="stylesheet" type="text/css"/>
    @foreach($layout->css as $css)
        <link href="{{asset("resources/css") . "/" . $css . "?v=" . config("app.version")}}" rel="stylesheet"
              type="text/css"/>
    @endforeach
</head>
