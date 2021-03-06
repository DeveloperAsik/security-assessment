<?php

namespace App\Http\Controllers\Backend\Project;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;
use App\Models\MY_Model;

/**
 * Description of TeamUsersController
 *
 * @author User
 */
class TeamUsersController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_a_project_team_users';

    public function __construct(Request $request, MY_Model $MY_Model) {
        parent::__construct($request);
        $this->MY_Model = $MY_Model;
    }

    public function create(Request $request, $team_id) {
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
                'title' => 'Team user list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/team/user/view/' . $team_id
            ],
            [
                'id' => 3,
                'title' => 'Create new Team user',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Create new <b>Team User</b> master data management page',
            'create_page' => [
                'title' => 'click to open group list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/project/team/user/view/' . $team_id
            ]
        ];

        $params = [
            'table_name' => 'tbl_a_project_teams'
        ];
        $teams = $this->MY_Model->find($request, 'list', $params, 'mysql_assessment');
        $params = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.rank', 'a.is_menu', 'a.is_active', 'a.description', 'b.id AS parent_id', 'b.name AS parent_name'],
            'join' => [
                'leftJoin' => [
                    ['tbl_a_groups as b', 'b.id', '=', 'a.parent_id']
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $groups = $this->MY_Model->find($request, 'list', $params);
        $param_permission = [
            'table_name' => 'tbl_a_permissions',
            'order' => [
                ['a.name', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $permissions = $this->MY_Model->find($request, 'list', $param_permission);
        $params = [
            ['key' => 'team_id', 'val' => $team_id]
        ];
        $this->load_ajax_var($params);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'team_id', 'teams', 'groups', 'permissions'));
    }

    public function edit(Request $request, $pr_id = null) {
        $id = base64_decode($pr_id);
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
                'title' => 'Team list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/team/view'
            ],
            [
                'id' => 3,
                'title' => 'Team edit',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Update <b>Team</b> master data management page',
            'create_page' => [
                'title' => 'click to open group list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/project/team/view'
            ]
        ];
        $group_exist = $this->get_group_exist($request);
        $params = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.description', 'a.rank', 'a.is_menu', 'a.is_active', 'b.id AS parent_id', 'b.name AS parent_name'],
            'join' => [
                'leftJoin' => [
                    ['tbl_a_groups as b', 'b.id', '=', 'a.parent_id']
                ]
            ],
            'conditions' => [
                'where' => [
                    ['a.id', '=', $id]
                ]
            ]
        ];
        $group = $this->MY_Model->find($request, 'first', $params);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'group_exist', 'group'));
    }

    public function view(Request $request, $team_id) {
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
                'title' => 'Team list',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => '<b>Team</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new group',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/project/team/user/create/' . $team_id
            ]
        ];
        $params = [
            ['key' => 'team_id', 'val' => $team_id]
        ];
        $this->load_ajax_var($params);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config'));
    }

    public function get_list(Request $request) {
        if (isset($request) && !empty($request)) {
            $draw = $request->draw;
            $limit = ($request->length) ? $request->length : 10;
            if ($request->length == '-1') {
                $limit = 1000;
            }
            $team_id = base64_decode($request->team_id);
            $offset = ($request->start) ? $request->start : 0;
            $search = $request->search['value'];
            if (isset($search) && !empty($search)) {
                $conditions = [
                    'where' => [
                        ['a.team_id', '=', $team_id]
                    ],
                    'orWhere' => [
                        ['a.code', 'like', '%' . $search . '%'],
                        ['a.user_name', 'like', '%' . $search . '%'],
                        ['a.first_name', 'like', '%' . $search . '%'],
                        ['a.last_name', 'like', '%' . $search . '%'],
                        ['a.email_address', 'like', '%' . $search . '%'],
                        ['a.phone_number', 'like', '%' . $search . '%']
                    ]
                ];
            } else {
                $conditions = [
                    'where' => [
                        ['a.team_id', '=', $team_id]
                    ]
                ];
            }
            $params = [
                'table_name' => $this->table_default,
                'select' => [
                    'a.*',
                    'b.id AS team_id', 'b.code AS team_code', 'b.name AS team_name', 'b.email AS team_email', 'b.phone_number AS team_phone_number'
                ],
                'join' => [
                    'leftJoin' => [
                        ['tbl_a_project_teams AS b', 'b.id', '=', 'a.team_id']
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
            $data = $this->MY_Model->find($request, 'all', $params, 'mysql_assessment');
            if (isset($data['data']) && !empty($data['data'])) {
                $arrData = array();
                if ($offset == 0) {
                    $i = 1;
                } else {
                    $i = ($offset + 1);
                }
                foreach ($data['data'] AS $keyword => $value) {
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arrData[] = [
                        'id' => $i,
                        'photo' => '<img src="' . $value->photo . '" style="width:128px"/>',
                        'code' => $value->code,
                        'user_name' => $value->user_name,
                        'first_name' => $value->first_name,
                        'last_name' => $value->last_name,
                        'email' => $value->email_address,
                        'phone_number' => $value->phone_number,
                        'team_name' => $value->team_name,
                        'team_email' => $value->team_email,
                        'team_phone_number' => $value->team_phone_number,
                        'status' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button team="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/team/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button team="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/team/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button team="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/team/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
                        <button team="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/team/user/view/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="View User Team"><i class="fa fa-users"></i></a></button>
                      </div>',
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

    public function insert(Request $request, $team_id) {
        $data = $request->json()->all();
        $response = false;
		$file = $this->fnUploadPhoto($request, $team_id);
        if (isset($data) && !empty($data)) {
            $param = [
                'code' => $data['code'],
                'user_name' => $data['user_name'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email_address' => $data['email_address'],
                'phone_number' => $data['phone_number'],
                'team_id' => base64_decode($team_id),
                'description' => $data['description'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'created_by' => $this->__user_id,
                'created_date' => MyHelper::getDateNow(),
                'updated_by' => $this->__user_id,
                'updated_date' => MyHelper::getDateNow()
            ];
            $response = DB::table('tbl_a_groups')->insert($param);
            if ($response) {
                if ($data['is_generate']) {
                    $this->insert_user($request, $data);
                }
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully insert data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed insert data.', 'valid' => false]);
            }
        }
    }

    protected function fnUploadPhoto(Request $request, $team_id) {
        if (isset($request) && !empty($request)) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $file_extension = $file->getClientOriginalExtension();
            $path = '/__media/images/user_profiles/' . base64_encode($team_id);
            $result = $file->move(public_path() . $path, $file_name);
            if ($result) {
				$params = [
					'table_name' => 'tbl_a_users',
					'select' => ['a.id', 'a.profile_id'],
					'conditions' => [
						'where' => [
							['a.id', '=', $this->__user_id]
						]
					]
				];
				$profile_user = $this->MY_Model->find($request, 'first', $params)['data'];
                DB::table('tbl_a_user_profiles')->where('id', $profile_user->profile_id)->update(['photo' => $path . '/' . $file_name]);
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully upload picture', 'valid' => true, 'data' => ['path' => $path . '/' . $file_name]]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed upload picture', 'valid' => false, 'data' => null]);
            }
        } else {
			return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed upload picture', 'valid' => false, 'data' => null]);
		}
    }

    protected function insert_user($request, $data) {
        $salt = config('app.salt');
        $params = [
            'table_name' => 'tbl_a_users',
            'conditions' => [
                'where' => [
                    ['a.email_address', '=', $data['email_address']]
                ]
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $user_exist = $this->MY_Model->find($request, 'first', $params);
        if (isset($user_exist['data']) && !empty($user_exist['data'])) {
            $user_detail_id = $user_exist['data']->id;
            $profile_id = $user_exist['data']->profile_id;
        } else {
            $profile_id = 0;
            $password = TokenUser::__string_hash($data['user_name'] . $salt);
            $user_detail = [
                'user_name' => $data['user_name'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'salt' => $salt,
                'password' => $password,
                'description' => $data['description'],
                'profile_id' => $profile_id,
                'registered_type_id' => 1,
                'is_active' => $data['is_active'],
                'created_by' => $this->__user_id,
                'created_date' => MyHelper::getDateNow(),
                'updated_by' => $this->__user_id,
                'updated_date' => MyHelper::getDateNow()
            ];
            $user_id = DB::table('tbl_a_users')->insertGetId($user_detail);
        }
        if ($user_id && $profile_id == 0) {
            if ($data['group']) {
                $insert_user_group = [
                    'user_id' => $user_id,
                    'group_id' => $data['group'],
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                DB::table('tbl_b_user_groups')->insert($insert_user_group);
            }
            return true;
            //return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully insert data', 'valid' => true]);
        } else {
            return false;
            //return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed insert data. user already exist or this user email already used.', 'valid' => false]);
        }
    }

    public function update(Request $request, $pr_id = null) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $id = base64_decode($pr_id);
            switch ($data['action']) {
                case 'is_active':
                    $update_data = [
                        'is_active' => $data['is_active'],
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
                default:
                    $update_data = [
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'rank' => $data['rank'],
                        'is_menu' => isset($data['is_menu']) ? 1 : 0,
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::table('tbl_a_groups')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

    protected function get_group_exist($request) {
        $params = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.rank', 'a.is_menu', 'a.is_active', 'a.description', 'b.id AS parent_id', 'b.name AS parent_name'],
            'join' => [
                'leftJoin' => [
                    ['tbl_a_groups as b', 'b.id', '=', 'a.parent_id']
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'limit' => 100,
            'offset' => 0,
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        return $this->MY_Model->find($request, 'all', $params);
    }

}
