<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MyHelper {

    public static function format_money($number) {
        $result = "Rp " . number_format($number, 2, ',', '.');
        return $result;
    }

    public static function slug($string = null) {
        if ($string != null) {
            $string_1 = trim($string);
            $string_2 = strtolower($string_1);
            $string_3 = str_replace(' ', '-', $string_2);
            $string_4 = str_replace('--', '-', $string_3);
            $string_5 = str_replace('_', '-', $string_4);
            $string_6 = str_replace('__', '-', $string_5);
            $string_7 = str_replace('/', '-', $string_6);
            return $string_7;
        }
    }

    public static function base64($string = null, $type = true) {
        if ($string != null) {
            switch ($type) {
                case true:
                    $response = base64_encode(strtolower($string));
                    break;
                case false:
                    $response = base64_decode(strtolower($string));
                    break;
            }
            return $response;
        }
    }

    public static function array_to_object($params = array()) {
        return json_decode(json_encode($params), FALSE);
    }

    public static function setCookie($params = []) {
        if ($params) {
            $minutes = time() + (86400 * 30);
            if (isset($params['minutes']) && !empty($params['minutes'])) {
                $minutes = $params['minutes'];
            }
            //if (!isset($_COOKIE[$params['name']]) || $_COOKIE[$params['name']] == '') {
            setcookie($params['name'], $params['value'], $minutes, "/"); // 86400 = 1 day
            //}
            return true;
        }
    }

    public static function setCookieNew($request, $params = []) {
        $minutes = 60;
        $response = new Response('Set Cookie');
        $response->withCookie(cookie($params['name'], $params['value'], $minutes, $params['path']));
        return $response;
    }

    public static function getCookie($params = []) {
        if (isset($_COOKIE[$params['name']])) {
            return $_COOKIE[$params['name']];
        } else {
            return null;
        }
    }

    public static function getCookieNew($request, $params = []) {
        return $request->cookie($params['name']);
    }

    public static function delCookie($params = []) {
        setcookie($params['name'], "", time() - 3600, "/");
    }

    public static function init() {
        return ([
            '_uuid' => MyHelper::__get_uuid(),
            '_app_version' => env('APP_VERSION'),
            '_app_platform' => env('APP_PLATFORM'),
            '_salt' => App\Http\Middleware\OrenoHelpers::getRandomChar(32)
        ]);
    }

    protected static function __set_uuid() {
        $uuid5 = App\Http\Middleware\Sanitize::url_clean(Uuid::uuid5(Uuid::NAMESPACE_DNS, 'widget/1234567890'));
        return $uuid5;
    }

    protected static function __get_uuid(Request $request) {
        $uuid_session = $request->session()->get('_uuid');
        if (isset($uuid_session) && !empty($uuid_session) && $uuid_session != 'undefined') {
            return $uuid_session;
        } else {
            MyHelper::__set_uuid();
        }
    }

    public static function getStatusMobile() {
        $agent = new Agent();
        return $agent->isMobile();
    }

    public static function getStatusTablet() {
        $agent = new Agent();
        return $agent->isTablet();
    }

    public static function getUserAgent() {
        $agent = new Agent();
        return $agent;
    }

    public static function getDivideClassPath($path = null) {
        if ($path != null) {
            $res = explode('\\', $path);
            return $res[2]; //model name
        }
    }

    public static function redirect($path = null) {
        if ($path != null) {
            header("Location: " . $path);
        }
    }

    public static function getValidEmail($keyword = null) {
        if ($keyword != null) {
            if (filter_var($keyword, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function getRandomNumber($length = null) {
        $char = '0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($char) - 1);
            $string .= $char[$pos];
        }
        return $string;
    }

    public static function getRandomChar($length = null, $type = 'auto') {
        if ($type == 'auto') {
            $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
        } elseif ($type == 'l') {
            $char = 'abcdefghijklmnopqrstuvwxyz123456789';
        } elseif ($type == 'u') {
            $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        }
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($char) - 1);
            $string .= $char[$pos];
        }
        return $string;
    }

    public static function getHashPassword($password = null) {
        if ($password != null) {
            $options = array(
                'cost' => 12,
            );
            return password_hash($password, PASSWORD_BCRYPT, $options);
        }
    }

    public static function getUriSegment2($url, $return_array = false) {
        $str = str_replace(url('/'), '', $url);
        $str2 = explode('?', $str);
        $str3 = explode('/', $str2[0]);
        if ($return_array == true) {
            $res = array();
            if ($str3) {
                $res = array();
                foreach ($str3 AS $k => $v) {
                    if ($k != 0)
                        $res[] = $v;
                }
            }
        } else {
            $res = '';
            if ($str3) {
                $total = count($str3) - 1;
                foreach ($str3 AS $k => $v) {
                    if (!empty($res))
                        $res .= '.';
                    if ($k != 0)
                        if ($k == ($total)) {
                            $res .= ($v);
                        } else {
                            $res .= ucfirst($v);
                        }
                }
            }
        }
        return $res;
    }

    public static function getRoutes($key = null, $type = '') {
        if ($key != null && app('request')->route()->getAction() != null) {
            $routeArray = app('request')->route()->getAction();
            if ($type == 'namespace') {
                $val = explode('@', $routeArray['controller'])[0];
                $val = str_replace('App\Http\Controllers', '', $val);
                $val = str_replace('\\', '/', $val);
                $val = explode('/', $val);
                array_pop($val);
                return implode('.', $val);
            } else {
                if ($key == 'modul') {
                    $routeArray = explode('\\', $routeArray['controller']);
                    return $routeArray[3];
                } else {
                    $controllerAction = class_basename($routeArray['controller']);
                    list($controller, $action) = explode('@', $controllerAction);
                    return ${$key};
                }
            }
        }
    }

    public static function getBrowser($length = null) {
        $u_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";
        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        $ub = 'unknown';
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = isset($matches['version'][1]) ? $matches['version'][1] : '';
            }
        } else {
            $version = $matches['version'][0];
        }
        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public static function getIp() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR', 'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    public static function getDateNow() {
        return gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
    }

    public static function getDateAfter($hour, $date_start = null) {
        if ($date_start != null) {
            return gmdate('Y-m-d H:i:s', strtotime($date_start . '+' . $hour . 'hour'));
        } else {
            return gmdate('Y-m-d H:i:s', strtotime(Tools_Library::getDateNow() . '+' . $hour . 'hour'));
        }
    }

    public static function fnDateDiff($date_1, $date_2, $getSecond = false) {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        $times = array(
            'year' => $interval->y,
            'month' => $interval->m,
            'day' => $interval->d,
            'hour' => $interval->h,
            'minute' => $interval->i,
            'second' => $interval->s
        );
        if ($getSecond == true) {
            if ($interval->i > 0) {
                return array('i' => $interval->i, 's' => $interval->s);
            } else {
                return array('i' => $interval->s);
            }
        }
        $res = '';
        foreach ($times AS $key => $val) {
            if ($key == 'year' && $val > 0) {
                $res = $val . ' year';
            }

            if ($key == 'month' && $val <= 12 && $val > 0) {
                $res = $val . ' month';
            }

            if ($key == 'day' && $val < 31 && $val > 0) {
                $res = $val . ' day';
            }

            if ($key == 'hour' && $val < 24 && $val > 0) {
                $res = $val . ' hour';
            }
            if ($res == "") {

                if ($key == 'minute' && $val < 60 && $val > 0) {
                    $res = $val . ' min';
                }

                if ($key == 'second' && $val < 60 && $val > 0) {
                    $res = $val . ' sec';
                }
            }
        }
        return $res;
    }

    public static function idnDate($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
        if (trim($timestamp) == '') {
            $timestamp = time();
        } elseif (!ctype_digit($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace("/S/", "", $date_format);
        $pattern = array(
            '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
            '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
            '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
            '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
            '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
            '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
            '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
            '/November/', '/December/',
        );
        $replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
            'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember',
        );
        //gmdate('d F Y H:i:s', time() + 60 * 60 * 7);
        $date = gmdate($date_format, $timestamp + 60 * 60 * 7);
        $date = preg_replace($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }

    public static function monthName($lang = 'eng') {
        if ($lang == 'eng') {
            $month = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
        } elseif ($lang == 'ind') {
            $month = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');
        } else {
            $month = array();
        }
        return $month;
    }

    public static function drawCalendar($month, $year) {
        // Draw table for Calendar 
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
        // Draw Calendar table headings 
        $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';
        //days and weeks variable for now ... 
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();
        // row for week one 
        $calendar .= '<tr class="calendar-row">';
        // Display "blank" days until the first of the current week 
        for ($x = 0; $x < $running_day; $x++):
            $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
            $days_in_this_week++;
        endfor;
        // Show days.... 
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
            if ($list_day == date('d') && $month == date('n')) {
                $currentday = 'currentday';
            } else {
                $currentday = '';
            }
            $calendar .= '<td class="calendar-day ' . $currentday . '">';
            // Add in the day number
            if ($list_day < date('d') && $month == date('n')) {
                $showtoday = '<strong class="overday">' . $list_day . '</strong>';
            } else {
                $showtoday = $list_day;
            }
            $calendar .= '<div class="day-number">' . $showtoday . '</div>';
            // Draw table end
            $calendar .= '</td>';
            if ($running_day == 6):
                $calendar .= '</tr>';
                if (($day_counter + 1) != $days_in_month):
                    $calendar .= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        endfor;
        // Finish the rest of the days in the week
        if ($days_in_this_week < 8):
            for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
            endfor;
        endif;
        // Draw table final row
        $calendar .= '</tr>';
        // Draw table end the table 
        $calendar .= '</table>';
        // Finally all done, return result 
        return $calendar;
    }

    public static function getDetailDate($param = null) {
        if ($param != null) {
            $str = '';
            if (isset($param['day']) && $param['day'] != 0) {
                $str .= $param['day'] . ' hari ' . '-';
            } elseif (isset($param['hour']) && $param['hour'] != 0) {
                $str .= $param['hour'] . ' jam ' . '-';
            } elseif (isset($param['minute']) && $param['minute'] != 0) {
                $str .= $param['minute'] . ' menit ' . '-';
            } elseif (isset($param['second']) && $param['second'] != 0) {
                $str .= $param['second'] . ' detik';
            }
            //1 hari - 20 jam - 30 menit - 22 detik 
            return $str;
        }
    }

    public static function convertToObject($data = []) {
        if (!is_array($data)) {
            return 'this is not array';
        }
        return json_decode(json_encode($data), FALSE);
    }

    public static function _set_response($type = 'json', $params = array()) {
        if ($params) {
            switch ($type) {
                case "json":
                    $response = json_encode(
                            array(
                                'status' => array(
                                    'code' => $params['code'],
                                    'message' => $params['message']
                                ),
                                'options' => array_merge(['valid' => isset($params['valid']) ? $params['valid'] : false, 'meta' => isset($params['meta']) ? $params['meta'] : []]),
                                'data' => isset($params['data']) ? $params['data'] : []
                            )
                    );
                    break;
                case "array":
                    $response = array(
                        'status' => array(
                            'code' => $params['code'],
                            'message' => $params['message']
                        ),
                        'options' => array_merge(['valid' => isset($params['valid']) ? $params['valid'] : false, 'meta' => isset($params['meta']) ? $params['meta'] : []]),
                        'data' => isset($params['data']) ? $params['data'] : []
                    );
                    break;
                case "object":
                    $array = array(
                        'status' => array(
                            'code' => $params['code'],
                            'message' => $params['message']
                        ),
                        'options' => array_merge(['valid' => isset($params['valid']) ? $params['valid'] : false, 'meta' => isset($params['meta']) ? $params['meta'] : []]),
                        'data' => isset($params['data']) ? $params['data'] : []
                    );
                    $response = json_decode(json_encode($array), FALSE);
                    break;
                case "xml":
                    $array = array(
                        'status' => array(
                            'code' => $params['code'],
                            'message' => $params['message']
                        ),
                        'options' => array_merge(['valid' => isset($params['valid']) ? $params['valid'] : false, 'meta' => isset($params['meta']) ? $params['meta'] : []]),
                        'data' => isset($params['data']) ? $params['data'] : []
                    );
                    $xml = new SimpleXMLElement('<root/>');
                    array_walk_recursive($array, array($xml, 'addChild'));
                    $response = $xml->asXML();
                    break;
            }
            return $response;
        }
    }

    public static function validate_img_exist($external_link) {
        if ($external_link && @getimagesize($external_link)) {
            return true;
        } else {
            return false;
        }
    }

    public static function generate_jwt($headers, $payload, $secret = 'secret') {
        $headers_encoded = MyHelper::base64url_encode(json_encode($headers));
        $payload_encoded = MyHelper::base64url_encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        $signature_encoded = MyHelper::base64url_encode($signature);
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $jwt;
    }

    public static function base64url_encode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    public static function decode_jwt($jwt, $secret = 'secret') {
        // split the jwt
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];
        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->expired_date;
        $is_token_expired = ($expiration - time()) < 0;
        // build a signature based on the header and payload using the secret
        $base64_url_header = MyHelper::base64url_encode($header);
        $base64_url_payload = MyHelper::base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = MyHelper::base64url_encode($signature);
        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);
        return json_decode($payload);
    }

    public static function is_jwt_valid($jwt, $secret = 'secret') {
        // split the jwt
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];
        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->expired_date;
        $is_token_expired = ($expiration - time()) < 0;
        // build a signature based on the header and payload using the secret
        $base64_url_header = MyHelper::base64url_encode($header);
        $base64_url_payload = MyHelper::base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = MyHelper::base64url_encode($signature);
        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);
        $user = json_decode($payload);
        $is_expired = false;
        if ($user->expired_date < strtotime(date('Y-m-d H:i:s'))) {
            $is_expired = true;
            DB::table('tbl_user_c_tokens')->where('created_by', $user->user_id)->update([
                'is_logged_in' => 0,
                'is_expiry' => 1,
                'updated_by' => $user->user_id,
                'updated_date' => date('Y-m-d H:i:s'),
            ]);
            return false;
        } else {
            $token_exist = DB::table('tbl_user_c_tokens AS a')->select('a.id', 'a.token')->where('a.created_by', '=', $user->user_id)->first();
            if ($token_exist->token == $jwt) {
                if ($is_token_expired || !$is_signature_valid) {
                    DB::table('tbl_user_c_tokens')->where('created_by', $user->user_id)->update([
                        'expiry_date' => date('Y-m-d H:i:s', strtotime('+12 Hours')),
                        'is_logged_in' => 0,
                        'is_expiry' => 1,
                        'updated_by' => $user->user_id,
                        'updated_date' => date('Y-m-d H:i:s'),
                    ]);
                    return false;
                } else {
                    DB::table('tbl_user_c_tokens')->where('created_by', $user->user_id)->update([
                        'expiry_date' => date('Y-m-d H:i:s', strtotime('+12 Hours')),
                        'is_logged_in' => 1,
                        'is_expiry' => 0,
                        'updated_by' => $user->user_id,
                        'updated_date' => date('Y-m-d H:i:s'),
                    ]);
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    public static function session_flash_custom($params = array()) {
        $message = [];
        if ($params) {
            $message = [
                'alert-msg' => [
                    [
                        'type' => $params['body']['type'],
                        'message' => $params['body']['message']
                    ]
                ]
            ];
            session($message);
            session()->save();
        }
    }

}
