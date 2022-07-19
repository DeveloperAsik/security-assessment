<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <title>AdminLTE 3 | Top Navigation</title>
        <link rel="icon" type="image/x-icon" href="{{config('app.base_static_uri')}}images/logo-developer-asik-orange-full.png">
        @include('Public_html.Layouts.Adminlte.Includes.register.include_meta')
        @include('Public_html.Layouts.Adminlte.Includes.register.include_css')
    </head>
    <body class="hold-transition layout-top-nav">
        <div class="wrapper">

            <!-- Navbar -->
            @include('Public_html.Layouts.Adminlte.Includes.register.navbar')
            <!-- /.navbar -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @include('Public_html.Layouts.Adminlte.Includes.register.content_header')
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container">
                        @include('Public_html.Components.content')
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Main Footer -->
            @include('Public_html.Layouts.Adminlte.Includes.register.footer')
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED SCRIPTS -->
        @include('Public_html.Layouts.Adminlte.Includes.register.include_js')
    </body>
</html>
