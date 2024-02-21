<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReverseProxyController extends Controller
{
    public function index(){
        return view('reverseproxies.index');
    }

    public function show($domain){
        return view('reverseproxies.show', ['domain' => $domain]);
    }
}
