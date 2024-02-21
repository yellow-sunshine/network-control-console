@extends('layouts.layout')

@section('heading')
<h2 class="mt-2 text-xl font-semibold">
    Reverse Proxy Configuration Details for {{ $domain }}
</h2>
@endsection

@section('content')
<div class="mt-16">
    <div class="row row-cols-1 row-cols-md-1 g-6">

        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                    
                <div class="col mb-4">
                    <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                        Search a domain name to view its reverse Proxy configuration details.<p>
                        <ul class='text-gray-300 text-sm p-4 '>
                            <li>DNS should point to the reverse proxy server</li>
                            <li>Results are local routing, not public</li>
                        </ul>
                        <div class="input-group mb-3">
                            <input type="text" id='reverseProxyInput' style="margin-right: 10px;" class="form-control bg-dark text-light" placeholder="Example: daha.us" value="{{ $domain }}">
                            <div class="input-group-append">
                                <button class="btn btn-warning border-2 rounded-circle ml-2" type="button" id="reverseProxyBtn">
                                    <i class="fas fa-arrow-right text-white"></i>
                                </button>
                            </div>
                        </div>
                        <div class="container">
                            <!-- Row 1: Traffic Images -->
                            <div class="row" id="trafficContainer">
                                <div class="col">
                                <img src='/img/1.png' width='32' height='32'>
                                <br />Cloudflare
                                </div>
                                <div class="col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="25" id="dotAnimation1">
                                    <!-- Grey dots -->
                                    <circle id="dot1-1" cx="10" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot2-1" cx="25" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot3-1" cx="40" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot4-1" cx="55" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot5-1" cx="70" cy="12.5" r="1.5" fill="#ccc" />
                                </svg>
                                </div>
                                <div class="col">
                                <img src='/img/2.png' width='32' height='32'>
                                <br />Switch
                                </div>
                                <div class="col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="25" id="dotAnimation2">
                                    <!-- Grey dots -->
                                    <circle id="dot1-2" cx="10" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot2-2" cx="25" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot3-2" cx="40" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot4-2" cx="55" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot5-2" cx="70" cy="12.5" r="1.5" fill="#ccc" />
                                </svg>
                                </div>
                                <div class="col">
                                <img src='/img/3.png' width='32' height='32'>
                                <br />Proxy
                                </div>
                                <div class="col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="25" id="dotAnimation3">
                                    <!-- Grey dots -->
                                    <circle id="dot1-3" cx="10" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot2-3" cx="25" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot3-3" cx="40" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot4-3" cx="55" cy="12.5" r="1.5" fill="#ccc" />
                                    <circle id="dot5-3" cx="70" cy="12.5" r="1.5" fill="#ccc" />
                                </svg>
                                </div>
                                <div class="col">
                                <img src='/img/4.png' width='32' height='32'>
                                <br /><span id='ipContainer'>{{ $domain }}</span>
                                </div>
                            </div>
                        </div>
                        <script>
                            function animateDots(groupId, colors) {
                                let dots = document.querySelectorAll(`#${groupId} circle`);
                                function animateDot(index) {
                                    dots[index].setAttribute('fill', colors[0]);
                                    setTimeout(() => {
                                        dots[index].setAttribute('fill', colors[1]);
                                        if (index < dots.length - 1) {
                                            animateDot(index + 1);
                                        } else {
                                            reverseAnimateDot(dots.length - 2);
                                        }
                                    }, 100);
                                }
                                function reverseAnimateDot(index) {
                                    dots[index].setAttribute('fill', colors[0]);
                                    setTimeout(() => {
                                        dots[index].setAttribute('fill', colors[2]);
                                        if (index > 0) {
                                            reverseAnimateDot(index - 1);
                                        } else {
                                            animateDot(1);
                                        }
                                    }, 100);
                                }
                                animateDot(1);
                            }
                            animateDots('dotAnimation1', ["#2ecc71", "#3498db", "#3498db"]);
                            animateDots('dotAnimation2', ["#2ecc71", "#3498db", "#3498db"]);
                            animateDots('dotAnimation3', ["#2ecc71", "#3498db", "#3498db"]);
                        </script>
                        <div id='reverseProxyResults' class=''>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>
@endsection



@section('scripts')
<script>
    $(document).ready(function(){
        $('#reverseProxyBtn').click(submitReversePRoxyFrm);
        $('#reverseProxyInput').keypress(function(event) {
            if (event.which === 13) { // 13 is the Enter key code
                submitReversePRoxyFrm();
            }
        });
        function submitReversePRoxyFrm(){
            var userDomainInput = $('#reverseProxyInput').val();
            window.location.href = '/reverseproxy/' + userDomainInput;
        };
        var userDomainInput = $('#reverseProxyInput').val();
        if(!userDomainInput){
            $('#reverseProxyResults').html('<div class="alert alert-danger">Please enter a domain name</div>');
        } else {
            var url = 'http://reverseproxy.daha.us:8080/reverse-proxy-resolution/' + userDomainInput;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Clear previous results
                    $('#reverseProxyResults').empty();
                    // Create lists
                    var locationList = $('<div>').addClass('list-group');
                    var serverNameList = $('<div>').addClass('list-group');
                    var headersList = $('<div>').addClass('list-group');
                    var modificationDateList = $('<div>').addClass('list-group');
                    // Add Location details to the list
                    var locationDetails = response.message[0].location;
                    locationList.append('<h4 class="mt-4">Proxy Settings:</h4>');
                    locationList.append(createLocationItem('Proxy Pass', locationDetails.proxy_pass));
                    // Regular expression to match IP addresses in different formats
                    var ipAddressRegex = /^(https?:\/\/)?([\d.]+)(:\d+)?$/;
                    // Extracting the IP address
                    var match = locationDetails.proxy_pass.match(ipAddressRegex);
                    if (match) {
                        var ipAddress = match[2];
                        $('#ipContainer').html(ipAddress);
                    } else {
                        var ipAddress = locationDetails.proxy_pass;
                    }
                    locationList.append(createLocationItem('Proxy No Cache', locationDetails.proxy_no_cache));
                    locationList.append(createLocationItem('Proxy Cache Bypass', locationDetails.proxy_cache_bypass));
                    locationList.append(createLocationItem('Proxy Cache Bypass', locationDetails.proxy_cache_bypass));

                    // Add Server Name details to the list
                    var headersDetails = response.message[0].location.proxy_set_headers;
                    headersList.append('<h4 class="mt-4">Headers Added:</h4>');
                    $.each(headersDetails, function(index, header) {
                        headersList.append(createListItem('proxy_set_headers: ' + header));
                    });

                    // Add Server Name details to the list
                    var serverNameDetails = response.message[0].server_name;
                    serverNameList.append('<h4 class="mt-4">Proxying for:</h4>');
                    $.each(serverNameDetails, function(index, serverName) {
                        serverNameList.append(createListItem(serverName));
                    });


                    // Add Modification Date to the list
                    var responseModificationDate = new Date(response.message[0].modification_date);
                    var options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' };
                    var formattedDate = responseModificationDate.toLocaleDateString('en-US', options);
                    modificationDateList.append('<h4 class="mt-4">Last Modification Date:</h4>');
                    modificationDateList.append(createListItem('Last Modified: ' + formattedDate));
                    // Append lists to the container
                    $('#reverseProxyResults').append(locationList);
                    $('#reverseProxyResults').append(headersList);
                    $('#reverseProxyResults').append(serverNameList);
                    $('#reverseProxyResults').append(modificationDateList);
                },
                error: function(){
                    $('#trafficContainer').hide();
                    $('#reverseProxyResults').html('<div class="alert alert-danger"><span class="text-xl font-semibold">{{ $domain }} Not Found</span> ' +
                                                    '<ul class="p-4">' + 
                                                        '<span class="underline">Reasons why may include:</span>' + 
                                                        '<li>Domain spelling is incorrect</li>' + 
                                                        '<li>Domain is an alias, you should search the primary domain if known</li>' + 
                                                        '<li>This domain is not configured on this proxy server</ul>' + 
                                                    '</div>');
                }
            });
        }
        // Helper function to create a list item
        function createListItem(content) {
            return $('<div>').addClass('list-group-item bg-dark text-light custom-border').html(content);
        }
        // Helper function to create a location item
        function createLocationItem(label, value) {
            return $('<div>').addClass('list-group-item bg-dark text-light custom-border').html('<span>' + label + ': ' + value + '</span>');
        }
    });
</script>
@endsection




