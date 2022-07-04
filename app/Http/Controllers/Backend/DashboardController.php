<?php

namespace App\Http\Controllers\Backend;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
/**
 * Description of DefaultController
 *
 * @author I00396.ARIF
 */
use Illuminate\Http\Request;

/**
 * Description of Dashboard
 *
 * @author I00396.ARIF
 */
class DashboardController extends Controller {

    //put your code here
    public function index(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout'));
    }

    public function preference(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout'));
    }

    public function widget(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout'));
    }

}
