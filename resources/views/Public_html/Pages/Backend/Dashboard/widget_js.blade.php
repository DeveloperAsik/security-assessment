<script>
    var WidgetJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('WidgetJS successfully load', 'success', {timeOut: 2000});
            }
        };
    }();
    jQuery(document).ready(function () {
        WidgetJS.init();
    });
</script>
