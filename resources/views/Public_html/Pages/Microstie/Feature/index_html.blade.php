<style>
    #wrapper{
        margin:0px auto;
        text-align:center;
    }
</style>
<div id="wrapper">
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if(isset($listGames) && !empty($listGames))
                @foreach($listGames AS $key => $value)
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info" style="min-height: 130px;">
                        <div class="inner">
                            <p>{{$value['title']}}</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>
                        <a href="{{$value['link']}}" target="_blank" class="small-box-footer">Click To open</a>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
