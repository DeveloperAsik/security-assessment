<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;

/**
 * Description of TokenUser
 *
 * @author I00396.ARIF
 */
class TokenUser {

    //put your code here

    public static function __generate_token($request, $data) {
        if (isset($data) && !empty($data)) {
            $group = DB::table('tbl_a_group_auth AS a')->where('a.group_id', '=', $data->id)->first();
            $token_exist = DB::table('tbl_a_user_tokens AS a')->select('a.id', 'a.token', 'a.expiry', 'a.created_date')->where('a.created_by', '=', $data->id)->first();
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
            //$token_refresh = MyHelper::generate_jwt($headers, array_merge(['is_refresh' => true], $payload));
            if ($token_exist && $token_exist != null && strtotime($token_exist->expiry) > strtotime($token_exist->created_date)) {
                //expired
                $response = DB::table('tbl_a_user_tokens')->where('id', $token_exist->id)->update([
                    'token' => $token,
                    'expiry' => date('Y-m-d H:i:s', strtotime('+24 Hours')),
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
                $response = DB::table('tbl_a_user_tokens')->insert([
                    'token' => $token,
                    'expiry' => date('Y-m-d H:i:s', strtotime('+24 Hours')),
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
                return ['token' => $token];
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
