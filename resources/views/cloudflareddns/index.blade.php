@extends('layouts.layout')

@section('heading')
Cloudflare DDNS Console
@endsection

@section('content')
<div class="mt-16">
    <div class="row row-cols-1 row-cols-md-1 g-6">

        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                    
                <div class="col mb-4">
                    <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                        <p>Use various tools to remotely manage CloudflareDDNS for domains hosted on the daha.us Network<p>
                        <p class="text-center pt-4">
                            <button class="btn btn-warning border-2 text-white ml-4 mt-2" type="button" id="viewBtn">View Recent IP Changes</button>
                            <button class="btn btn-warning border-2 text-white ml-4 mt-2" type="button" id="runBtn">Run Cloudflare DDNS now</button>
                            <button class="btn btn-warning border-2 text-white ml-4 mt-2" type="button" id="forceBtn">Force DNS update</button>
                        </p>

                        <div id='cloudflareDdnsResults' class=''>
                            
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
    $('#viewBtn').click(function (event) {
        var url = '{{ $dnsDchpdApiUrl }}/cloudflare-ddns';
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Check the status directly from the response
                if (response.error) {
                    showModalDialog('fail', 'Uh-oh!', response.error)
                } else {
                    var ipDetails = response.message;

                    // Clear previous results
                    $('#cloudflareDdnsResults').empty();

                    // Create lists
                    var ddnsInfoList = $('<div>').addClass('list-group');
                    var lastIpsList = $('<div>').addClass('list-group');

                    // Add Date and Current IP to the list
                    var formattedDate = new Date(ipDetails.date).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZoneName: 'short'
                    });
                    var currentIpListItem = $('<div>').addClass('list-group-item d-flex justify-content-between align-items-center bg-dark text-light custom-border')
                        .html('<span>DNS updated to <span class="font-semibold">' + ipDetails.currentip + '</span> on ' + formattedDate + '</span>');
                    ddnsInfoList.append(currentIpListItem);

                    // Add Last IPs to the list
                    for (var i = 1; i <= 4; i++) {
                        var lastIpKey = 'lastip' + i;
                        var lastIpValue = ipDetails[lastIpKey];
                        var lastIpListItem = $('<div>').addClass('list-group-item d-flex justify-content-between align-items-center bg-dark text-light custom-border')
                            .html('<span>' + i + ': ' + lastIpValue + '</span>');
                        lastIpsList.append(lastIpListItem);
                    }
                    // Append lists to the container
                    $('#cloudflareDdnsResults').append('<h4 class="mt-4">Last Update:</h4>').append(ddnsInfoList);
                    $('#cloudflareDdnsResults').append('<h4 class="mt-4">Previous IPs:</h4>').append(lastIpsList);
                }
            },
            error: function () {
                showModalDialog('fail', 'Uh-oh!', 'There was an unknown error getting Cloudflare DDNS data.')
            }
        });
    });


    $('#runBtn, #forceBtn').click(function (event) {
        showModalDialog('process', 'Processing', 'Running Cloudflare DDNS, please wait...');

        // Check which button was clicked
        var url = (event.target.id === 'forceBtn') ? '{{ $dnsDchpdApiUrl }}/cloudflare-ddns/run/force' : '{{ $dnsDchpdApiUrl }}/cloudflare-ddns/run';

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                // This code will run before the request is sent
                // You can perform any necessary actions here
            },
            success: function (response) {
                // Check the status directly from the response
                if (response.error) {
                    showModalDialog('fail', 'Uh-oh!', response.error);
                } else {
                    showModalDialog('success', 'Oh Yeah!', response.message + '<br />' + response.output);
                }
            },
            error: function () {
                showModalDialog('fail', 'Uh-oh!', 'There was an unknown error running Cloudflare DDNS.');
            },
            complete: function () {
                // This code will run after success or error
                // You can perform any necessary actions here
                $('#resultModal').modal('hide');
            }
        });
    });





    });
</script>
@endsection