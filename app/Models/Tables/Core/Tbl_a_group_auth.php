<?php

namespace App\Models\Tables\Core;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Models\MY_Model;
use Illuminate\Support\Facades\DB;

/**
 * Description of Tbl_a_group_auth
 *
 * @author elitebook
 */
class Tbl_a_group_auth extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_a_group_auth";

    public function __construct() {
        parent::__construct();
    }

    public static function get_by_id($id) {
        $dataExist = DB::table(self::$table_name)->where([
            ['id', '=', $id]
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
        $data = DB::table(self::$table_name . ' AS a')
                ->select('*')
                ->offset($offset)
                ->limit($limit)
                ->orderBy('a.id', 'desc')
                ->get();
        if (isset($data) && !empty($data)) {
            $meta = [
                'total' => DB::table(self::$table_name)->count(),
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
        return DB::table(self::$table_name)->insert($data);
    }

    public static function do_update($data, $options) {
        if (!$options || empty($options)) {
            return null;
        }
        return DB::table(self::$table_name)->where($options['keyword'], $options['value'])->update($data);
    }

    public function getCurrentGroup($request, $data, $group_id) {
        $permissionExist = DB::table(self::$table_name)->where([
            ['permission_id', '=', $data->id],
            ['group_id','=', $group_id],
            ['is_active', '=', 1]
        ]);
        $permissionExistTotal = $permissionExist->count();
        if ($permissionExistTotal && $permissionExistTotal == 1) {
            $permissionExistGet = $permissionExist->select('id', 'permission_id', 'group_id', 'is_public', 'is_allowed', 'is_active')->first();
            return $permissionExistGet;
        } else {
            return null;
        }
    }

}