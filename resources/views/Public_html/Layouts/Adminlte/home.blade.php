<!doctype html>
<html lang="en">
    <head>
        <title>{{$title_for_layout ? $title_for_layout : config('app.title_for_layout')}}</title>
        <link rel="icon" type="image/x-icon" href="{{config('app.base_assets_uri')}}/favicon.png">
        @include('Public_html.Layouts.Adminlte.Includes.home.include_meta')
        @include('Public_html.Layouts.Adminlte.Includes.home.include_css')
    </head>
    <body>
        <div id="img-loading" style="position: fixed; top:40%; left:45%; width:120px; z-index:9999"></div>
        <main>
            @include('Public_html.Components.content')
        </main>
        @include('Public_html.Components.modal')
        @include('Public_html.Layouts.Adminlte.Includes.home.include_js')
    </body>
</html>
