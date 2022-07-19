<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{config('app.url')}}" class="h2"><b>Projects </b>Assessment</a>
        </div>
        <div class="card-body">
            <p>Sign in to start your session</p>
            <form name="login_auth" method="post" class="login-form">
                <div class="input-group mb-3">
                    <input type="email" name="userid" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text" id="userid_info_msg">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mb-1">
                <a href="{{config('app.base_extraweb_uri')}}/forgot-password">I forgot my password</a><br/>
                <code class="login-box-msg"></code>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div> 