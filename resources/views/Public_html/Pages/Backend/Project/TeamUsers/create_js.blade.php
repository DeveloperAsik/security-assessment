<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/dropzone/dropzone.min.js"></script>
<script>
var EditJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
			
			$("div#my-dropzone").dropzone({
				url	:  _base_extraweb_uri + '/project/team/user/insert/' + team_id,
				headers: {
					'x-csrf-token': "{{ csrf_token() }}",
				}
			});
            $('.permissions_multiselect').bootstrapDualListbox();
            $('input[name="check"][value="is_generate"').on('click', function (e) {
                var checked = this.checked;
                if (checked) {
                    $('.group_list').css({'display': 'flex'});
                } else {
                    $('.group_list').css({'display': 'none'});
                }
            });
            $('#submit_form_add').on('click', function (e) {
                e.preventDefault();
                var uri = _base_extraweb_uri + '/project/team/user/insert/' + team_id;
                var type = 'POST';
                var formdata = {
                    photo: $('input[name="photo"]').val(),
                    code: $('input[name="code"]').val(),
                    user_name: $('input[name="user_name"]').val(),
                    first_name: $('input[name="first_name"]').val(),
                    last_name: $('input[name="last_name"]').val(),
                    email_address: $('input[name="email_address"]').val(),
                    phone_number: $('input[name="phone_number"]').val(),
                    description: $('textarea[name="description"]').val(),
                    is_active: $('input[type="checkbox"][name="check"][value="is_active"]')[0].checked,
                    is_generate: $('input[type="checkbox"][name="check"][value="is_generate"]')[0].checked
                };
                if (formdata.is_generate) {
                    var generate_user = {
                        groups: $('select[name="group_id"]').val(),
                        permissions: $('select[name="permission_id"]').val(),
                    };
                    formdata = Object.assign(formdata, generate_user);
                }
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, true);
                if (response.responseJSON.status.code === 200) {
                    setTimeout(function () {
                        loadingImg('img-loading', 'stop');
                        fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000, withHtml: true});
                    }, 1500);
                } else {
                    setTimeout(function () {
                        loadingImg('img-loading', 'stop');
                        fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000, withHtml: true});
                    }, 1500);
                }
                return false;
            });
        }
    };
}();

Dropzone.autoDiscover = false;
jQuery(document).ready(function () {
    EditJS.init();
});
</script>
