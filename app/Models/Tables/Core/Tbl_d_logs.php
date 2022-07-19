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
 * Description of Tbl_d_logs
 *
 * @author elitebook
 */
class Tbl_d_logs extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_d_logs";

    public function __construct() {
        parent::__construct();
    }

    public static function get_by($request, $params = []) {
        $dataExist = DB::table(self::$table_name)->where($params['conditions']);
        $dataExistTotal = $dataExist->count();
        if ($dataExistTotal && $dataExistTotal >= 1) {
            if (isset($params['order']) && !empty($params['order'])) {
                $dataExistGet = $dataExist->orderBy($params['order'][0], $params['order'][1])->first();
            } else {
                $dataExistGet = $dataExist->first();
            }
            return $dataExistGet;
        } else {
            return null;
        }
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
        $sequence = DB::table(self::$table_name . ' AS a')->select('*');
        if (isset($params['conditions']) && !empty($params['conditions'])) {
            foreach ($params['conditions'] AS $keyword => $value) {
                $sequence->where($value[0], $value[1], $value[2]);
            }
        }
        $data = $sequence->offset($offset)->limit($limit)->orderBy($order, $order_type)->get();
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

    public static function get_list($request) {
        $limit = ($request->limit) ? $request->limit : 1000;
        $offset = ($request->offset) ? $request->offset : 0;
        $data = DB::table(self::$table_name . ' AS a')
                ->select('a.id', 'a.fraud_scan', 'a.ip_address', 'a.browser', 'a.class', 'a.method', 'a.event', DB::raw("DATE_FORMAT(a.created_date, '%d %b %Y') as createdDate"), DB::raw("DATE_FORMAT(a.created_date, '%H:%i') as createdDateHour"), 'b.id as user_id', 'b.user_name', 'b.first_name', 'b.last_name', 'b.email')
                ->leftJoin('tbl_a_users AS b', 'b.id', '=', 'a.created_by')
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

}
