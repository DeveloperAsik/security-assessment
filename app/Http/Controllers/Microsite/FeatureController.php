<?php

namespace App\Http\Controllers\Frontend;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
/**
 * Description of UserController
 *
 * @author I00396.ARIF
 */
use Illuminate\Http\Request;

class FeatureController extends Controller {

    //put your code here
    public function index(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $listFeature = [
            [
                'title' => 'Convert Photos into ASCII',
                'link' => '/feature/image-to-ascii'
            ],
        ];
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout', 'listFeature'));
    }

    public function image_to_ascii(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout'));
    }

}
