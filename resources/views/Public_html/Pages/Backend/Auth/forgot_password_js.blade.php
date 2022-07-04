<script>
    var ForgotPasswordJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('ForgotPasswordJS successfully load', 'success', {timeOut: 2000});
            }
        };
    }();
    jQuery(document).ready(function () {
        ForgotPasswordJS.init();
    });
</script>
