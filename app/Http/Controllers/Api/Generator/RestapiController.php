<?php

namespace App\Http\Controllers\Api\Generator;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Tables\Tbl_api_generates;
use App\Models\Tables\Tbl_user_c_menu;
use App\Models\Tables\Tbl_social_medias;
use App\Models\Tables\Tbl_contact_details;
use App\Models\Tables\Tbl_b_poly;

/**
 * Description of RestapiController
 *
 * @author elitebook
 */
class RestapiController extends Controller {

    //put your code here

    public function __get_fnc(Request $request, $param = null, $options) {
        $response = null;
        //$response = Tbl_api_generates::get_data_by_code($request,$param);
        switch ($param) {
            case "menu":
                $response = $this->fn_get_menu($request, $options);
                break;
            case "social-media":
                $response = $this->fn_get_social_media($request, $options);
                break;
            case "contact-detail":
                $response = $this->fn_get_contact_detail($request, $options);
                break;
            case "poly":
                $response = $this->fn_get_poly_list($request, $options);
                break;
        }
        return $response;
    }

    protected function fn_get_menu($request, $options) {
        $response = Tbl_user_c_menu::get_list($request, 2, 2);
        if ($response) {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'meta' => [], 'data' => $response]);
        } else {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed fetching data', 'valid' => false, 'data' => null]);
        }
    }

    protected function fn_get_social_media($request, $options) {
        $response = Tbl_social_medias::get_list($request);
        if ($response) {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'meta' => [], 'data' => $response]);
        } else {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed fetching data', 'valid' => false, 'data' => null]);
        }
    }

    protected function fn_get_contact_detail($request, $options) {
        $response = Tbl_contact_details::get_list($request);
        if ($response) {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'meta' => [], 'data' => $response]);
        } else {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed fetching data', 'valid' => false, 'data' => null]);
        }
    }

    protected function fn_get_poly_list($request, $options) {
        $response = Tbl_b_poly::get_list($request);
        if ($response) {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'meta' => [], 'data' => $response]);
        } else {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed fetching data', 'valid' => false, 'data' => null]);
        }
    }

    public function __post_fnc(Request $request, $param = null) {
        $response = null;
        switch ($param) {
            case "":
                $response = $this->fn_post_($request);
                break;
        }
        return $response;
    }

}
