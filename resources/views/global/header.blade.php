<body>
<div id="layout-wrapper">
    <base ng-init="initializeGlobal()" data-application-name="{{Component::appName()}}" data-cookie-path=""
          data-cookie-prefix="" data-datetime-format="" data-datetime-offset="" data-datetime-timezone=""
          data-url-audio="" data-url-base="{{Component::appUrl()}}" data-url-html="" data-url-image="" data-url-video=""
          data-url-websocket=""/>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="{{config("app.url")}}/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset("resources/images/logo-sm.png")}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset("resources/images/logo-dark.png")}}" alt="" height="20">
                        </span>
                    </a>
                    <a href="{{config("app.url")}}/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset("resources/images/logo-sm.png")}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset("resources/images/logo-light.png")}}" alt="" height="20">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="uil-search"></span>
                    </div>
                </form>
            </div>
            <div class="d-flex">
                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button id="page-header-search-dropdown" class="btn header-item noti-icon waves-effect"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="uil-search"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                         aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                           aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dropdown d-inline-block language-switch">
                    <button type="button" class="btn header-item waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset("resources/images/us.jpg")}}" alt="Header Language" height="16">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{asset("resources/images/spain.jpg")}}" alt="user-image" class="me-1"
                                 height="12"> <span
                                class="align-middle">Spanish</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{asset("resources/images/germany.jpg")}}" alt="user-image" class="me-1"
                                 height="12"> <span
                                class="align-middle">Germany</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{asset("resources/images/italy.jpg")}}" alt="user-image" class="me-1"
                                 height="12"> <span
                                class="align-middle">Italian</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{asset("resources/images/russia.jpg")}}" alt="user-image" class="me-1"
                                 height="12"> <span
                                class="align-middle">Russian</span>
                        </a>
                    </div>
                </div>
                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button class="btn header-item noti-icon waves-effect" type="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="uil-apps"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <div class="px-lg-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset("resources/images/github.png")}}" alt="Github">
                                        <span>GitHub</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset("resources/images/bitbucket.png")}}" alt="bitbucket">
                                        <span>Bitbucket</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset("resources/images/dribbble.png")}}" alt="dribbble">
                                        <span>Dribbble</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset("resources/images/dropbox.png")}}" alt="dropbox">
                                        <span>Dropbox</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset("resources/images/mail-chimp.png")}}" alt="mail_chimp">
                                        <span>Mail Chimp</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset("resources/images/slack.png")}}" alt="slack">
                                        <span>Slack</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button class="btn header-item noti-icon waves-effect" type="button" data-bs-toggle="fullscreen">
                        <i class="uil-minus-path"></i>
                    </button>
                </div>
                <div class="dropdown d-inline-block">
                    <button id="page-header-notifications-dropdown" class="btn header-item noti-icon waves-effect"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="uil-bell"></i>
                        <span class="badge bg-danger rounded-pill">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-16"> Notifications </h5>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small"> Mark all as read</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            <a href="javascript:void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="uil-shopping-basket"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Your order is placed</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">If several languages coalesce the grammar</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{asset("resources/images/avatar-3.jpg")}}"
                                             class="rounded-circle avatar-xs" alt="user-pic">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">James Lemire</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">It will seem like simplified English.</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hour ago</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="uil-truck"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Your item is shipped</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">If several languages coalesce the grammar</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{asset("resources/images/avatar-4.jpg")}}"
                                             class="rounded-circle avatar-xs" alt="user-pic">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Salena Layfield</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 border-top">
                            <div class="d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="uil-arrow-circle-right me-1"></i> View More..
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button id="page-header-user-dropdown" class="btn header-item waves-effect" type="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{asset("resources/images/avatar-4.jpg")}}"
                             alt="Header Avatar">
                        @if(Session::has("account"))
                            <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">
                                {{Session::get("account")->name}}
                            </span>
                        @endif
                        <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{url("user/profile/")}}/">
                            <i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i>
                            <span class="align-middle">Profile</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="uil uil-wallet font-size-18 align-middle me-1 text-muted"></i>
                            <span class="align-middle">My Wallet</span>
                        </a>
                        <a class="dropdown-item d-block" href="#">
                            <i class="uil uil-cog font-size-18 align-middle me-1 text-muted"></i>
                            <span class="align-middle">Settings</span>
                            <span class="badge bg-soft-success rounded-pill mt-1 ms-2">03</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="uil uil-lock-alt font-size-18 align-middle me-1 text-muted"></i>
                            <span class="align-middle">Lock screen</span>
                        </a>
                        <a class="dropdown-item" href="#" ng-click="logout($event)">
                            <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i>
                            <span class="align-middle">Sign out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="vertical-menu">
        <div class="navbar-brand-box">
            <a href="index.html" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{asset("resources/images/logo-sm.png")}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{asset("resources/images/logo-dark.png")}}" alt="" height="20">
                </span>
            </a>
            <a href="index.html" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{asset("resources/images/logo-sm.png")}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{asset("resources/images/logo-light.png")}}" alt="" height="20">
                </span>
            </a>
        </div>
        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>
        <div data-simplebar class="sidebar-menu-scroll">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    @if(Session::has("account"))
                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="{{config("app.url")}}/">
                                <i class="uil-home-alt"></i><span
                                    class="badge rounded-pill bg-primary float-end">01</span>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if(substr(Session::get("account")->privilege["user"], 0, 1) == "7")
                            <li class="menu-title">User</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-user"></i>
                                    <span>User</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url("user")}}/">List</a></li>
                                    <li><a href="{{url("user/entry")}}/">Add New</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(substr(Session::get("account")->privilege["userRole"], 0, 1) == "7")
                            <li>
                                <a href="javascript:void(0);" class="has-arrow waves-effect">
                                    <i class="uil-user-check"></i>
                                    <span>Role</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url("user/role")}}/">List</a></li>
                                    <li><a href="{{url("user/role/entry")}}/">Add New</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(substr(Session::get("account")->privilege["userGroup"], 0, 1) == "7")
                            <li>
                                <a href="javascript:void(0);" class="has-arrow waves-effect">
                                    <i class="uil-users-alt"></i>
                                    <span>Group</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url("user/group")}}/">List</a></li>
                                    <li><a href="{{url("user/group/entry")}}/">Add New</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(substr(Session::get("account")->privilege["website"], 0, 1) == "7")
                            <li class="menu-title">Website</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-globe"></i>
                                    <span>Website</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url("website")}}/">List</a></li>
                                    <li><a href="{{url("website/entry")}}/">Add New</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(substr(Session::get("account")->privilege["database"], 0, 1) == "7" || substr(Session::get("account")->privilege["worksheet"], 0, 1) == "7")
                            <li class="menu-title">Apps</li>
                            @if(substr(Session::get("account")->privilege["worksheet"], 0, 1) == "7")
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="uil-outgoing-call"></i>
                                        <span>Worksheet</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="{{url("worksheet")}}/">New Data</a></li>
                                        <li><a href="{{url("worksheet/result")}}/">Result</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if(substr(Session::get("account")->privilege["database"], 0, 1) == "7")
                                <li class="menu-title">Database</li>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="uil-database"></i>
                                        <span>Database</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="{{url("database")}}/">List</a></li>
                                        <li>
                                            <a href="javascript: void(0);" class="has-arrow" aria-expanded="false">Import</a>
                                            <ul class="sub-menu" aria-expanded="false">
                                                <li><a href="{{url("database/import")}}/">New Data</a></li>
                                                <li><a href="{{url("database/import/history")}}/">History</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                        @if(substr(Session::get("account")->privilege["report"], 0, 1) == "7")
                            <li class="menu-title">Report</li>
                            @if(substr(Session::get("account")->privilege["report"], 0, 1) == "7")
                                <li>
                                    <a href="{{url("report")}}/">
                                        <i class="uil-graph-bar"></i>
                                        <span>Report</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if(substr(Session::get("account")->privilege["setting"], 0, 1) == "7")
                            <li class="menu-title">Setting</li>
                            @if(substr(Session::get("account")->privilege["setting"], 0, 1) == "7")
                                <li>
                                    <a href="{{url("setting")}}/">
                                        <i class="uil-cog"></i>
                                        <span>Setting</span>
                                    </a>
                                </li>
                            @endif
                            @if(substr(Session::get("account")->privilege["settingApi"], 0, 1) == "7")
                                <li>
                                    <a href="{{url("setting/api")}}/">
                                        <i class="uil-exchange"></i>
                                        <span>API</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if(Session::get("account")->nucode == "system" && Session::get("account")->username == "system")
                            <li class="menu-title">License</li>
                            <li>
                                <a href="{{url("license")}}/">
                                    <i class="uil-file-bookmark-alt"></i>
                                    <span>License</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
