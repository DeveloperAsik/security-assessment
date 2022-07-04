<?php

namespace App\Http\Controllers\Backend;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;

/**
 * Description of ClassesController
 *
 * @author elitebook
 */
class ClassesController extends Controller {

    //put your code here

    public function create(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Classes list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/classes/view'
            ],
            [
                'id' => 2,
                'title' => 'Create New Classes',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/classes/create'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs'));
    }

    public function edit(Request $request, $id = null) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumb = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Classes',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/classes/view'
            ],
            [
                'id' => 3,
                'title' => 'Classes Edit ( id ' . base64_decode($id) . ' )',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/classes/edit/' . $id
            ]
        ];
        $modules = Tbl_user_a_modules::get_all($request);
        $permission = DB::table('tbl_user_d_permissions AS a')->select('*')->where('id', '=', $id)->first();
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', 'modules', 'permission'));
    }

    public function insert(Request $request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $insert_data = [
                'namespace' => $data['namespace'],
                'class' => $data['class'],
                'method' => $data['method'],
                'is_active' => $data['is_active'],
                'created_by' => $this->__user_id,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => $this->__user_id,
                'updated_date' => date('Y-m-d H:i:s')
            ];
            $response = DB::table('tbl_user_a_classes')->insert($insert_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update modules', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update modules.', 'valid' => false]);
            }
        }
    }

    public function update(Request $request, $id = null) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            switch ($data['action']) {
                case 'is_active':
                    $update_data = [
                        'is_active' => $data['is_active'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => date('Y-m-d H:i:s')
                    ];
                    break;
                default:
                    $update_data = [
                        'namespace' => $data['namespace'],
                        'class' => $data['class'],
                        'method' => $data['method'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::table('tbl_user_a_classes')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update modules', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update modules.', 'valid' => false]);
            }
        }
    }

    public function view(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Classes list',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/classes/view'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs'));
    }

}
