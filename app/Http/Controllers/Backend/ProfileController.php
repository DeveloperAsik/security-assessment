<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;
use App\Models\Tables\Core\Tbl_a_users;
use App\Models\Tables\Core\Tbl_a_modules;
use App\Models\Tables\Core\Tbl_logs;

/**
 * Description of ProfileController
 *
 * @author elitebook
 */
class ProfileController extends Controller {

    //put your code here
    public function view(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
         $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') .'/dashboard'
            ],
            [
                'id' => 2,
                'title' => 'User Profile',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/profile/view'
            ]
        ];
        $user = Tbl_a_users::fnGetUserProfiles($request);
        $_modal_data = [
            [
                'id' => "modal_change_picture",
                'path' => "Public_html.Modals.Extraweb.User.modal_change_picture"
            ]
        ];
        $logs = json_decode(Tbl_logs::get_list($request));
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_modal_data', 'user', 'logs'));
    }

    public function update(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') .'/dashboard'
            ],
            [
                'id' => 2,
                'title' => 'User Profile',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/profile/view'
            ],
            [
                'id' => 3,
                'title' => 'Update',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/profile/update'
            ]
        ];
        $user = Tbl_a_users::fnGetUserProfiles($request);
        $modules = Tbl_a_modules::get_all($request);
        $_modal_data = [
            [
                'id' => "modal_change_picture",
                'path' => "Public_html.Modals.Extraweb.User.modal_change_picture"
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_modal_data', 'user', 'modules'));
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
