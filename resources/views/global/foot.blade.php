<script src="{{asset("resources/js/library/jquery/jquery.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/angular/angular.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/angular/angular-sanitize.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/apexcharts/apexcharts.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/datatables/datatables-jquery.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-bootstrap.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-buttons.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-buttons-bootstrap.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-buttons-colvis.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-buttons-html5.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-buttons-print.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-responsive.min.js?v=" . config("app.version"))}}"></script>
<script
    src="{{asset("resources/js/library/datatables/datatables-responsive-bootstrap.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/flatpickr/flatpickr.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/jquery/jquery-waypoints.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/jquery/jquery-counterup.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/metismenu/metis-menu.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/select2/select2.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/simplebar/simplebar.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/sweetalert2/sweetalert2.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/waves/waves.min.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/library/template/app.js?v=" . config("app.version"))}}"></script>
<script src="{{asset("resources/js/global.js?v=" . config("app.version"))}}"></script>
@foreach($layout->js as $js)
    <script src="{{asset("resources/js") . "/" . $js . "?v=" . config("app.version")}}"></script>
    @endforeach
    </body>
    </html>
