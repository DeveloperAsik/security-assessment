<style>
    #wrapper{
        margin: 0px auto;
        text-align: center;
        position: absolute;
        margin: 2% 0 0 35%;
        display: flex;
        justify-content: center;
    }
</style>
<div id="wrapper">
    <div class="col-12 d-flex align-items-stretch">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                Snake
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <canvas id="canvas-snake" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <div class="btn btn-sm bg-teal">
                        <input type="range" class="custom-range" id="customRange1" min="1" max="10" >
                    </div>
                    <div class="btn btn-sm btn-primary">
                        Current Speed <span id="actualGameSpeed"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>