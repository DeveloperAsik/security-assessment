<script>

    var ProfileJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('ProfileJS successfully load', 'success', {timeOut: 2000});
            }
        };
    }();
    jQuery(document).ready(function () {
        ProfileJS.init();
    });
    window.onscroll = function (ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
            if ($('#logs').length > 0 && $('#logs').prop('class') == 'tab-pane active') {
                loadingImg('img-loading', 'start');
                // you're at the bottom of the page
                var offset = $('#paging_options').attr('data-offset');
                var new_offset = parseInt(offset) + 1;
                var limit = $('#paging_options').attr('data-limit');
                var uri = _base_extraweb_uri + '/ajax/get/get-logs?limit=' + parseInt(limit) + '&offset=' + new_offset;
                var type = 'GET';
                var response = fnAjaxSend({}, uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                //console.log(response);
                //return false;
                if (response.responseJSON.status.code === 200) {
                    if (response.responseJSON.data) {
                        var strHtml = '';
                        var data = response.responseJSON.data;
                        for (var i = 0; i < response.responseJSON.options.meta.total; i++) {
                            strHtml = strHtml + '<div class="time-label">';
                            strHtml = strHtml + '<span class="bg-danger">';
                            strHtml = strHtml + data[i].createdDate;
                            strHtml = strHtml + '</span>';
                            strHtml = strHtml + '</div>';
                            strHtml = strHtml + '<div><i class="fas fa-envelope bg-primary"></i><div class="timeline-item">';
                            strHtml = strHtml + '<span class="time"><i class="far fa-clock"></i>' + data[i].createdDateHour + '</span>';
                            strHtml = strHtml + '<h3 class="timeline-header">' + data[i].user_name + ' ('+ data[i].email +')'+ '</h3>';
                            strHtml = strHtml + '<div class="timeline-body">';
                            strHtml = strHtml + 'Accessing class : ' + data[i].class + '<br/>';
                            strHtml = strHtml + 'Class action : ' + data[i].method + '<br/>';
                            strHtml = strHtml + 'Type : ' + data[i].event + '<br/>';
                            strHtml = strHtml + '<code>' + data[i].fraud_scan + '</code>';
                            strHtml = strHtml + '</div>';
                            strHtml = strHtml + '</div></div>';
                        }
                        
                        $('#paging_options').attr('data-offset', response.responseJSON.options.meta.offset);
                        $('#paging_options').attr('data-limit', response.responseJSON.options.meta.limit);
                        setTimeout(function(){
                            loadingImg('img-loading', 'stop');
                            $('.timeline').append(strHtml);
                        }, 1500);
                    }
                }
            }
        }
    };
</script>