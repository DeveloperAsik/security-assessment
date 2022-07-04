<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use View;
use App\Models\Tables\Core\Tbl_a_user_menus;
use App\Models\Tables\Core\Tbl_d_logs;
use App\Models\Tables\Core\Tbl_a_modules;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function __construct(Request $request) {
        $this->table_name = 'tbl_logs';
        $data = $request->session()->all();
        if (isset($data['_session_is_logged_in']) && !empty($data['_session_is_logged_in']) && $data['_session_is_logged_in'] == true) {
            $this->__is_logged_in = $data['_session_is_logged_in'];
            View::share('__is_logged_in', $data['_session_is_logged_in']);
            $this->__user_id = $data['_session_user_id'];
            View::share('__user_id', $data['_session_user_id']);
            $this->__group_id = $data['_session_group_id'];
            View::share('__group_id', $data['_session_group_id']);
            $this->__user_name = $data['_session_user_name'];
            View::share('__user_name', $data['_session_user_name']);
            $this->__user_email = $data['_session_user_email'];
            View::share('__user_email', $data['_session_user_email']);
        }
        $this->init_global_var($request);
    }

    public function load_css($class = array()) {
        if ($class) {
            View::share('load_css', $class);
        }
    }

    public function load_js($class = array()) {
        if ($class) {
            View::share('load_js', $class);
        }
    }

    public function load_ajax_var($values = array()) {
        if ($values) {
            View::share('load_ajax_var', $values);
        }
    }

    public function init_global_var($request) {
        if (!$request->session()->get('_uuid') || $request->session()->get('_uuid') == null) {
            $request->session()->put('_uuid', uniqid());
        }
        View::share('_uuid', $request->session()->get('_uuid'));
        //init date now
        View::share('_date_now', MyHelper::idnDate('l, j F Y H:i'));
        //env
        View::share('_env', config('app.env'));

        //init days name
        $days_name = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $this->days_name = $days_name;
        View::share('_days_name', $days_name);

        //init month name
        $month_name = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', ' Desember'];
        $this->month_name = $month_name;
        View::share('_months_name', $month_name);

        //init global js
        $path_app_global_js = 'Public_html.Helpers.global_js';
        View::share('_path_app_global_js', $path_app_global_js);

        //init class & method name
        $class_name = str_replace('Controller', '', MyHelper::getRoutes('controller'));
        $method_name = MyHelper::getRoutes('action');

        $routeArray = app('request')->route()->getAction();
        $namespace = $routeArray['namespace'];
        $path_without_namespace = str_replace($namespace, '', $routeArray['uses']);
        $path_without_namespace = str_replace("App", '', $path_without_namespace);
        $path_without_namespace = str_replace("\Http", '', $path_without_namespace);
        $path_without_namespace = str_replace("\Controllers\\", '', $path_without_namespace);
        //$path = str_replace('\\', '.', $path_without_namespace);
        $path_ = explode('\\', $path_without_namespace);
        $controller_path = '';
        $modul = $path_[0];
        $total_namespace = count($path_) - 1;
        for ($i = 0; $i < $total_namespace; $i++) {
            if (isset($controller_path))
                $controller_path .= '.';

            $controller_path .= $path_[$i];
        }
        //$controller_path = $path_[3]; // str_replace($controller, '', $path);
        $controller = $class_name . 'Controller@' . $method_name;
        $views = array(
            'class' => $class_name,
            'method' => $method_name,
            'html' => 'Public_html.Pages' . $controller_path . '.' . $class_name . '.' . $method_name . '_html',
            'js' => 'Public_html.Pages' . $controller_path . '.' . $class_name . '.' . $method_name . '_js'
        );
        View::share('_default_views', $views);
        $arr_nav_menu = [
            [
                'id' => 1,
                'title' => 'Profile',
                'key' => 'profile',
                'path' => config('app.base_extraweb_uri') . '/profile/view'
            ],
            [
                'id' => 2,
                'title' => 'Preference',
                'key' => 'preference',
                'path' => config('app.base_extraweb_uri') . '/preference'
            ],
            [
                'id' => 3,
                'title' => 'Widget',
                'key' => 'widget',
                'path' => config('app.base_extraweb_uri') . '/widget'
            ]
        ];
        View::share('_menu_navigation', json_decode(json_encode($arr_nav_menu)));
        $arr_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.url')
            ]
        ];
        View::share('_breadcrumbs', $arr_breadcrumbs);
        $current_module = Tbl_a_modules::get_data_by_alias(strtolower($modul));
        $module_id = 3;
        if($current_module){
            $module_id = $current_module->id;
        }
        if (isset($this->__user_id) && !empty($this->__user_id)) {
            $sidebar_menu = Tbl_a_user_menus::get_tree_menu($request, $this->__user_id, $module_id);
            if (isset($sidebar_menu) && !empty($sidebar_menu)) {
                View::share('_sidebar_menu', json_decode(json_encode($sidebar_menu)));
            }
        }
        //insert into logs
        $fraud_scan = 'guest user access page with class ' . $class_name . ' and method ' . $method_name . ' at ' . MyHelper::getDateNow();
        $user_id = 1;
        if (isset($this->__user_id) && !empty($this->__user_id)) {
            $fraud_scan = 'User ' . $this->__user_name . ' do access page with class ' . $class_name . ' and method ' . $method_name . ' at ' . MyHelper::getDateNow();
            $user_id = $this->__user_id;
        }
        $create_logs = [
            'fraud_scan' => $fraud_scan,
            'ip_address' => MyHelper::getIp(),
            'browser' => json_encode(MyHelper::getBrowser()),
            'class' => $class_name,
            'method' => $method_name,
            'event' => $request->method(),
            'is_active' => 1,
            'created_by' => $user_id,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id,
            'updated_date' => date('Y-m-d H:i:s'),
        ];
        Tbl_d_logs::do_insert($create_logs);
    }

}
