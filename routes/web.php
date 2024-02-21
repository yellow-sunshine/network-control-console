<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dnszone', 'DnsZoneController@index');
Route::get('/dnszone/{domain}', 'DnsZoneController@show');

Route::get('/reverseproxy', 'ReverseProxyController@index');
Route::get('/reverseproxy/{domain}', 'ReverseProxyController@show');

Route::get('/cloudflareddns', 'CloudflareDdnsController@index');
Route::get('/cloudflareddns/run', 'CloudflareDdnsController@run');

Route::get('/dhcpd', 'DhcpdController@index');