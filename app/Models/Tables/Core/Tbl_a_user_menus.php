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
 * Description of Tbl_a_user_menus
 *
 * @author elitebook
 */
class Tbl_a_user_menus extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_a_user_menus";

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

    public static function get_menus($module_id, $level, $parent_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.level', 'a.rank', 'a.parent_id', 'a.is_badge', 'a.is_open', 'a.is_active', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where('a.module_id', '=', $module_id)
                        ->where('a.level', '=', $level)
                        ->where('a.parent_id', '=', $parent_id)
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_menu_by_id($id, $level, $parent_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.level', 'a.rank', 'a.parent_id', 'a.is_badge', 'a.is_open', 'a.is_active', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where('a.id', '=', $id)
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_menu_by_parent_id($module_id, $level, $parent_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.level', 'a.rank', 'a.parent_id', 'a.is_badge', 'a.is_open', 'a.is_active', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where('a.parent_id', '=', $parent_id)
                        ->where('a.module_id', '=', $module_id)
                        ->where('a.level', '=', $level)
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_menu_by_level($level, $module_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'b.id AS module_id', 'b.title AS module_name', 'c.id AS parent_id', 'c.name AS parent_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->leftJoin(self::$table_name . ' AS c', 'c.id', '=', 'a.parent_id')
                        ->where('a.module_id', '=', $module_id)
                        ->where('a.level', '=', $level)
                        ->orderBy('a.parent_id', 'ASC')
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_tree_menu($request, $__user_id, $__module_id) {
        $menu = [];
        $menu_exist_1 = DB::table(self::$table_name . ' AS a')
                ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS user_id', 'd.user_name', 'd.first_name', 'd.last_name', 'd.email')
                ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'b.user_id')
                ->where('a.level', '=', 1)
                ->where('a.module_id', '=', $__module_id)
                ->where('b.user_id', '=', $__user_id)
                ->orderBy('a.rank', 'ASC')
                ->get();
        if (isset($menu_exist_1) && !empty($menu_exist_1)) {
            foreach ($menu_exist_1 AS $keyword => $value) {
                $menu_exist_2 = DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS user_id', 'd.user_name', 'd.first_name', 'd.last_name', 'd.email')
                        ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                        ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'b.user_id')
                        ->where('a.level', '=', 2)
                        ->where('a.parent_id', '=', $value->id)
                        ->where('a.module_id', '=', $__module_id)
                        ->where('b.user_id', '=', $__user_id)
                        ->orderBy('a.rank', 'ASC')
                        ->get();
                $menu2 = [];
                if (isset($menu_exist_2) && !empty($menu_exist_2)) {
                    foreach ($menu_exist_2 AS $key => $val) {
                        $menu_exist_3 = DB::table(self::$table_name . ' AS a')
                                ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS user_id', 'd.user_name', 'd.first_name', 'd.last_name', 'd.email')
                                ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                                ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'b.user_id')
                                ->where('a.level', '=', 3)
                                ->where('a.parent_id', '=', $val->id)
                                ->where('a.module_id', '=', $__module_id)
                                ->where('b.user_id', '=', $__user_id)
                                ->orderBy('a.rank', 'ASC')
                                ->get();
                        $menu3 = [];
                        if (isset($menu_exist_3) && !empty($menu_exist_3)) {
                            foreach ($menu_exist_3 AS $k => $v) {
                                $menu_exist_4 = DB::table(self::$table_name . ' AS a')
                                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS user_id', 'd.user_name', 'd.first_name', 'd.last_name', 'd.email')
                                        ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                                        ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'b.user_id')
                                        ->where('a.level', '=', 4)
                                        ->where('a.parent_id', '=', $v->id)
                                        ->where('a.module_id', '=', $__module_id)
                                        ->where('b.user_id', '=', $__user_id)
                                        ->orderBy('a.rank', 'ASC')
                                        ->get();
                                $menu4 = [];
                                if (isset($menu_exist_4) && !empty($menu_exist_4)) {
                                    foreach ($menu_exist_4 AS $l => $w) {
                                        $menu_exist_5 = DB::table(self::$table_name . ' AS a')
                                                ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS user_id', 'd.user_name', 'd.first_name', 'd.last_name', 'd.email')
                                                ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                                                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                                                ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'b.user_id')
                                                ->where('a.level', '=', 5)
                                                ->where('a.parent_id', '=', $w->id)
                                                ->where('a.module_id', '=', $__module_id)
                                                ->where('b.user_id', '=', $__user_id)
                                                ->orderBy('a.rank', 'ASC')
                                                ->get();
                                        $menu5 = [];
                                        if (isset($menu_exist_5) && !empty($menu_exist_5)) {
                                            foreach ($menu_exist_5 AS $m => $x) {
                                                $menu5[] = [
                                                    "id" => $x->id,
                                                    "title" => $x->title,
                                                    "path" => $x->path,
                                                    "icon" => $x->icon,
                                                    "level" => $x->level,
                                                    "is_badge" => $x->is_badge,
                                                    "is_open" => $x->is_open,
                                                    "badge" => isset($x->badge) ? $x->badge : '',
                                                    "badge_id" => isset($x->badge_id) ? $x->badge_id : '',
                                                    "badge_value" => isset($x->badge_value) ? $x->badge_value : '',
                                                    "parent_id" => isset($x->parent_id) ? $x->parent_id : 0,
                                                    "user_id" => $x->user_id,
                                                    "child" => []
                                                ];
                                            }
                                        }
                                        $menu4[] = [
                                            "id" => $w->id,
                                            "title" => $w->title,
                                            "path" => $w->path,
                                            "icon" => $w->icon,
                                            "level" => $w->level,
                                            "is_badge" => $w->is_badge,
                                            "is_open" => $w->is_open,
                                            "badge" => isset($w->badge) ? $w->badge : "",
                                            "badge_id" => isset($w->badge_id) ? $w->badge_id : '',
                                            "badge_value" => isset($w->badge_value) ? $w->badge_value : '',
                                            "parent_id" => isset($w->parent_id) ? $w->parent_id : '',
                                            "user_id" => $w->user_id,
                                            "child" => $menu5
                                        ];
                                    }
                                }
                                $menu3[] = [
                                    "id" => $v->id,
                                    "title" => $v->title,
                                    "path" => $v->path,
                                    "icon" => $v->icon,
                                    "level" => $v->level,
                                    "is_badge" => $v->is_badge,
                                    "is_open" => $v->is_open,
                                    "badge" => isset($v->badge) ? $v->badge : "",
                                    "badge_id" => isset($v->badge_id) ? $v->badge_id : "",
                                    "badge_value" => isset($v->badge_value) ? $v->badge_value : "",
                                    "parent_id" => isset($v->parent_id) ? $v->parent_id : 0,
                                    "user_id" => $v->user_id,
                                    "child" => $menu4
                                ];
                            }
                        }
                        $menu2[] = [
                            "id" => $val->id,
                            "title" => $val->title,
                            "path" => $val->path,
                            "icon" => $val->icon,
                            "level" => $val->level,
                            "is_badge" => $val->is_badge,
                            "is_open" => $val->is_open,
                            "badge" => isset($val->badge) ? $val->badge : '',
                            "badge_id" => isset($val->badge_id) ? $val->badge_id : '',
                            "badge_value" => isset($val->badge_value) ? $val->badge_value : '',
                            "parent_id" => isset($val->parent_id) ? $val->parent_id : 0,
                            "user_id" => $val->user_id,
                            "child" => $menu3
                        ];
                    }
                }
                $menu[] = [
                    "id" => $value->id,
                    "title" => $value->title,
                    "path" => $value->path,
                    "icon" => $value->icon,
                    "level" => $value->level,
                    "is_badge" => $value->is_badge,
                    "is_open" => $value->is_open,
                    "badge" => isset($value->badge) ? $value->badge : '',
                    "badge_id" => isset($value->badge_id) ? $value->badge_id : '',
                    "badge_value" => isset($value->badge_value) ? $value->badge_value : '',
                    "parent_id" => isset($value->parent_id) ? $value->parent_id : 0,
                    "user_id" => $value->user_id,
                    "child" => $menu2
                ];
            }
        }
        return $menu;
    }

}
