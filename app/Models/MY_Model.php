<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
