<?php

namespace App\Http\Controllers\Api;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\TokenUser;

/**
 * Description of AuthController
 *
 * @author I00396.ARIF
 */
class AuthController extends Controller {

    //put your code here

    public function get_token(Request $request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $user = DB::table('tbl_a_users AS a')->select('a.id', 'a.user_name', 'a.email', 'a.password')->where('a.email', 'like', '%' . $data['email'] . '%')->first();
            if (isset($user) && !empty($user)) {
                $verify_hash = TokenUser::__verify_hash($data['password'], $user->password);
                if ($verify_hash == true) {
                    $code = 200;
                    $msg = 'Successfully generate token user';
                    $valid = true;
                    $generate_token = TokenUser::__generate_token($request, $user);
                } else {
                    $code = 200;
                    $msg = 'Failed generate token user';
                    $valid = false;
                    $generate_token = null;
                }
                return MyHelper::_set_response('json', ['code' => $code, 'message' => $msg, 'valid' => $valid, 'meta' => [], 'data' => ['token' => $generate_token]]);
            }
        }
    }

}
