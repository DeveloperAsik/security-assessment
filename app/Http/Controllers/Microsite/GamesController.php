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

class GamesController extends Controller {

    //put your code here
    public function index(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $listGames = [
            [
                'title' => 'Game Ordered Number',
                'link' => '/games/ordered-numbers'
            ],
            [
                'title' => 'Game Matching Photos',
                'link' => '/games/matching-photos'
            ],
            [
                'title' => 'Game Pingpong',
                'link' => '/games/pingpong'
            ],
            [
                'title' => 'Game Sanke',
                'link' => '/games/snake'
            ],
            [
                'title' => 'Game Flappy Bird',
                'link' => '/games/flapy-bird'
            ],
        ];
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout','listGames'));
    }

    public function orderd_numbered(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout'));
    }

    public function matching_photos(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout'));
    }

    public function pingpong(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout'));
    }

    public function snake(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout'));
    }

    public function flapy_bird(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        return view('Public_html.Layouts.Adminlte.home', compact('title_for_layout'));
    }

}
