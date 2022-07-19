<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Description of MY_Model
 *
 * @author I00396.ARIF
 */
class MY_Model extends Model {

    //put your code here
    use HasFactory;

    public function scopeIsActive($request) {
        $request->where('is_active', 1);
    }

    public function scopeIsNotActive($request) {
        $request->where('is_active', 0);
    }

    //-----------------------------------------------------------------------------//
    //$params = [
    //    'table_name' => 'tbl_a_groups',
    //    'select' => ['a.id', 'a.name', 'b.id AS parent_id', 'b.name AS parent_name'],
    //    'from' => 'tbl_a_groups as a',
    //    'join' => [
    //        'leftJoin' => [
    //            ['tbl_a_groups as b', 'b.id', '=', 'a.parent_id']
    //        ]
    //    ],
    //    'conditions' => [
    //        'where' => [
    //            ['a.is_active', '=', 1]
    //        ]
    //    ],
    //    'order' => [
    //        ['a.id', 'asc'],
    //        ['a.name', 'desc']
    //    ],
    //    'limit' => 5,
    //    'offset' => 0,
    //    'query_param' => config('app.url') . $request->getRequestUri()
    //];
    //$res = $this->MY_Model->find($request, 'all', $params);
    //-----------------------------------------------------------------------------//

    public function find($request, $type = 'all', $params = [], $connection = 'mysql') {
        $limit = isset($params['limit']) ? $params['limit'] : 100;
        $offset = isset($params['offset']) ? $params['offset'] : 0;
        if (isset($params['table_name']) && !empty($params['table_name'])) {
            $table_name = $params['table_name'] . ' AS a';
        } else {
            $table = explode('\\', strtolower(get_class($this)));
            end($table);
            $key = key($table);
            $table_name = $table[$key] . ' AS a';
        }
        $sequence = DB::Connection($connection)->table($table_name);
        $total = 0;
        $select = '*';
        if (isset($params['select']) && !empty($params['select'])) {
            $select = $params['select'];
        }
        if ($type == "list") {
            $select = ['a.id', 'a.name'];
        }
        if (isset($params['join']) && !empty($params['join'])) {
            foreach ($params['join'] AS $key => $val) {
                foreach ($val AS $k => $v) {
                    $sequence->{$key}($v[0], $v[1], $v[2], $v[3]);
                }
            }
        }
        $orWhere = false;
        $arrOrWhere = [];
        if (isset($params['conditions']) && !empty($params['conditions'])) {
            foreach ($params['conditions'] AS $key => $val) {
                if ($key == 'where' || $key == 'orWhere') {
                    $arrOrWhere[] = [
                        'key' => $key,
                        'value' => $val
                    ];
                }
                switch ($key) {
                    case "whereBetween" :
                    case "whereNotBetween" :
                    case "whereIn" :
                    case "whereNotIn" :
                        foreach ($val AS $k => $v) {
                            $sequence->{$key}($v[0], $v[1]);
                        }
                        break;
                    case "whereNull" :
                    case "whereNotNull" :
                        $sequence->{$key}($val);
                        break;
                }
            }
        }
        if (count($arrOrWhere) > 1) {
            foreach ($arrOrWhere AS $key => $value) {
                if ($value['key'] == 'where') {
                    $sequence->where($value['value'][0][0], $value['value'][0][1], $value['value'][0][2]);
                }
                if ($value['key'] == 'orWhere') {
                    $sequence->where(function ($query) use ($value) {
                        foreach ($value['value'] AS $k => $v) {
                            $query->orWhere($v[0], $v[1], $v[2]);
                        }
                    });
                }
            }
        } else {
            foreach ($arrOrWhere AS $key => $value) {
                if ($value['key'] == 'where') {
                    foreach ($value['value'] AS $l => $w) {
                        $sequence->where($w[0], $w[1], $w[2]);
                    }
                }
                if ($value['key'] == 'orWhere') {
                    foreach ($value['value'] AS $l => $w) {
                        $sequence->orWhere($w[0], $w[1], $w[2]);
                    }
                }
            }
        }
        if (isset($type) && !empty($type)) {
            switch ($type) {
                case "first":
                    $data = $sequence->select($select)->orderBy('a.id', 'asc')->first();
                    break;
                case "last";
                    $data = $sequence->select($select)->orderBy('a.id', 'desc')->first();
                    break;
                case "list":
                default:
                    if (isset($params['order']) && !empty($params['order'])) {
                        if (count($params['order']) > 0) {
                            foreach ($params['order'] AS $key => $val) {
                                $sequence->orderBy($val[0], $val[1]);
                            }
                        }
                    }
                    $total = $sequence->count();
                    $data = $sequence->select($select)->offset($offset)->limit($limit)->get();
                    break;
            }
        }
        $meta = [
            'total' => $total,
            'offset' => $offset,
            'current_page' => $offset + 1,
            'limit' => $limit,
            'query_param' => isset($params['query_param']) ? $params['query_param'] : ''
        ];
        return [
            'meta' => $meta, 'data' => $data
        ];
    }

    public function findOne($request, $params = [], $connection = 'mysql') {
        return $this->find($request, 'first', $params, $connection);
    }

    public function findFirst($request, $params = [], $connection = 'mysql') {
        return $this->find($request, 'first', $params, $connection);
    }

    public function findLast($request, $params = [], $connection = 'mysql') {
        return $this->find($request, 'last', $params, $connection);
    }

    public function findList($request, $params = [], $connection = 'mysql') {
        return $this->find($request, 'list', $params, $connection);
    }

}
