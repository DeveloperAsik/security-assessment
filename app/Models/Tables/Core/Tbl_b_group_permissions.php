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
 * Description of tbl_b_group_permissions
 *
 * @author elitebook
 */
class Tbl_b_group_permissions extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_b_group_permissions";

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

    public static function get_all($request, $params = []) {
        $limit = ($request->limit) ? $request->limit : 1000;
        $offset = ($request->offset) ? $request->offset : 0;
        $order = 'a.id';
        $order_type = 'desc';
        if (isset($params['order']) && !empty($params['order'])) {
            $order = $params['order']['keyword'];
            $order_type = $params['order']['type'];
        }
        if (isset($params['conditions']) && !empty($params['conditions'])) {
            $data = DB::table(self::$table_name . ' AS a')
                    ->select('*')
                    ->where($params['conditions'])
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($order, $order_type)
                    ->get();
        } else {
            $data = DB::table(self::$table_name . ' AS a')
                    ->select('*')
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($order, $order_type)
                    ->get();
        }
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

    public static function get_data_by_alias($alias) {
        $dataExist = DB::table(self::$table_name)->where([
            ['alias', '=', $alias]
        ]);
        $dataExistTotal = $dataExist->count();
        if ($dataExistTotal && $dataExistTotal == 1) {
            $dataExistGet = $dataExist->select('*')->first();
            return $dataExistGet;
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

    public static function do_remove($id = null, $data = []) {
        if (!$data || empty($data)) {
            return null;
        }
        return DB::table(self::$table_name)->where('id', '=', $id)->update($data);
    }

    public static function do_delete($id = null) {
        if (!$id || empty($id) || $id == null) {
            return null;
        }
        return DB::table(self::$table_name)->where('id', '=', $id)->delete();
    }

    public function getCurrentGroup($request, $data, $group_id) {
        $permissionExist = DB::table(self::$table_name)->where([
            ['permission_id', '=', $data->id],
            ['group_id', '=', $group_id]
        ]);
        $permissionExistTotal = $permissionExist->count();
        if ($permissionExistTotal && $permissionExistTotal == 1) {
            $permissionExistGet = $permissionExist->select('id', 'permission_id', 'group_id','module_id', 'is_allowed', 'is_active')->first();
            return $permissionExistGet;
        } else {
            return null;
        }
    }

}
