<script>
    var gameInitSnake = function () {
        //Atur Konstanta / Ketetapan Awal Pada Permainan 
        px = py = 10;
        gs = tc = 20; //size game snake
        ax = ay = 15;
        xv = yv = 0;
        trail = [];
        tail = 5;

        //Atur Mekanisme Inputan-nya berdasarkan keyCode-nya

    };
    var game = function () {
        //Atur Batasan (Boundary) Pada Halaman Permainan
        px += xv;
        py += yv;
        if (px < 0) {
            px = tc - 1;
        }
        if (px > tc - 1) {
            px = 0;
        }
        if (py < 0) {
            py = tc - 1;
        }
        if (py > tc - 1) {
            py = 0;
        }

        //Atur Warna Pada Halaman Permainan
        ctx.fillStyle = "black";
        ctx.fillRect(0, 0, canv.width, canv.height);
        //Atur Warna Pada Snake
        ctx.fillStyle = "red";
        for (var i = 0; i < trail.length; i++) {
            ctx.fillRect(trail[i].x * gs, trail[i].y * gs, gs - 2, gs - 2);
            if (trail[i].x == px && trail[i].y == py) {
                tail = 5;
            }
        }

        //Atur Panjang Pada Ekor Snake-nya
        trail.push({x: px, y: py});
        while (trail.length > tail) {
            trail.shift();
        }
        //Jika Snake Memakan Food-nya, Acak Lokasi Food-nya
        if (ax == px && ay == py) {
            tail++;
            ax = Math.floor(Math.random() * tc);
            ay = Math.floor(Math.random() * tc);
        }

        //Atur Warna Pada Food-nya
        ctx.fillStyle = "purple";
        ctx.fillRect(ax * gs, ay * gs, gs - 2, gs - 2);
    };
    var keyPush = function (evt) {
        switch (evt.keyCode) {
            //Input Panah Kiri
            case 37:
                xv = -1;
                yv = 0;
                break;
                //Input Panah Atas
            case 38:
                xv = 0;
                yv = -1;
                break;
                //Input Panah Kanan
            case 39:
                xv = 1;
                yv = 0;
                break;
                //Input Panah Bawah
            case 40:
                xv = 0;
                yv = 1;
                break;
        }
    };

    var gamePlay = function () {
        //Cari elemen dengan nama ID yang telah di tentukan
        canv = document.getElementById("canvas-snake");
        //Konteks Kanvas / Halaman Permainan
        ctx = canv.getContext("2d");
        //Pastikan bahwa program / web menerima input keyboard
        document.addEventListener("keydown", keyPush);
        //Atur jeda / interval pada permainan
        var speedGame = $("#customRange1").val();
        if (!speedGame) {
            speedGame = 2;
        }
        $('#actualGameSpeed').html(speedGame);
        setInterval(game, 1000 / speedGame);
    };
    var pingpongJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                gameInitSnake();
                $('#customRange1').on('change', function () {
                    var speedGame = $(this).val();
                    $("#customRange1").val(speedGame);
                    gamePlay();
                });
            }
        };
    }();
    jQuery(document).ready(function () {
        pingpongJS.init();
    });
    window.onload = function () {
        gamePlay();
    };
</script>