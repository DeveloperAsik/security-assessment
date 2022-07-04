<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;
use Closure;
use App\Models\Tables\Core\Tbl_a_permissions;
use App\Models\Tables\Core\Tbl_a_group_auth;
use App\Models\Tables\Core\Tbl_a_modules;

class Authenticate {

    protected $Tbl_a_permissions;
    protected $Tbl_a_group_auth;
    protected $Tbl_a_modules;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function __construct(Tbl_a_permissions $Tbl_a_permissions, Tbl_a_group_auth $Tbl_a_group_auth, Tbl_a_modules $Tbl_a_modules) {
        $this->Tbl_a_permissions = $Tbl_a_permissions;
        $this->Tbl_a_group_auth = $Tbl_a_group_auth;
        $this->Tbl_a_modules = $Tbl_a_modules;
    }

    protected function redirectTo($request) {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle(Request $request, Closure $next) {
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $param_cookies = [
            'name' => 'is_first_load',
            'value' => true,
            'minutes' => 86400,
            'path' => url()->full()
        ];
        MyHelper::setCookieNew($request, $param_cookies);
        $curr_cookie = MyHelper::getCookieNew($request, $param_cookies);
        $authAccessServices = $this->initServices($request, $currentPath);
        if ($authAccessServices && $authAccessServices['is_valid'] == true) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                $response_data = array('status' => 401, 'message' => 'This url need login session to accessed');
                return response()->json($response_data, 401);
            } else {
                if ($currentPath != 'extraweb/login') {
                    session(['_session_destination_path' => '/' . $currentPath]);
                    session()->save();
                }
                return redirect('/extraweb/login')->with(['warning-msg' => 'This page need login session, please login first!']);
            }
        }
    }

    protected function initServices($request, $currentPath) {
        //get permission by url request from routes
        $currentPermission = $this->Tbl_a_permissions->getCurrentPermission($request, $currentPath);
        if ($currentPermission == null) {
            $response = false;
            $url = '/extraweb/login';
        } else {
            //get group and group permissions
            $data = $request->session()->all();
            if (!isset($data['_session_is_logged_in']) || empty($data['_session_is_logged_in']) || $data['_session_is_logged_in'] == false) {
                $group_id = 0;
                $response = false;
                $url = '/extraweb/login';
                if ($currentPath == 'extraweb/login' || $currentPath == 'extraweb/logout' || $currentPath == 'extraweb/validate-user' || $currentPath == 'extraweb/save-token') {
                    $response = true;
                    $url = '/extraweb/login';
                }
            } else {
                $group_id = $data['_session_group_id'];
                $getGroupUser = $this->Tbl_a_group_auth->getCurrentGroup($request, $currentPermission, $group_id);
                //get module detail
                $getModule = $this->Tbl_a_modules->get_data_by_id($currentPermission->module_id);
                $param = [
                    'Permission' => $currentPermission,
                    'GroupUser' => $getGroupUser,
                    'Module' => $getModule
                ];
                switch ($currentPermission->module_id) {
                    case 1:
                        $response = false;
                        break;
                    case 2:
                        $response = true;
                        $url = '/extraweb/login';
                        $data = session()->all();
                        if ($param['GroupUser']->is_public != 1) {
                            $response = false;
                            //check if session is present
                            if (isset($data['_session_is_logged_in']) && !empty($data['_session_is_logged_in']) && $data['_session_is_logged_in'] == true) {
                                $response = true;
                            } else {
                                $response = false;
                                if (isset($data['_session_destination_path']) && !empty($data['_session_destination_path'])) {
                                    $url = $data['_session_destination_path'];
                                }
                            }
                        }
                        break;
                }
            }
        }
        $resp = [
            'code' => 200,
            'is_valid' => $response,
            'url' => $url
        ];
        return $resp;
    }

    public static function login_attempt_calc($data) {
        $attempt_total = 3;
        $session = session()->all();
        $attemps = DB::table('tbl_d_login_attempts AS a')
                ->where('a.email', 'like', '%' . $data['userid'] . '%')
                ->where('a.device_id', 'like', '%' . $session['_uuid'] . '%')
                ->orderBy('a.id', 'desc')
                ->get();
        $date = [];
        if (isset($attemps) && !empty($attemps)) {
            foreach ($attemps AS $key => $value) {
                $date[] = $value->created_date;
            }
        }
        $response = true;
        $messages = '';
        if (isset($attemps) && !empty($attemps) && count($attemps) >= $attempt_total) {
            if ($date) {
                $time_diff = MyHelper::fnDateDiff($date[0], MyHelper::getDateNow(), true);
                if (count($date) > $attempt_total && isset($time_diff) && $time_diff['i'] == 0 && $time_diff['s'] < 60) {
                    $response = false;
                    $messages = 'your ip is in blocked session because had maximum attempts to login, please wait for 60 seconds to cleared your blocked access.';
                } elseif (count($date) > ($attempt_total + 2) && isset($time_diff) && $time_diff['i'] <= 3) {
                    $response = false;
                    $messages = 'your ip is in blocked session because had maximum attempts to login, please wait for 3 minutes to cleared your blocked access.';
                }
            } else {
                $messages = 'you already 3 times attempts to login using this email and password, please wait 60 second for you ip is cleared to attempt to login.';
            }
        } else {
            $messages = 'Cannot found your email address or password in database system. <br/><small>You had <b>' . ((int) $attempt_total - 1) - count($attemps) . '</b> times left attempt for login to system.</small>';
        }
        return array('status' => $response, 'message' => $messages);
    }

    public static function validate_user($request) {
        if (isset($request) && !empty($request)) {
            $user = DB::table('tbl_a_users AS a')
                    ->select('a.id', 'a.user_name', 'a.email', 'a.password','c.id AS group_id','c.title AS group_name')
                    ->leftJoin('tbl_a_user_groups AS b', 'b.user_id', '=', 'a.id')
                    ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'b.group_id')
                    ->where('a.email', 'like', '%' . $request['userid'] . '%')
                    ->first();
            if (isset($user) && !empty($user)) {
                $verify_hash = TokenUser::__verify_hash(base64_decode($request['password']), $user->password);
                $attemps = Authenticate::login_attempt_calc($request);
                if (!$attemps || $attemps['status'] = false) {
                    $code = 500;
                    $msg = $attemps['message']; //'Failed generate token user, you already attempts 3 times to login. Please re-login after 60 seconds';
                    $valid = false;
                    $generate_token = null;
                } else {
                    if ($verify_hash == true) {
                        $code = 200;
                        $msg = 'Successfully generate token user';
                        $valid = true;
                        $generate_token = TokenUser::__generate_token($request, $user);
                    } else {
                        $code = 500;
                        $msg = 'Failed generate token user, user email or password didnt match with database record. ' . $attemps['message'];
                        $valid = false;
                        $generate_token = null;

                        $param = [
                            'email' => $request['userid'],
                            'password_attempt' => base64_decode($request['password']),
                            'device_id' => $request['deviceid'],
                            'ip' => MyHelper::getIp(),
                            'browser' => json_encode(MyHelper::getBrowser()),
                            'is_active' => 1,
                            'created_by' => 1,
                            'created_date' => MyHelper::getDateNow(),
                            'updated_by' => 1,
                            'updated_date' => MyHelper::getDateNow()
                        ];
                        DB::table('tbl_d_login_attempts')->insert($param);
                    }
                }
                return MyHelper::_set_response('json', ['code' => $code, 'message' => $msg, 'valid' => $valid, 'meta' => [], 'data' => ['token' => $generate_token]]);
            }
        }
    }

    public static function save_token($request) {
        if (isset($request) && !empty($request)) {
            $token = $request['token']['token'];
            //$token_refresh = $request['token']['token_refresh'];
            $decode_jwt = MyHelper::decode_jwt($token);
            //session()->put();
            session(['_session_token' => $token]);
            //session(['_session_token_refreshed' => $token_refresh]);
            session(['_session_user_id' => $decode_jwt->user_id]);
            session(['_session_group_id' => $decode_jwt->group_id]);
            session(['_session_user_name' => $decode_jwt->user_name]);
            session(['_session_user_email' => $decode_jwt->user_email]);
            session(['_session_is_logged_in' => true]);
            session(['_session_expiry_date' => date('Y-m-d H:i:s', strtotime('+24 Hours'))]);
            session()->save();
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully save token.', 'valid' => true]);
        }
    }

    public static function clear_session() {
        session()->forget('_session_token');
        session()->forget('_session_token_refreshed');
        session()->forget('_session_user_id');
        session()->forget('_session_group_id');
        session()->forget('_session_is_logged_in');
        session()->forget('_session_expiry_date');
        session()->forget('_session_user_name');
        session()->forget('_session_user_email');
        session()->forget('alert-msg');
        session()->flush();
        session()->save();
    }

}
