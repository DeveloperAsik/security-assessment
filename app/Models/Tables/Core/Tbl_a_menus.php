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
 * Description of Tbl_a_menus
 *
 * @author elitebook
 */
class Tbl_a_menus extends MY_Model {

    //put your code here  
    public static $table_name = "tbl_a_menus";

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

    public static function get_menus($group_id, $level, $parent_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.parent_id', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                        ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                        ->where([['b.group_id', '=', $group_id], ['a.level', '=', $level], ['a.parent_id', '=', $parent_id]])
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_menu_by_id($id, $level, $parent_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.content_path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.level', 'a.rank', 'a.parent_id', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                        ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                        ->where('a.id', '=', $id)
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_menu_by_parent_id($module_id, $level, $parent_id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.content_path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.parent_id', 'a.is_badge', 'a.is_open', 'a.is_active')
                        ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                        ->where([['b.module_id', '=', $module_id], ['a.parent_id', '=', $parent_id], ['a.level', '=', $level]])
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_menu_by_level($id) {
        return DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS parent_id', 'c.name AS parent_name')
                        ->leftJoin(self::$table_name . ' AS c', 'c.id', '=', 'a.parent_id')
                        ->where('a.parent_id', '=', $id)
                        ->orderBy('a.parent_id', 'ASC')
                        ->orderBy('a.rank', 'ASC')
                        ->get();
    }

    public static function get_tree_menu($request, $__group_id, $__module_id) {
        $menu = [];
        $menu_exist_1 = DB::table(self::$table_name . ' AS a')
                ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                ->where('a.level', '=', 1)
                ->where('b.module_id', '=', $__module_id)
                ->where('b.group_id', '=', $__group_id)
                ->orderBy('a.rank', 'ASC')
                ->get();
        if (isset($menu_exist_1) && !empty($menu_exist_1)) {
            foreach ($menu_exist_1 AS $keyword => $value) {
                $menu_exist_2 = DB::table(self::$table_name . ' AS a')
                        ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                        ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                        ->where('a.level', '=', 2)
                        ->where('a.parent_id', '=', $value->id)
                        ->where('b.module_id', '=', $__module_id)
                        ->where('b.group_id', '=', $__group_id)
                        ->orderBy('a.rank', 'ASC')
                        ->get();
                $menu2 = [];
                if (isset($menu_exist_2) && !empty($menu_exist_2)) {
                    foreach ($menu_exist_2 AS $key => $val) {
                        $menu_exist_3 = DB::table(self::$table_name . ' AS a')
                                ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                                ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                                ->where('a.level', '=', 3)
                                ->where('a.parent_id', '=', $val->id)
                                ->where('b.module_id', '=', $__module_id)
                                ->where('b.group_id', '=', $__group_id)
                                ->orderBy('a.rank', 'ASC')
                                ->get();
                        $menu3 = [];
                        if (isset($menu_exist_3) && !empty($menu_exist_3)) {
                            foreach ($menu_exist_3 AS $k => $v) {
                                $menu_exist_4 = DB::table(self::$table_name . ' AS a')
                                        ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                                        ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                                        ->where('a.level', '=', 4)
                                        ->where('a.parent_id', '=', $v->id)
                                        ->where('b.module_id', '=', $__module_id)
                                        ->where('b.group_id', '=', $__group_id)
                                        ->orderBy('a.rank', 'ASC')
                                        ->get();
                                $menu4 = [];
                                if (isset($menu_exist_4) && !empty($menu_exist_4)) {
                                    foreach ($menu_exist_4 AS $l => $w) {
                                        $menu_exist_5 = DB::table(self::$table_name . ' AS a')
                                                ->select('a.id', 'a.name', 'a.icon', 'a.path', 'a.badge', 'a.badge_id', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                                                ->leftJoin('tbl_b_menu_permission AS b', 'b.menu_id', '=', 'a.id')
                                                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'b.module_id')
                                                ->where('a.level', '=', 5)
                                                ->where('a.parent_id', '=', $w->id)
                                                ->where('b.module_id', '=', $__module_id)
                                                ->where('b.group_id', '=', $__group_id)
                                                ->orderBy('a.rank', 'ASC')
                                                ->get();
                                        $menu5 = [];
                                        if (isset($menu_exist_5) && !empty($menu_exist_5)) {
                                            foreach ($menu_exist_5 AS $m => $x) {
                                                $menu5[] = [
                                                    "id" => $x->id,
                                                    "name" => $x->name,
                                                    "path" => $x->path,
                                                    "icon" => $x->icon,
                                                    "level" => $x->level,
                                                    "is_badge" => $x->is_badge,
                                                    "is_open" => $x->is_open,
                                                    "badge" => isset($x->badge) ? $x->badge : '',
                                                    "badge_id" => isset($x->badge_id) ? $x->badge_id : '',
                                                    "badge_value" => isset($x->badge_value) ? $x->badge_value : '',
                                                    "parent_id" => isset($x->parent_id) ? $x->parent_id : 0,
                                                    "child" => []
                                                ];
                                            }
                                        }
                                        $menu4[] = [
                                            "id" => $w->id,
                                            "name" => $w->name,
                                            "path" => $w->path,
                                            "icon" => $w->icon,
                                            "level" => $w->level,
                                            "is_badge" => $w->is_badge,
                                            "is_open" => $w->is_open,
                                            "badge" => isset($w->badge) ? $w->badge : "",
                                            "badge_id" => isset($w->badge_id) ? $w->badge_id : '',
                                            "badge_value" => isset($w->badge_value) ? $w->badge_value : '',
                                            "parent_id" => isset($w->parent_id) ? $w->parent_id : '',
                                            "child" => $menu5
                                        ];
                                    }
                                }
                                $menu3[] = [
                                    "id" => $v->id,
                                    "name" => $v->name,
                                    "path" => $v->path,
                                    "icon" => $v->icon,
                                    "level" => $v->level,
                                    "is_badge" => $v->is_badge,
                                    "is_open" => $v->is_open,
                                    "badge" => isset($v->badge) ? $v->badge : "",
                                    "badge_id" => isset($v->badge_id) ? $v->badge_id : "",
                                    "badge_value" => isset($v->badge_value) ? $v->badge_value : "",
                                    "parent_id" => isset($v->parent_id) ? $v->parent_id : 0,
                                    "child" => $menu4
                                ];
                            }
                        }
                        $menu2[] = [
                            "id" => $val->id,
                            "name" => $val->name,
                            "path" => $val->path,
                            "icon" => $val->icon,
                            "level" => $val->level,
                            "is_badge" => $val->is_badge,
                            "is_open" => $val->is_open,
                            "badge" => isset($val->badge) ? $val->badge : '',
                            "badge_id" => isset($val->badge_id) ? $val->badge_id : '',
                            "badge_value" => isset($val->badge_value) ? $val->badge_value : '',
                            "parent_id" => isset($val->parent_id) ? $val->parent_id : 0,
                            "child" => $menu3
                        ];
                    }
                }
                $menu[] = [
                    "id" => $value->id,
                    "name" => $value->name,
                    "path" => $value->path,
                    "icon" => $value->icon,
                    "level" => $value->level,
                    "is_badge" => $value->is_badge,
                    "is_open" => $value->is_open,
                    "badge" => isset($value->badge) ? $value->badge : '',
                    "badge_id" => isset($value->badge_id) ? $value->badge_id : '',
                    "badge_value" => isset($value->badge_value) ? $value->badge_value : '',
                    "parent_id" => isset($value->parent_id) ? $value->parent_id : 0,
                    "child" => $menu2
                ];
            }
        }
        return $menu;
    }

    public function fn_generate_data_menu_master($request, $user_menu_group_id = 1) {
        $tree_list = Tbl_a_menus::get_tree_menu($request, $group_menu_id);
        if ($tree_list) {
            foreach ($tree_list AS $key => $value) {
                $param = [
                    'name' => $value['name'],
                    'path' => $value['path'],
                    'content_path' => isset($value['content_path']) ? $value['content_path'] : "-",
                    'icon' => isset($value['icon']) ? $value['icon'] : '-',
                    'level' => isset($value['level']) ? $value['level'] : 1,
                    'rank' => isset($value['rank']) ? $value['rank'] : 1,
                    'is_badge' => $value['is_badge'],
                    'badge' => isset($value['badge']) ? $value['badge'] : "",
                    'badge_id' => '-',
                    'badge_value' => isset($value['badge_value']) ? $value['badge_value'] : "",
                    'user_menu_group_id' => $user_menu_group_id,
                    'parent_id' => isset($value['parent_id']) ? $value['parent_id'] : 0,
                    'is_open' => isset($value['is_open']) ? $value['is_open'] : 0,
                    'is_active' => 1,
                    'created_by' => 3,
                    'created_date' => isset($value['created_date']) ? $value['created_date'] : date('Y-m-d H:i:s'),
                    'updated_by' => 3,
                    'updated_date' => isset($value['created_date']) ? $value['created_date'] : date('Y-m-d H:i:s')
                ];
                $menu_id = DB::table('tbl_a_user_menu_master')->insertGetId($param);
                if (isset($value['child']) && !empty($value['child'])) {
                    foreach ($value['child'] AS $key1 => $val1) {
                        $param1 = [
                            'name' => $val1['name'],
                            'path' => $val1['path'],
                            'content_path' => isset($val1['content_path']) ? $val1['content_path'] : "-",
                            'icon' => isset($val1['icon']) ? $val1['icon'] : '-',
                            'level' => isset($val1['level']) ? $val1['level'] : 1,
                            'rank' => isset($val1['rank']) ? $val1['rank'] : 1,
                            'is_badge' => $val1['is_badge'],
                            'badge' => isset($val1['badge']) ? $val1['badge'] : "",
                            'badge_id' => '-',
                            'badge_value' => isset($val1['badge_value']) ? $val1['badge_value'] : "",
                            'user_menu_group_id' => $user_menu_group_id,
                            'parent_id' => $menu_id,
                            'is_open' => isset($val1['is_open']) ? $val1['is_open'] : 0,
                            'is_active' => 1,
                            'created_by' => 3,
                            'created_date' => isset($val1['created_date']) ? $val1['created_date'] : date('Y-m-d H:i:s'),
                            'updated_by' => 3,
                            'updated_date' => isset($val1['created_date']) ? $val1['created_date'] : date('Y-m-d H:i:s')
                        ];
                        $menu_id2 = DB::table('tbl_a_user_menu_master')->insertGetId($param1);
                        if (isset($val1['child']) && !empty($val1['child'])) {
                            foreach ($val1['child'] AS $key2 => $val2) {
                                $param2 = [
                                    'name' => $val2['name'],
                                    'path' => $val2['path'],
                                    'content_path' => isset($val2['content_path']) ? $val2['content_path'] : "-",
                                    'icon' => isset($val2['icon']) ? $val2['icon'] : '-',
                                    'level' => isset($val2['level']) ? $val2['level'] : 1,
                                    'rank' => isset($val2['rank']) ? $val2['rank'] : 1,
                                    'is_badge' => $val2['is_badge'],
                                    'badge' => isset($val2['badge']) ? $val2['badge'] : "",
                                    'badge_id' => '-',
                                    'badge_value' => isset($val2['badge_value']) ? $val2['badge_value'] : "",
                                    'user_menu_group_id' => $user_menu_group_id,
                                    'parent_id' => $menu_id2,
                                    'is_open' => isset($val1['is_open']) ? $val2['is_open'] : 0,
                                    'is_active' => 1,
                                    'created_by' => 3,
                                    'created_date' => isset($val2['created_date']) ? $val2['created_date'] : date('Y-m-d H:i:s'),
                                    'updated_by' => 3,
                                    'updated_date' => isset($val2['created_date']) ? $val2['created_date'] : date('Y-m-d H:i:s')
                                ];
                                $menu_id3 = DB::table('tbl_a_user_menu_master')->insertGetId($param2);
                                if (isset($val2['child']) && !empty($val2['child'])) {
                                    foreach ($val2['child'] AS $key3 => $val3) {
                                        $param3 = [
                                            'name' => $val3['name'],
                                            'path' => $val3['path'],
                                            'content_path' => isset($val3['content_path']) ? $val3['content_path'] : "-",
                                            'icon' => isset($val3['icon']) ? $val3['icon'] : '-',
                                            'level' => isset($val3['level']) ? $val3['level'] : 1,
                                            'rank' => isset($val3['rank']) ? $val3['rank'] : 1,
                                            'is_badge' => $val3['is_badge'],
                                            'badge' => isset($val3['badge']) ? $val3['badge'] : "",
                                            'badge_id' => '-',
                                            'badge_value' => isset($val3['badge_value']) ? $val3['badge_value'] : "",
                                            'user_menu_group_id' => $user_menu_group_id,
                                            'parent_id' => $menu_id3,
                                            'is_open' => isset($val3['is_open']) ? $val3['is_open'] : 0,
                                            'is_active' => 1,
                                            'created_by' => 3,
                                            'created_date' => isset($val3['created_date']) ? $val3['created_date'] : date('Y-m-d H:i:s'),
                                            'updated_by' => 3,
                                            'updated_date' => isset($val3['created_date']) ? $val3['created_date'] : date('Y-m-d H:i:s')
                                        ];
                                        $menu_id4 = DB::table('tbl_a_user_menu_master')->insertGetId($param3);
                                        if (isset($val3['child']) && !empty($val3['child'])) {
                                            foreach ($val3['child'] AS $key4 => $val4) {
                                                $param4 = [
                                                    'name' => $val4['name'],
                                                    'path' => $val4['path'],
                                                    'content_path' => isset($val4['content_path']) ? $val4['content_path'] : "-",
                                                    'icon' => isset($val4['icon']) ? $val4['icon'] : '-',
                                                    'level' => isset($val4['level']) ? $val4['level'] : 1,
                                                    'rank' => isset($val4['rank']) ? $val4['rank'] : 1,
                                                    'is_badge' => $val4['is_badge'],
                                                    'badge' => isset($val4['badge']) ? $val4['badge'] : "",
                                                    'badge_id' => '-',
                                                    'badge_value' => isset($val4['badge_value']) ? $val4['badge_value'] : "",
                                                    'user_menu_group_id' => $user_menu_group_id,
                                                    'parent_id' => $menu_id4,
                                                    'is_open' => isset($val4['is_open']) ? $val4['is_open'] : 0,
                                                    'is_active' => 1,
                                                    'created_by' => 3,
                                                    'created_date' => isset($val4['created_date']) ? $val4['created_date'] : date('Y-m-d H:i:s'),
                                                    'updated_by' => 3,
                                                    'updated_date' => isset($val4['created_date']) ? $val4['created_date'] : date('Y-m-d H:i:s')
                                                ];
                                                $menu_id5 = DB::table('tbl_a_user_menu_master')->insertGetId($param4);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        dd('success stahp process');
    }

}
