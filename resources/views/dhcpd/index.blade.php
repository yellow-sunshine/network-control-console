@extends('layouts.layout')

@section('heading')
DHCP Leases
@endsection

@section('content')
<div class="mt-16">
    <div class="row row-cols-1 row-cols-md-1 g-6">

        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                    
                <div class="col mb-4">
                    <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                        <p>View current and recently expired dhcp leases and its details<p>
                        <p>Note: This does not include DHCP reservations<p>
                        <p class="text-center pt-4 mb-4">
                            <button class="btn btn-warning border-2 text-white ml-4 mt-2" type="button" id="refreshBtn">Refresh</button>
                        </p>

                        <div id='results' class=''>
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

// Get DHCP Leases
function getDhcpdLeases() {
    var url = '{{ $dnsDchpdApiUrl }}/dhcpd';
    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            // Check the status directly from the response
            if (response.error) {
                showModalDialog('fail', 'Uh-oh!', response.error);
            } else {
                var leases = response.leases;
                // Clear previous results
                $('#results').empty();
                // Loop over leases and add details for each IP
                leases.forEach(function (lease, index) {
                    // Skip IP addresses with "N/A"
                    if (!lease.ip) {
                        return;
                    }
                    // Create a container for each IP
                    var ipContainer = $('<div>').addClass('ip-container');
                    
                    // Add IP address as heading with click event and + and - toggle icons
                    var ipHeading = $('<h4>').addClass('ip-heading clickable').html('<span class="expand-icon">+</span> ' + lease.ip).click(function () {
                        var details = $(this).next('.lease-details');
                        details.slideToggle();
                        var expandIcon = $(this).find('.expand-icon');
                        expandIcon.text(expandIcon.text() === '+' ? '-' : '+');
                    });
                    // Put the IP heading in the container
                    ipContainer.append(ipHeading);
                    // Create a list for lease details adn hide it by default as it should be expanded by clicking the IP heading
                    var leaseDetailsList = $('<ul>').addClass('list-group lease-details').hide();
                    // Add lease details to the list
                    leaseDetailsList.append(createLeaseDetailListItem('Starts', lease.starts));
                    leaseDetailsList.append(createLeaseDetailListItem('Ends', lease.ends));
                    leaseDetailsList.append(createLeaseDetailListItem('TSTP', lease.tstp));
                    leaseDetailsList.append(createLeaseDetailListItem('CLTT', lease.cltt));
                    leaseDetailsList.append(createLeaseDetailListItem('MAC', lease.mac));
                    leaseDetailsList.append(createLeaseDetailListItem('Vendor Class Identifier', lease['vendor-class-identifier'] || 'N/A'));
                    // Append lease details to the ip container
                    ipContainer.append(leaseDetailsList);
                    // Now stuff it into the results div
                    $('#results').append(ipContainer);
                });
            }
        },
        error: function () {
            showModalDialog('fail', 'Uh-oh!', 'There was an unknown error getting DHCP leases data.');
        }
    });
}


function createLeaseDetailListItem(label, value) {
    // Only look for items in the array that have statuses on them and ignore if it is null or undefined
    if (label === 'Starts' || label === 'Ends' || label === 'TSTP' || label === 'CLTT') {
        if (value !== null && value !== undefined) {
            // Split it up and add the state to the front of the value
            var parts = value.split(' ');
            var status = parts[0]; 
            switch (status) {
                case '0':
                    value = 'Active ' + parts.slice(1).join(' ');
                    break;
                case '1':
                    value = 'Renewing ' + parts.slice(1).join(' ');
                    break;
                case '2':
                    value = 'Rebinding ' + parts.slice(1).join(' ');
                    break;
                case '3':
                    value = 'Inactive ' + parts.slice(1).join(' ');
                    break;
                case '6':
                    value = 'Released ' + parts.slice(1).join(' ');
                    break;
                case '5':
                    value = 'Abandoned ' + parts.slice(1).join(' ');
                    break;
                default:
                    break;
            }
        }
    }
    return $('<li>').addClass('list-group-item d-flex justify-content-between align-items-center')
        .html('<span>' + label + ': ' + (value || 'N/A') + '</span>');
}


$(document).ready(function(){
    // Get the initial data
    getDhcpdLeases();
});

$('#refreshBtn').click(function (event) {
    getDhcpdLeases();
});
</script>

// CSS for the clickable style and expand icon
<style>
    .list-group-item{
        border-radius: 5px !important;
        background-color: #222 !important;
        margin: 1px 0 !important;
        border: 0px !important;
        font-size: 0.9em;
        color: #ccc;
    }
</style>


@endsection