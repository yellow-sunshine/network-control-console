<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloudflareDdnsController extends Controller
{
    public function index(){
        return view('cloudflareddns.index');
    }
}
