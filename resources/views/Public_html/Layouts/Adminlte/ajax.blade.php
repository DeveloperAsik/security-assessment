<html>
    <head>
        <title>{{$title_for_layout ? $title_for_layout : config('app.title_for_layout')}}</title>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    </head>
    <body>
        @include('Public_html.Layouts.Adminlte.Includes.index.message_box')
        @include('Public_html.Components.content')
    </body>
</html>
