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
                        <p class="text-center pt-4">
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
                    console.log(lease);
                       // Skip IP addresses with "N/A"
                    if (!lease.ip) {
                        return;
                    }

                    // Create a container for each IP
                    var ipContainer = $('<div>').addClass('ip-container');
                    
                    // Add IP address as heading with click event
                    var ipHeading = $('<h4>').addClass('ip-heading clickable').html('<span class="expand-icon">+</span> ' + lease.ip).click(function () {
                        var details = $(this).next('.lease-details');
                        details.slideToggle();
                        var expandIcon = $(this).find('.expand-icon');
                        expandIcon.text(expandIcon.text() === '+' ? '-' : '+');
                    });

                    ipContainer.append(ipHeading);

                    // Create a list for lease details
                    var leaseDetailsList = $('<ul>').addClass('list-group lease-details').hide(); // Hide details by default

                    // Add lease details to the list
                    leaseDetailsList.append(createLeaseDetailListItem('Starts', lease.starts));
                    leaseDetailsList.append(createLeaseDetailListItem('Ends', lease.ends));
                    leaseDetailsList.append(createLeaseDetailListItem('TSTP', lease.tstp));
                    leaseDetailsList.append(createLeaseDetailListItem('CLTT', lease.cltt));
                    leaseDetailsList.append(createLeaseDetailListItem('MAC', lease.mac));
                    leaseDetailsList.append(createLeaseDetailListItem('Vendor Class Identifier', lease['vendor-class-identifier'] || 'N/A'));

                    // Append lease details to the container
                    ipContainer.append(leaseDetailsList);

                    // Append the container to the results
                    $('#results').append(ipContainer);
                });
            }
        },
        error: function () {
            showModalDialog('fail', 'Uh-oh!', 'There was an unknown error getting DHCP leases data.');
        }
    });
}


// Helper function to create a list item for lease details
function createLeaseDetailListItem(label, value) {
    // Replace numeric status with descriptive term
    if (label === 'Starts' || label === 'Ends' || label === 'TSTP' || label === 'CLTT') {
        if (value !== null && value !== undefined) {
            var parts = value.split(' ');
            var status = parts[0]; // Extract the numeric status from the value
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
    return $('<li>').addClass('list-group-item d-flex justify-content-between align-items-center bg-dark text-light custom-border')
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
    .clickable {
        cursor: pointer;
        text-decoration: none;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
    }

    .expand-icon {
        margin-right: 0.5rem;
    }

    .ip-container {
        background-color: #2e3338; /* Set background color to dark */
        color: #ffffff; /* Set text color to light */
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px; /* Optional: Add border-radius for rounded corners */
    }
    .list-group-item{
        border-radius: 5px !important;
    }
    .ip-heading {
        margin: 0;
    }
</style>


@endsection