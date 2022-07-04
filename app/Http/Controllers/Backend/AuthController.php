<?php

namespace App\Http\Controllers\Backend;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;


/**
 * Description of DefaultController
 *
 * @author I00396.ARIF
 */
class AuthController extends Controller {

    //put your code here

    public function login(Request $request) {
        $data = session()->all();
        if (isset($data['_session_is_logged_in']) && !empty($data['_session_is_logged_in']) && $data['_session_is_logged_in'] == true) {
            return redirect('/extraweb/dashboard');
        } else {
            $title_for_layout = config('app.default_variables.title_for_layout');
            $_session_destination_path = '';
            if (isset($data['_session_destination_path']) && !empty($data['_session_destination_path'])) {
                $_session_destination_path = $data['_session_destination_path'];
            }
            $_env = config('env');
            return view('Public_html.Layouts.Adminlte.login', compact('title_for_layout', '_env', '_session_destination_path'));
        }
    }

    public function logout(Request $request) {
        Authenticate::clear_session();
        return redirect('/extraweb/login');
    }

    public function forgot_password(Request $request) {
        $data = session()->all();
        if (isset($data['_session_is_logged_in']) && !empty($data['_session_is_logged_in']) && $data['_session_is_logged_in'] == true) {
            return redirect('/extraweb/dashboard');
        } else {
            $title_for_layout = config('app.default_variables.title_for_layout');
            $_session_destination_path = '';
            if (isset($data['_session_destination_path']) && !empty($data['_session_destination_path'])) {
                $_session_destination_path = $data['_session_destination_path'];
            }
            $_env = config('env');
            return view('Public_html.Layouts.Adminlte.login', compact('title_for_layout', '_env', '_session_destination_path'));
        }
    }

}
