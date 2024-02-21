<?php
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Http;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('pageTitle')</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Get Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Get main page style -->
        <link href="/css/main.css" rel="stylesheet" />

        <!-- Get Fontawesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="antialiased">

        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-lighter bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex flex-col items-center"> 
                    <a href='/' rel='home'><img src='/img/home7.png' alt='Daha.us Home'></a>
                    <div class="text-gray-900 dark:text-white mt-2">
                        <h1>@yield('heading')</h1>
                    </div>
                </div>
                @yield('content')
                <div class="container">
                    <div class="row pt-4">
                        <div class="row pt-4">
                            <div class='text-center text-light'>Additional Details</div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-md-3 p-1">
                                <div class="info-box">
                                    <div class="label-box">Time loaded</div>
                                    <div id='timeLoaded' class="content-box"></div>
                                </div>
                            </div>

                            <div class="col-md-3 p-1">
                                <div class="info-box">
                                    <div class="label-box">Page Speed</div>
                                    <div class="content-box"><?php echo round(microtime(true) - LARAVEL_START, 3); ?> seconds</div>
                                </div>
                            </div>

                            <div class="col-md-3 p-1">
                                <div class="info-box">
                                    <div class="label-box">Visitor IP</div>
                                    <div class="content-box"><?php print Request::ip(); ?></div>
                                </div>
                            </div>

                            <div class="col-md-3 p-1">
                                <div class="info-box">
                                    <div class="label-box">Server External IP</div>
                                    <?php
                                        $response = Http::get('https://api64.ipify.org?format=json');
                                        $ip = $response->json();
                                    ?>
                                    <div class="content-box"><?php print $ip['ip']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Response Modal -->
        <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document"> 
                <div class="modal-content"> 
                    <div class="modal-body text-center p-lg-4"> 
                        <span>
                            <svg id='responseModalSvg' version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            </svg> 
                        </span>
                        <h2 id='responseModalTitle' class="text-xl font-semibold mt-3"></h2> 
                        <p id='responseModalMessage' class="mt-3" id="modalBody"></p>
                        <button id='responseModalBtn' type="button" class="btn btn-sm mt-3 border border-2" data-bs-dismiss="modal">Ok</button> 
                    </div> 
                </div> 
            </div> 
        </div>
        <!--End Response Modal -->

        <!-- Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 

        <!-- Page Scripts -->
        <script>
        // Show a modal dialog with a message
        function showModalDialog(type, title, message) {
            if(type === 'success'){
                var responseIcon = '<circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />' + 
                                        '<polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />';
                var colorClass = 'text-success';
            }else if(type === 'process'){
                var responseIcon = '<circle cx="50" cy="50" fill="none" stroke="#444" stroke-width="6" r="40" stroke-dasharray="188.49555921538757 64.83185307179586">' +
                                    '<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.7692307692307693s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform></circle>' +
                                    '<circle cx="50" cy="50" fill="none" stroke="#444" stroke-width="6" r="30" stroke-dasharray="94.24777960769378 31.41592653589793">' +
                                    '<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.7692307692307693s" keyTimes="0;1" values="0 50 50;-360 50 50"></animateTransform></circle>';
                var colorClass = 'text-dark';
            }else{
                var responseIcon = '<circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" /> ' +
                                        '<line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />' + 
                                        '<line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" X2="34.4" y2="92.2" /> ';
                var colorClass = 'text-danger';
            }
            $('#responseModalSvg').html(responseIcon);
            $('#responseModalTitle').html(title);
            $('#responseModalTitle').addClass(colorClass);
            $('#responseModalMessage').html(message);
            $('#resultModal').modal('show');
        }

        $(document).ready(function(){
                // Get the browsers time for page loaded time data
            var currentTime = new Date();
            var formattedTime = currentTime.toLocaleString();
            $('#timeLoaded').html(formattedTime);
        });
        </script>
        @yield('scripts')
        <!-- End Page Scripts -->
    </body>
</html>