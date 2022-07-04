<?php

namespace App\Traits\Request\SIMRS;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Traits\Api;

/**
 * Description of GeneralData
 *
 * @author elitebook
 */
trait PolyData {

    //put your code here

    use Api;

    public function get_list_poly($request, $params = array()) {
        if ($params) {
            $param_data = [
                'auth' => isset($params['auth']) ? $params['auth'] : false,
                'uri' => config('app.url') . '/api/v1/request/poly/get-list',
                'method' => 'GET'
            ];
            return json_decode($this->__init_curl_api($request, $param_data, ['result' => false]));
        }
    }


}
