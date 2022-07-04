<?php

namespace App\Http\Controllers\Api;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tables\Tbl_user_c_menu;

/**
 * Description of MenuController
 *
 * @author elitebook
 */
class MenuController extends Controller {

    //put your code here

    public function get_list(Request $request) {
        if (isset($request) && !empty($request)) {
            $data = Tbl_user_c_menu::get_sidebar_menu($request, 3, 2);
            if (isset($data) && !empty($data)) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'meta' => [], 'data' => $data]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed fetching data', 'valid' => false, 'data' => null]);
            }
        }
    }

}
