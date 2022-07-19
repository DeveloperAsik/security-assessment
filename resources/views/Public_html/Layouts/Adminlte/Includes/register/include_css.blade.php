<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/toastr/toastr.min.css">

@if(isset($load_css) && !empty($load_css))
    @foreach ($load_css AS $key => $values)
        <link href="{{$_config_lib_url . $values}}" rel="stylesheet" type="text/css"/>
    @endforeach
@endif