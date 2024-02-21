<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DhcpdController extends Controller
{
    public function index(){
        return view('dhcpd.index');
    }
}
