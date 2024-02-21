<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DnsZoneController extends Controller
{
    public function index(){
        return view('dnszones.index');
    }

    public function show($domain){
        return view('dnszones.show', ['domain' => $domain]);
    }
}
