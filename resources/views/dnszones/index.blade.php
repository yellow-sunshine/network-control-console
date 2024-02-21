@extends('layouts.layout')

@section('heading')
Bind Zone Details
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
                            <input type="text" id='dnsZoneInput' style="margin-right: 10px;" class="form-control bg-dark text-light" placeholder="Example: daha.us" value="">
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
    });
</script>
@endsection