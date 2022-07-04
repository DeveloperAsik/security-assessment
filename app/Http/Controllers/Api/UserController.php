<?php

namespace App\Http\Controllers\Api;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
/**
 * Description of DefaultController
 *
 * @author I00396.ARIF
 */
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    //put your code here
    public function index(Request $request) {
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully connect to db', 'valid' => true,'meta' => null, 'data' => null]);
    }

    public function get_list(Request $request) {
        $limit = ($request->limit) ? $request->limit : 10;
        $offset = ($request->offset) ? $request->offset : 0;
        $data = DB::table('tbl_a_users AS a')
                ->select('a.id','a.user_name','a.first_name','a.last_name','a.email','a.created_date','c.id AS group_id','c.name AS group_name')
                ->leftJoin('tbl_a_user_groups AS b','b.user_id','=','a.id')
                ->leftJoin('tbl_a_groups AS c','c.id','=','b.group_id')
                ->offset($offset)
                ->limit($limit)
                ->get();
        if (isset($data) && !empty($data)) {
            $meta = [
                'total' => count($data),
                'offset' => $offset,
                'limit' => $limit,
                'query_param' => $request->getRequestUri()
            ];
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'meta' => $meta, 'data' => $data]);
        } else {
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed fetching data', 'valid' => false, 'data' => null]);
        }
    }

}
