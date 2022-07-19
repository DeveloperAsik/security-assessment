<?php

namespace App\Models\Tables\Core;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Models\MY_Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;

/**
 * Description of Tbl_a_users
 *
 * @author elitebook
 */
class Tbl_a_users extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_a_users";

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

    public static function fnGetUserProfiles($request, $group_id = null) {
        $data = $request->session()->all();
        if ($data) {
            $user_profiles = DB::table(self::$table_name . ' AS a')
                            ->select('a.id', 'a.user_name', 'a.first_name', 'a.last_name', 'a.email', 'c.id AS group_id', 'c.name AS group_name', 'e.address', 'e.lat', 'e.lng', 'e.zoom', 'e.facebook', 'e.twitter', 'e.instagram', 'e.linkedin', 'e.photo', 'e.last_education', 'e.last_education_institution', 'e.skill', 'e.notes', 'e.description')
                            ->leftJoin('tbl_b_user_groups AS b', 'b.user_id', '=', 'a.id')
                            ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'b.group_id')
                            ->leftJoin('tbl_b_group_permissions AS d', 'd.group_id', '=', 'b.group_id')
                            ->leftJoin('tbl_a_user_profiles AS e', 'e.id', '=', 'a.profile_id')
                            ->where('a.id', '=', $group_id)->first();
            $group_permission = DB::table('tbl_b_group_permissions AS a')
                            ->select('b.id', 'b.name', 'b.path', 'b.controller', 'b.method', 'c.id AS group_id', 'c.name AS group_name', 'd.id AS module_id', 'd.name AS module_name')
                            ->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                            ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                            ->leftJoin('tbl_a_modules AS d', 'd.id', '=', 'a.module_id')
                            ->where('a.group_id', '=', $group_id)->get();
            return MyHelper::array_to_object(['user_profile' => $user_profiles, 'permission' => $group_permission]);
        } else {
            return null;
        }
    }

}
