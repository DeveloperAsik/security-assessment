<!DOCTYPE html>
<html>
    <head>
        <title>{{$title_for_layout ? $title_for_layout : config('app.title_for_layout')}}</title>
        <link rel="icon" type="image/x-icon" href="{{config('app.base_static_uri')}}images/logo-developer-asik-orange-full.png">
        @include('Public_html.Layouts.Adminlte.Includes.dashboard.include_meta')
        @include('Public_html.Layouts.Adminlte.Includes.dashboard.include_css')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div id="img-loading" style="position: fixed; top:40%; left:45%; width:120px; z-index:9999"></div>
        <div class="wrapper">
            <!-- Navbar -->
            @include('Public_html.Layouts.Adminlte.Includes.dashboard.navbar')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            @include('Public_html.Layouts.Adminlte.Includes.dashboard.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @include('Public_html.Layouts.Adminlte.Includes.dashboard.content_header')
                <!-- /.content-header -->
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @include('Public_html.Components.content')
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            @include('Public_html.Layouts.Adminlte.Includes.dashboard.footer')
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        @include('Public_html.Components.modal')
        <!-- ./wrapper -->
        @include('Public_html.Layouts.Adminlte.Includes.dashboard.include_js')
    </body>
</html>
