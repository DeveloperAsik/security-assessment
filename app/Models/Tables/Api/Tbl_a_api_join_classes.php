<?php

namespace App\Models\Tables\Api;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Models\MY_Model;
use Illuminate\Support\Facades\DB;

class Tbl_a_api_join_classes extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_a_api_join_classes";

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($id) {
        $dataExist = DB::connection('mysql_api')->table(self::$table_name)->where([
            ['id', '=', $id],
            ['is_active', '=', 1]
        ]);
        $dataExistTotal = $dataExist->count();
        if ($dataExistTotal && $dataExistTotal == 1) {
            $dataExistGet = $dataExist->select('*')->first();
            return $dataExistGet;
        } else {
            return null;
        }
    }

    public static function get_all($request) {
        $limit = ($request->limit) ? $request->limit : 10;
        $offset = ($request->offset) ? $request->offset : 0;
        $data = DB::connection('mysql_api')->table(self::$table_name . ' AS a')
                ->select('*')
                ->offset($offset)
                ->limit($limit)
                ->orderBy('a.id', 'desc')
                ->get();
        if (isset($data) && !empty($data)) {
            $meta = [
                'total' => DB::connection('mysql_api')->table(self::$table_name)->count(),
                'offset' => $offset,
                'limit' => $limit,
                'query_param' => $request->getRequestUri()
            ];
            return [
                'meta' => $meta, 'data' => $data
            ];
        } else {
            return null;
        }
    }

    public static function do_insert($data) {
        return DB::connection('mysql_api')->table(self::$table_name)->insert($data);
    }

    public static function do_update($data, $options) {
        if (!$options || empty($options)) {
            return null;
        }
        return DB::connection('mysql_api')->table(self::$table_name)->where($options['keyword'], $options['value'])->update($data);
    }

}
