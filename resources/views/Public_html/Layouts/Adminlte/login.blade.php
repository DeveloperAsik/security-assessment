<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{$title_for_layout ? $title_for_layout : config('app.title_for_layout')}}</title>
        <link rel="icon" type="image/x-icon" href="{{config('app.base_static_uri')}}images/logo-developer-asik-orange-full.png">
        @include('Public_html.Layouts.Adminlte.Includes.dashboard.include_meta')
        @include('Public_html.Layouts.Adminlte.Includes.login.include_css')
    </head>
    <body class="hold-transition login-page">
        <div id="img-loading" style="position: fixed; top:40%; left:45%; width:120px; z-index:9999"></div>
        @include('Public_html.Layouts.Adminlte.Includes.dashboard.message_box')
        @include('Public_html.Components.content')
        <!-- /.login-box -->
        @include('Public_html.Layouts.Adminlte.Includes.login.include_js')
    </body>
</html>
