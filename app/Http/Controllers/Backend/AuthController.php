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
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\TokenUser;
use App\Helpers\MyHelper;
use App\Models\MY_Model;
use App\Models\Tables\Core\Tbl_a_users;
use App\Models\Tables\Core\Tbl_a_modules;
use App\Models\Tables\Core\Tbl_d_logs;
use App\Models\Tables\Core\Tbl_a_permissions;

/**
 * Description of DefaultController
 *
 * @author I00396.ARIF
 */
class AuthController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_a_permissions';

    public function __construct(Request $request, MY_Model $MY_Model) {
        parent::__construct($request);
        $this->MY_Model = $MY_Model;
    }

    public function login(Request $request) {
        $data = session()->all();
        if (isset($data['_session_is_logged_in']) && !empty($data['_session_is_logged_in']) && $data['_session_is_logged_in'] == true) {
            return redirect('/extraweb/dashboard');
        } else {
            $title_for_layout = config('app.default_variables.title_for_layout');
            $_session_destination_path = '';
            if (isset($data['_session_destination_path']) && !empty($data['_session_destination_path'])) {
                $_session_destination_path = $data['_session_destination_path'];
            }
            $_env = config('env');
            return view('Public_html.Layouts.Adminlte.login', compact('title_for_layout', '_env', '_session_destination_path'));
        }
    }

    public function logout(Request $request) {
        Authenticate::clear_session();
        return redirect('/extraweb/login');
    }

    public function forgot_password(Request $request) {
        $data = session()->all();
        if (isset($data['_session_is_logged_in']) && !empty($data['_session_is_logged_in']) && $data['_session_is_logged_in'] == true) {
            return redirect('/extraweb/dashboard');
        } else {
            $title_for_layout = config('app.default_variables.title_for_layout');
            $_session_destination_path = '';
            if (isset($data['_session_destination_path']) && !empty($data['_session_destination_path'])) {
                $_session_destination_path = $data['_session_destination_path'];
            }
            $_env = config('env');
            return view('Public_html.Layouts.Adminlte.login', compact('title_for_layout', '_env', '_session_destination_path'));
        }
    }

    public function dashboard(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout'));
    }

    public function profile(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/dashboard'
            ],
            [
                'id' => 2,
                'title' => 'User Profile',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/profile/view'
            ]
        ];
        $user = Tbl_a_users::fnGetUserProfiles($request, $this->__group_id);
        $_modal_data = [
            [
                'id' => "modal_change_picture",
                'path' => "Public_html.Modals.Extraweb.User.modal_change_picture"
            ]
        ];
        $params = [
            'conditions' => [
                ['a.created_by', '=', $this->__user_id]
            ]
        ];
        $logs = Tbl_d_logs::get_list($request, $params);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_modal_data', 'user', 'logs'));
    }

    public function update_profile(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/dashboard'
            ],
            [
                'id' => 2,
                'title' => 'Profile',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/profile'
            ],
            [
                'id' => 3,
                'title' => 'Update Profile',
                'icon' => '',
                'arrow' => false,
                'path' => ''
            ]
        ];
        $user = Tbl_a_users::fnGetUserProfiles($request, $this->__group_id);
        $modules = Tbl_a_modules::get_all($request);
        $paramsGroup = [
            'conditions' => [
                'group_id' => $this->__group_id
            ],
            'order' => [
                'keyword' => 'id',
                'type' => 'ASC'
            ]
        ];
        $permissions = Tbl_a_permissions::get_all_inselect($request, $paramsGroup);
        $_modal_data = [
            [
                'id' => "modal_change_picture",
                'path' => "Public_html.Modals.Extraweb.User.modal_change_picture"
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_modal_data', 'user', 'modules', 'permissions'));
    }

    public function get_group_permission_list(Request $request) {
        if (isset($request) && !empty($request)) {
            $draw = $request->draw;
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request->search['value'];
            if(isset($search) && !empty($search)){
                $conditions = [
                    'where' => [
                        ['b.group_id', '=', $this->__group_id],
                    ],
                    'orWhere' => [
                        ['a.name', 'like', '%' . $search . '%'],
                        ['a.path', 'like', '%' . $search . '%'],
                        ['a.controller', 'like', '%' . $search . '%'],
                        ['a.method', 'like', '%' . $search . '%']
                    ]
                ];
            }else{
                $conditions = [
                    'where' => [
                        ['b.group_id', '=', $this->__group_id],
                    ]
                ];
            }
            $params = [
                'table_name' => $this->table_default,
                'select' => ['a.id', 'a.name', 'a.path', 'a.controller', 'a.method', 'a.is_basic AS permission_basic', 'a.is_public', 'a.is_basic', 'a.is_active AS permission_active', 'b.group_id', 'b.permission_id', 'b.module_id', 'b.is_allowed', 'b.is_active'],
                'join' => [
                    'leftJoin' => [
                        ['tbl_b_group_permissions as b', 'b.permission_id', '=', 'a.id']
                    ]
                ],
                'conditions' => $conditions,
                'order' => [
                    ['a.id', 'asc']
                ],
                'limit' => $limit,
                'offset' => $offset,
                'query_param' => config('app.url') . $request->getRequestUri()
            ];
            
            $data = $this->MY_Model->find($request, 'all', $params);
            if (isset($data['data']) && !empty($data['data'])) {
                $arrData = array();
                if ($offset == 0) {
                    $i = 1;
                } else {
                    $i = ($offset + 1);
                }
                foreach ($data['data'] AS $keyword => $value) {
                    $is_public = '';
                    if ($value->is_public == 1) {
                        $is_public = ' checked';
                    }
                    $is_allowed = '';
                    if ($value->is_allowed == 1) {
                        $is_allowed = ' checked';
                    }
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arrData[] = [
                        'id' => $i,
                        'path' => $value->path,
                        'name' => $value->name,
                        'controller' => $value->controller,
                        'method' => $value->method,
                        'is_public' => '<input type="checkbox"' . $is_public . ' name="is_public" disabled class="make-switch" data-size="small">',
                        'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="is_allowed" disabled class="make-switch" data-size="small">',
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" disabled class="make-switch" data-size="small">',
                        'action' => '<a href="">Edit</a> | <a href="">Delete</a>'
                    ];
                     if ($i <= $data['meta']['total']) {
                        $i++;
                    }
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $data['meta']['total'],
                    'recordsFiltered' => $data['meta']['total'],
                    'data' => $arrData,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    public function submit_update_profile(Request $request) {
        switch ($request->a) {
            case 1:
                return $this->submit_update_user($request);
                break;
            case 2:
                return $this->submit_update_prefference($request);
                break;
            case 3:
                return $this->submit_update_permission($request);
                break;
        }
    }

    protected function submit_update_user($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $param_update_profile = [
                'user_name' => (string) $data['user_name'],
                'first_name' => (string) $data['first_name'],
                'last_name' => (string) $data['last_name']
            ];
            DB::table('tbl_a_users')->where('id', $this->__user_id)->update($param_update_profile);
            if ($data['is_change_pass'] == true) {
                $user = DB::table('tbl_a_users AS a')->select('a.id', 'a.user_name', 'a.email', 'a.password')->where('a.id', '=', $this->__user_id)->first();
                if (isset($user) && !empty($user)) {
                    $verify_hash = TokenUser::__verify_hash(base64_decode($data['old_pass']), $user->password);
                    if ($verify_hash == true) {
                        $hashed_new_pass = TokenUser::__string_hash(base64_decode($data['new_pass1']));
                        DB::table('tbl_a_users')->where('id', $this->__user_id)->update([
                            'password' => $hashed_new_pass
                        ]);
                    }
                }
            }
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
        }
    }

    protected function submit_update_prefference($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $user = DB::table('tbl_a_users AS a')->select('a.id', 'a.profile_id')->where('a.id', '=', $this->__user_id)->first();
            if ($user->profile_id != 0) {
                $param_update_profile = [
                    'address' => ($data['address']) ? (string) $data['address'] : '',
                    'zoom' => ($data['zoom']) ? (string) $data['zoom'] : '',
                    'lat' => ($data['lat']) ? (string) $data['lat'] : '',
                    'lng' => ($data['lng']) ? (string) $data['lng'] : '',
                    'facebook' => ($data['facebook']) ? (string) $data['facebook'] : '',
                    'twitter' => ($data['twitter']) ? (string) $data['twitter'] : '',
                    'instagram' => ($data['instagram']) ? (string) $data['instagram'] : '',
                    'linkedin' => ($data['linkedin']) ? (string) $data['linkedin'] : '',
                    'last_education' => ($data['last_education']) ? (string) $data['last_education'] : '',
                    'last_education_institution' => ($data['last_education_institution']) ? (string) $data['last_education_institution'] : '',
                    'skill' => ($data['skill']) ? (string) $data['skill'] : '',
                    'notes' => ($data['notes']) ? (string) $data['notes'] : '',
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                DB::table('tbl_a_user_profiles')->where('id', $user->profile_id)->update($param_update_profile);
            } else {
                $param_update_profile = [
                    'address' => ($data['address']) ? (string) $data['address'] : '',
                    'zoom' => ($data['zoom']) ? (string) $data['zoom'] : '',
                    'lat' => ($data['lat']) ? (string) $data['lat'] : '',
                    'lng' => ($data['lng']) ? (string) $data['lng'] : '',
                    'facebook' => ($data['facebook']) ? (string) $data['facebook'] : '',
                    'twitter' => ($data['twitter']) ? (string) $data['twitter'] : '',
                    'instagram' => ($data['instagram']) ? (string) $data['instagram'] : '',
                    'linkedin' => ($data['linkedin']) ? (string) $data['linkedin'] : '',
                    'photo' => '-',
                    'last_education' => ($data['last_education']) ? (string) $data['last_education'] : '',
                    'last_education_institution' => ($data['last_education_institution']) ? (string) $data['last_education_institution'] : '',
                    'skill' => ($data['skill']) ? (string) $data['skill'] : '',
                    'notes' => ($data['notes']) ? (string) $data['notes'] : '',
                    'description' => '-',
                    'is_active' => 1,
                    'created_by' => $this->__user_id,
                    'created_date' => MyHelper::getDateNow(),
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                $profileID = DB::table('tbl_a_user_profiles')->insertGetId($param_update_profile);
                DB::table('tbl_a_users')->where('id', $user->id)->update(['profile_id' => $profileID]);
            }
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
        }
    }

    protected function submit_update_permission($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            if ($data['permission']) {
                $param_group_permission = [];
                foreach ($data['permission'] AS $keyword => $value) {
                    $param_group_permission[] = [
                        'group_id' => $this->__group_id,
                        'permission_id' => (int) $value,
                        'module_id' => (int) $data['module'],
                        'is_allowed' => ($data['is_allowed'] == true) ? 1 : 0,
                        'is_active' => ($data['is_active'] == true) ? 1 : 0,
                        'created_by' => $this->__user_id,
                        'created_date' => MyHelper::getDateNow(),
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow(),
                    ];
                }
                $result = DB::table('tbl_b_group_permissions')->insert($param_group_permission);
            }
            if ($result) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 500, 'message' => 'Failed insert new permission data.', 'valid' => false]);
            }
        } else {
            return MyHelper::_set_response('json', ['code' => 500, 'message' => 'Failed insert new permission data.', 'valid' => false]);
        }
    }

    public function fnUploadPhoto(Request $request) {
        if (isset($request) && !empty($request)) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $file_extension = $file->getClientOriginalExtension();
            $path = '/__media/images/user_profiles';
            $result = $file->move(public_path() . $path, $file_name);
            if ($result) {
                $profile_user = DB::table('tbl_user_a_users AS a')
                                ->select('a.id', 'a.profile_id')
                                ->where('a.id', '=', $this->__user_id)->first();
                DB::table('tbl_user_a_profiles')->where('id', $profile_user->profile_id)->update(['img' => $path . '/' . $file_name]);
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully upload picture', 'valid' => true, 'data' => ['path' => $path . '/' . $file_name]]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed upload picture', 'valid' => false, 'data' => null]);
            }
        }
    }

}
