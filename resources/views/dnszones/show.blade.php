@extends('layouts.layout')

@section('heading')
<h2 class="mt-2 text-xl font-semibold">
    {{ $domain }} Zone Details
</h2>
@endsection

@section('content')
<div class="mt-16">
    <div class="row row-cols-1 row-cols-md-1 g-6">

        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                    
                <div class="col mb-4">
                    <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                        <p>Search a domain name to view its DNS records.<p>
                        <ul class='text-gray-300 text-sm p-4 '>
                            <li>SOA should be at ns1.daha.us</li>
                            <li>MX and txt records are not returned</li>
                            <li>Results are local DNS, not public</li>
                        </ul>
                        <div class="input-group mb-3">
                            <input type="text" id='dnsZoneInput' style="margin-right: 10px;" class="form-control bg-dark text-light" placeholder="Example: daha.us" value="{{ $domain }}">
                            <div class="input-group-append">
                                <button class="btn btn-warning border-2 rounded-circle ml-2" type="button" id="dnsZoneBtn">
                                    <i class="fas fa-arrow-right text-white"></i>
                                </button>
                            </div>
                        </div>
                        <div id='dnsZoneResults' class=''>
                            
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
        $('#dnsZoneBtn').click(submitDnsZoneFrm);
        $('#dnsZoneInput').keypress(function(event) {
            if (event.which === 13) { // 13 is the Enter key code
                submitDnsZoneFrm();
            }
        });

        function submitDnsZoneFrm(){
            var userDomainInput = $('#dnsZoneInput').val();
            window.location.href = '/dnszone/' + userDomainInput;
        };
        var userDomainInput = $('#dnsZoneInput').val();
        if(!userDomainInput){
            $('#dnsZoneResults').html('<div class="alert alert-danger">Please enter a domain name</div>');
        } else {
            var url = '{{ $dnsDchpdApiUrl }}/zone-details/' + userDomainInput;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response){
                    // Clear previous results
                    $('#dnsZoneResults').empty();
                    // Create lists
                    var aRecordsList = $('<div>').addClass('list-group');
                    var cnamesList = $('<div>').addClass('list-group');
                    var domainInfoList = $('<div>').addClass('list-group');

                    // Add A Records to the list
                    $.each(response.message.aRecords, function(index, record){
                        // a dot to the front of the domain so it includes the dot aft
                        var subdomainForLink = record.name && record.name !== '@' ? record.name + '.' : '';
                        var listItem = $('<div>').addClass('list-group-item list-group-item d-flex justify-content-between align-items-center bg-dark text-light custom-border').html(
                                                            '<span>' + record.name + ': ' + record.ip + '</span>' +
                                                            '<a href="//' + subdomainForLink + response.message.domain + '" target="_blank"><i class="text-sm fas fa-external-link-alt"></i></a>'
                                                            );
                        aRecordsList.append(listItem);
                    });

                    // Add CNAME Records to the list
                    $.each(response.message.cnames, function(index, record){
                        var subdomainForLink = record.name && record.name !== '@' ? record.name + '.' : '';
                        var listItem = $('<div>').addClass('list-group-item').text(record.name + ': ' + record.alias);
                        var listItem = $('<div>').addClass('list-group-item d-flex justify-content-between align-items-center bg-dark text-light custom-border').html(
                                                            '<span>' + record.name + ': ' + record.alias + '</span>' +
                                                            '<a href="//' + subdomainForLink + response.message.domain + '" target="_blank"><i class="text-sm fas fa-external-link-alt"></i></a>'
                                                            );
                        cnamesList.append(listItem);
                    });

                    // Add Domain Info to the list
                    //var domainInfoItem = $('<li>').addClass('list-group-item').text('Domain: ' + response.message.domain);
                    var domainInfoItem = $('<div>').addClass('list-group-item d-flex justify-content-between align-items-center bg-dark text-light custom-border').html(
                                                            '<span><a href="//' + response.message.domain + '" target="_blank"><u>' + response.message.domain  + '</u> <i class="text-sm fas fa-external-link-alt"></i></a></span>' 
                                                            );
                    domainInfoList.append(domainInfoItem);

                    var responseModificationDate = new Date(response.message.modificationDate);
                    var options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' };
                    var formattedDate = responseModificationDate.toLocaleDateString('en-US', options);

                    var modificationDateItem = $('<div>').addClass('list-group-item bg-dark text-light custom-border').text('Last Modified: ' + formattedDate);
                    domainInfoList.append(modificationDateItem);

                    // Append lists to the container
                    $('#dnsZoneResults').append('<h4>Domain Information:</h4>').append(domainInfoList);
                    $('#dnsZoneResults').append('<h4 class="mt-4">A Records:</h4>').append(aRecordsList);
                    $('#dnsZoneResults').append('<h4 class="mt-4">CNAME Records:</h4>').append(cnamesList);
                },
                error: function(){
                    $('#dnsZoneResults').html('<div class="alert alert-danger">Failed to retrieve details for the zone</div>');
                }
            });
        }
    });
</script>
@endsection