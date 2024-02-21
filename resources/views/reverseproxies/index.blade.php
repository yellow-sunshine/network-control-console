@extends('layouts.layout')

@section('pageTitle')
Reverse Proxy Configuration Details
@endsection

@section('heading')
Reverse Proxy Configuration Details
@endsection

@section('content')
<div class="mt-16">
    <div class="row row-cols-1 row-cols-md-1 g-6">

        <div class="col mb-4">
            <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                    
                <div class="col mb-4">
                    <div class="bg-dark text-light p-4 rounded d-flex flex-column h-100">
                        <p>Search a domain name to view its reverse proxy configuration details.<p>
                        <ul class='text-gray-300 text-sm p-4 '>
                            <li>DNS should point to the reverse proxy server</li>
                            <li>Results are local routing, not public</li>
                        </ul>
                        <div class="input-group mb-3">
                            <input type="text" id='reverseProxyInput' style="margin-right: 10px;" class="form-control bg-dark text-light" placeholder="Example: www.daha.us" value="">
                            <div class="input-group-append">
                                <button class="btn btn-warning border-2 rounded-circle ml-2" type="button" id="reverseProxyBtn">
                                    <i class="fas fa-arrow-right text-white"></i>
                                </button>
                            </div>
                        </div>
                        <div id='reverseProxyResults' class=''></div>
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
        $('#reverseProxyBtn').click(submitReverseProxyFrm);
        $('#reverseProxyInput').keypress(function(event) {
            if (event.which === 13) { // 13 is the Enter key code
                submitReverseProxyFrm();
            }
        });

        function submitReverseProxyFrm(){
            var userDomainInput = $('#reverseProxyInput').val();
            window.location.href = '/reverseproxy/' + userDomainInput;
        };    
    });
</script>
@endsection