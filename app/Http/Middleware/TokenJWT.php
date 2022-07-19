<?php

namespace App\Http\Middleware;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;

/**
 * Description of TokenJWT
 *
 * @author elitebook
 */
class TokenJWT {

    //put your code here
    public static function __generate_token($request, $data) {
        if (isset($data) && !empty($data)) {
            $group = DB::table('tbl_user_b_user_groups AS a')->where('a.user_id', '=', $data->id)->first();
            $token_exist = DB::table('tbl_user_c_tokens AS a')->select('a.id', 'a.token', 'a.expiry_date', 'a.created_date')->where('a.created_by', '=', $data->id)->first();
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = [
                'user_id' => $data->id,
                'group_id' => $group->group_id,
                'user_name' => $data->user_name,
                'user_email' => $data->email,
                'create_date' => strtotime(date('Y-m-d H:i:s')),
                'expired_date' => strtotime(date('Y-m-d H:i:s', strtotime('+24 Hours')))
            ];
            $token = MyHelper::generate_jwt($headers, $payload);
            $token_refresh = MyHelper::generate_jwt($headers, array_merge(['is_refresh' => true], $payload));
            if ($token_exist && $token_exist != null && strtotime($token_exist->expiry_date) > strtotime($token_exist->created_date)) {
                //expired
                $response = DB::table('tbl_user_c_tokens')->where('id', $token_exist->id)->update([
                    'token' => $token,
                    'token_refreshed' => $token_refresh,
                    'expiry_date' => date('Y-m-d H:i:s', strtotime('+24 Hours')),
                    'is_logged_in' => 1,
                    'is_expiry' => 0,
                    'is_active' => 1,
                    'group_id' => $group->group_id,
                    'created_by' => $data->id,
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $data->id,
                    'updated_date' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $response = DB::table('tbl_user_c_tokens')->insert([
                    'token' => $token,
                    'token_refreshed' => $token_refresh,
                    'expiry_date' => date('Y-m-d H:i:s', strtotime('+24 Hours')),
                    'is_active' => 1,
                    'is_logged_in' => 1,
                    'group_id' => $group->group_id,
                    'created_by' => $data->id,
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $data->id,
                    'updated_date' => date('Y-m-d H:i:s'),
                ]);
            }
            if ($response) {
                return ['token' => $token, 'token_refresh' => $token_refresh];
            } else {
                return null;
            }
        }
    }

    public static function __verify_token($token_jwt = null) {
        if ($token_jwt != null) {
            return MyHelper::is_jwt_valid($token_jwt);
        }
    }

    public static function __string_hash($password_raw) {
        if (isset($password_raw) && !empty($password_raw)) {
            $salt = config('app.salt');
            $password_peppered = hash_hmac("sha256", $password_raw, $salt);
            return password_hash($password_peppered, PASSWORD_ARGON2ID);
        } else {
            return null;
        }
    }

    public static function __verify_hash($password_raw, $password_hashed) {
        if (isset($password_raw) && !empty($password_raw)) {
            $salt = config('app.salt');
            $password_peppered = hash_hmac("sha256", $password_raw, $salt);
            if (password_verify($password_peppered, $password_hashed)) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

}
