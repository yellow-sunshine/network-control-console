@extends('layouts.layout')

@section('pageTitle')
Daha.us Network Control Console
@endsection

@section('heading')
Network Control Console
@endsection

@section('content')

<div class="mt-16">
    <div class="row row-cols-1 row-cols-md-2 g-6">
        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                <div class='text-center'>
                    <h2 class="mt-2 text-xl font-semibold">
                        <i class="fa-solid fa-list" style="float: left;"></i>
                        <span class="text-start">Bind Zone Details</span>
                    </h2>
                </div>
                <p class="mt-3 text-sm">
                    Display A and CNAME records associated with a particular domain where ns1.dahau.us is the SOA.
                </p>
                <div class="input-group mb-3">
                    <input type="text" id='dnsZoneInput' style="margin-right: 10px;" class="form-control bg-dark text-light" placeholder="Enter a domain">
                    <div class="input-group-append">
                        <button class="btn btn-warning border-2 rounded-circle ml-2" type="button" id="dnsZoneBtn">
                            <i class="fas fa-arrow-right text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                <div class='text-center'>
                    <h2 class="mt-2 text-xl font-semibold"><i class="fa-brands fa-cloudflare" style="float: left;"></i> Cloudflare DDNS</h2>
                </div>
                <p class="mt-3 text-sm">
                    View recent Cloudflare DDNS IP updates and force new DNS updates.
                </p>
                <p class="text-center pt-4">
                    <button class="btn btn-warning border-2 text-white ml-2" type="button" id="cloudflareDdnsBtn">GO</button>
                </p>
            </div>
        </div>


        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                <div class='text-center'>
                    <h2 class="mt-2 text-xl font-semibold">
                        <i class="fa-solid fa-code-fork" style="float: left;"></i>
                        <span class="text-start">Reverse Proxy Resolution</span>
                    </h2>
                </div>
                <p class="mt-3 text-sm text-left">
                    Find infrastructure hosting a website which passes through the daha.us reverse proxy server.
                </p>
                <div class="input-group mb-3">
                    <input type="text" id='reverseProxyResolutionInput' style="margin-right: 10px;" class="form-control bg-dark text-light" placeholder="Enter a domain">
                    <div class="input-group-append">
                        <button class="btn btn-warning border-2 rounded-circle ml-2" type="button" id="reverseProxyResolutionBtn">
                            <i class="fas fa-arrow-right text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                <div class='text-center'>
                    <h2 class="mt-2 text-xl font-semibold"><i class="fa-solid fa-network-wired" style="float: left;"></i>DHCP Leases</h2>
                </div>
                <p class="mt-3 text-sm">
                    View current DHCP lease details within the daha.us network and show current VLAN and common DHCP.
                </p>
                <p class="text-center pt-4">
                    <button class="btn btn-warning border-2 text-white ml-2" type="button" id="dhcpDdnsBtn">GO</button>
                </p>
            </div>
        </div>


        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                <div class='text-center'>
                    <h2 class="mt-2 text-xl font-semibold"> <i class="fa-solid fa-eraser" style="float: left;"></i> Network Cache</h2>
                </div>
                <p class="mt-3 text-sm">
                    Clear various dahaus caches.
                </p>
                <div class="row mb-2">
                    <div class="col-md-12 col-lg-6">
                        <div class="card bg-dark text-light p-4 rounded shadow d-flex justify-content-center align-items-center">
                            <button class="btn btn-warning text-sm border-2 ml-2 text-white" id="flushBindDnsCacheBtn" type="button">
                            Flush Bind DNS cache
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card bg-dark text-light p-4 rounded shadow d-flex justify-content-center align-items-center">
                            <button class="btn btn-warning text-sm border-2 ml-2 text-white" id="flushNginxCacheBtn" type="button"">
                            Flush Nginx cache
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card bg-dark text-light p-4 rounded shadow d-flex justify-content-center align-items-center">
                            <button class="btn btn-danger text-sm border-2 ml-2" type="button" id="delPhpmemcacheKeysBtn">
                            Del Memcached keys
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row g-3">
    <?php
        $links = [
            ['title' => 'Venezia [user]', 'url' => 'https://venezia.daha.us'],
            ['title' => 'Roma [backup]', 'url' => 'https://roma.daha.us'],
            ['title' => 'Torino [surveillance]', 'url' => 'https://torino.daha.us'],
            ['title' => 'Milano [media]', 'url' => 'https://milano.daha.us'],
            ['title' => 'Ubiquity Gateway', 'url' => 'https://10.0.0.1'],
            ['title' => 'Validator Grafana', 'url' => 'http://grafana.daha.us:3100/'],
            ['title' => 'HL-2170W Printer', 'url' => 'http://10.50.0.48/printer/main.html'],
            ['title' => 'Plex', 'url' => 'http://milano.daha.us:32400'],
            ['title' => 'Synology Photos', 'url' => 'https://venenzia.daha.us:15001/?launchApp=SYNO.Foto.AppInstance&SynoToken=0rUbG7rmd9aGw#/personal_space/timeline'],
            ['title' => 'HL-2170W Printer', 'url' => 'http://10.50.0.48/printer/main.html'],
            ['title' => 'phpMyAdmin', 'url' => 'https://brentrussell.com/phpmyadmin/']
        ];
        foreach ($links as $link) {
            print '<div class="col col-md-3 col-sm-4 col-6">';
            print '<a href="' . $link['url'] . '" target="_blank">';
            print '<div class="p-3 bg-dark text-light rounded shadow">';
            print  $link['title'];
            print '</div>';
            print '</a>';
            print '</div>';
        }
    ?>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    function searchRoute(route, term='') {
        window.location.href = '/' + route + '/' + term;
    }

    $('#flushBindDnsCacheBtn').click(function (event) {
        var url = 'http://ns1.daha.us/flush-bind-dns';
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Check the status directly from the response
                if (response.error) {
                    showModalDialog('fail', 'Uh-oh!', response.error)
                } else {
                    showModalDialog('success', 'Oh Yeah!', response.message)
                }
            },
            error: function () {
                showModalDialog('fail', 'Uh-oh!', 'There was an unknown error flushing the DNS cache.')
            }
        });
    });

    $('#dnsZoneBtn').click(function(event) {
        searchRoute('dnszone', $('#dnsZoneInput').val());
    });
    $('#dnsZoneInput').keypress(function(event) {
        if (event.which === 13) { // 13 is the Enter key code
            searchRoute('dnszone', $('#dnsZoneInput').val());
        }
    });

    $('#reverseProxyResolutionBtn').click(function(event) {
        searchRoute('reverseproxy', $('#reverseProxyResolutionInput').val());
    });
    $('#reverseProxyResolutionInput').keypress(function(event) {
        if (event.which === 13) { // 13 is the Enter key code
            searchRoute('reverseproxy', $('#reverseProxyResolutionInput').val());
        }
    });

    $('#cloudflareDdnsBtn').click(function(event) {
        searchRoute('cloudflareddns', '');
    });

    $('#dhcpDdnsBtn').click(function(event) {
        searchRoute('dhcpd', '');
    });


    $('#cacheNginxBtn').click(function(event) {
        searchRoute('flush-nginx-cache', '');
    });

    $('#delPhpmemcacheKeysBtn').click(function(event) {
        searchRoute('delete-phpmemcache-keys', '');
    });

});
</script>
@endsection