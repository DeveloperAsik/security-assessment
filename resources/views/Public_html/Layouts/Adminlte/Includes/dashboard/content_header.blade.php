<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if(isset($_breadcrumbs) && !empty($_breadcrumbs))
                        @foreach($_breadcrumbs AS $key => $value)
                            @php $act = ''; @endphp
                            @if($value['id'] == 1)
                                @php $act = ' active'; @endphp
                            @endif
                            <li class="breadcrumb-item{{$act}}"><a href="{{$value['path']}}">{{$value['title']}}</a></li>
                        @endforeach
                    @endif
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>