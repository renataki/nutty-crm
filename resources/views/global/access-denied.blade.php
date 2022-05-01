@include("global.head")
<body class="authentication-bg">
<div class="my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <div>
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <div class="error-img">
                                    <img class="img-fluid mx-auto d-block"
                                         src="{{asset("resources/images/access-denied.png")}}" alt=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-uppercase mt-4">Sorry, you're not authorized to access this page</h4>
                    <p class="text-muted">Please back to dashboard to your safety</p>
                    <div class="mt-5">
                        <a class="btn btn-primary waves-effect waves-light" href="{{config("app.url")}}/">Back to
                            Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("global.foot")
