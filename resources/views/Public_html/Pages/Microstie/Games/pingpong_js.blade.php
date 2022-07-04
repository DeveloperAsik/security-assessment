<script>
    var gameInitpingpong = function () {
        //Atur Variabel Yang Akan Digunakan
        var animate = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (callback) {
            window.setTimeout(callback, 1000 / 60);
        };
        var canvas = document.getElementById("canvas-pingpong");
        var width = 400;
        var height = 600;
        canvas.width = width;
        canvas.height = height;
        var context = canvas.getContext('2d');
        var player = new Player();
        var computer = new Computer();
        var ball = new Ball(200, 300);
//Atur Data Array Untuk Key (Tombol) Yang Nantinya Ditekan oleh Pemain 
        var keysDown = {};
//Atur Rendering Permainan
        var render = function () {
            context.fillStyle = "#16a05d";
            context.fillRect(0, 0, width, height);
            player.render();
            computer.render();
            ball.render();
        };
//Atur Perubahan Pemain, Komputer, dan Bola
        var update = function () {
            player.update();
            computer.update(ball);
            ball.update(player.paddle, computer.paddle);
        };
//Atur Animasi Pergerakan Pemain dan Komputer
        var step = function () {
            update();
            render();
            animate(step);
        };
//Atur Obyek Paddle Pemain dan Komputer
        function Paddle(x, y, width, height) {
            this.x = x;
            this.y = y;
            this.width = width;
            this.height = height;
            this.x_speed = 0;
            this.y_speed = 0;
        }
//Atur Rendering dari Paddle
        Paddle.prototype.render = function () {
            context.fillStyle = "#FFFFFF";
            context.fillRect(this.x, this.y, this.width, this.height);
        };
//Atur Pergerakan dari Paddle
        Paddle.prototype.move = function (x, y) {
            this.x += x;
            this.y += y;
            this.x_speed = x;
            this.y_speed = y;
            if (this.x < 0) {
                this.x = 0;
                this.x_speed = 0;
            } else if (this.x + this.width > 400) {
                this.x = 400 - this.width;
                this.x_speed = 0;
            }
        };
//Atur Fungsi dari Komputer
        function Computer() {
            this.paddle = new Paddle(175, 10, 50, 10);
        }
//Atur Rendering dari Komputer
        Computer.prototype.render = function () {
            this.paddle.render();
        };
//Atur Perubahan dari Komputer
        Computer.prototype.update = function (ball) {
            var x_pos = ball.x;
            var diff = -((this.paddle.x + (this.paddle.width / 2)) - x_pos);
            if (diff < 0 && diff < -4) {
                diff = -5;
            } else if (diff > 0 && diff > 4) {
                diff = 5;
            }
            this.paddle.move(diff, 0);
            if (this.paddle.x < 0) {
                this.paddle.x = 0;
            } else if (this.paddle.x + this.paddle.width > 400) {
                this.paddle.x = 400 - this.paddle.width;
            }
        };
//Atur Fungsi dari Komputer
        function Player() {
            this.paddle = new Paddle(175, 580, 50, 10);
        }
//Atur Rendering dari Pemain
        Player.prototype.render = function () {
            this.paddle.render();
        };
//Atur Perubahan dari Pemain
        Player.prototype.update = function () {
            for (var key in keysDown) {
                var value = Number(key);
                if (value == 37) {
                    this.paddle.move(-4, 0);
                } else if (value == 39) {
                    this.paddle.move(4, 0);
                } else {
                    this.paddle.move(0, 0);
                }
            }
        };
//Atur Fungsi dari Bola
        function Ball(x, y) {
            this.x = x;
            this.y = y;
            this.x_speed = 0;
            this.y_speed = 3;
        }
//Atur Rendering dari Bola
        Ball.prototype.render = function () {
            context.beginPath();
            context.arc(this.x, this.y, 5, 2 * Math.PI, false);
            context.fillStyle = "#FFFFFF";
            context.fill();
        };
//Atur Perubahan dari Bola
        Ball.prototype.update = function (paddle1, paddle2) {
            this.x += this.x_speed;
            this.y += this.y_speed;
            var top_x = this.x - 5;
            var top_y = this.y - 5;
            var bottom_x = this.x + 5;
            var bottom_y = this.y + 5;

            if (this.x - 5 < 0) {
                this.x = 5;
                this.x_speed = -this.x_speed;
            } else if (this.x + 5 > 400) {
                this.x = 395;
                this.x_speed = -this.x_speed;
            }
            if (this.y < 0 || this.y > 600) {
                this.x_speed = 0;
                this.y_speed = 3;
                this.x = 200;
                this.y = 300;
            }
            if (top_y > 300) {
                if (top_y < (paddle1.y + paddle1.height) && bottom_y > paddle1.y && top_x < (paddle1.x + paddle1.width) && bottom_x > paddle1.x) {
                    this.y_speed = -3;
                    this.x_speed += (paddle1.x_speed / 2);
                    this.y += this.y_speed;
                }
            } else {
                if (top_y < (paddle2.y + paddle2.height) && bottom_y > paddle2.y && top_x < (paddle2.x + paddle2.width) && bottom_x > paddle2.x) {
                    this.y_speed = 3;
                    this.x_speed += (paddle2.x_speed / 2);
                    this.y += this.y_speed;
                }
            }
        };
        $('#cnvsResult').html(canvas);
        //document.getElementById("wrapper").appendChild(canvas);
        //document.body.appendChild(canvas);
        animate(step);
        window.addEventListener("keydown", function (event) {
            keysDown[event.keyCode] = true;
        });
        window.addEventListener("keyup", function (event) {
            delete keysDown[event.keyCode];
        });
    };
    var pingpongJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                gameInitpingpong();
            }
        };
    }();
    jQuery(document).ready(function () {
        pingpongJS.init();
    });
</script>