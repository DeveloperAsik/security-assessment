<!-- Font Awesome -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/summernote/summernote-bs4.css">
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