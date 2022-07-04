<!-- JQVMap -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
<!-- ChartJS -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/dist/js/pages/dashboard.js"></script>
<script>
    var DashboardJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('DashboardJS successfully load', 'success', {timeOut: 2000});
            }
        };
    }();
    jQuery(document).ready(function () {
        DashboardJS.init();
    });
</script>
