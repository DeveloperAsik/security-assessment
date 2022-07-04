<?php

namespace App\Traits\Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Traits\Api;

/**
 * Description of ApiData
 *
 * @author I00396.ARIF
 */
trait User_data {

    use Api;

    public function get_list_users($request, $params = array()) {
        if ($params) {
            $param_data = [
                'auth' => isset($params['auth']) ? $params['auth'] : false,
                'uri' => config('app.url') . '/api/v1/user/get-list?page=1&per_page=24',
                'method' => 'GET'
            ];
            return $this->__init_request_api($request, $param_data, ['url' => false]);
        }
    }

}
