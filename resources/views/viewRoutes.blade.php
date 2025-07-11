<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Milky - Dairy Hauling</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('images/carousel-1.jpg') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row g-0 d-none d-lg-flex">
            <div class="col-lg-6 ps-5 text-start">
                <div class="h-100 d-inline-flex align-items-center text-light">
                    <span>Follow Us:</span>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-6 text-end">
                <div class="h-100 bg-secondary d-inline-flex align-items-center text-dark py-2 px-4">
                    <span class="me-2 fw-semi-bold"><i class="fa fa-phone-alt me-2"></i>Call Us:</span>
                    <span>+012 345 6789</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <div class=" container my-3">
        <div class="text-center">
            <h5>Track Your Progress Here</h5>
            <p>Here are the details how you will go and collect milk from different Farms</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bi bi-truck me-2"></i>
                                Delivery Route
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <!-- User Location Section -->
                            <div class="alert alert-info border-0 shadow-sm mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill text-info me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Your Current Location</h6>
                                        <p id="userLocation" class="text-muted">Loading...</p>
                                    </div>
                                </div>
                            </div>

                            {{ $found = false }}

                            @foreach ($farmsInRoute as $index => $farm)
                            <div class="d-none">
                                {{ $found = true }}
                            </div>
                            @php
                            $lat1 = $farm->latitude;
                            $long1 = $farm->longitude;
                            session()->put('lat1',$lat1);
                            session()->put('long1',$long1);
                            @endphp
                            <!-- Route Stop Card -->
                            <div class="card border-0 shadow-sm mb-4 position-relative overflow-hidden">
                                <!-- Stop Number Badge -->
                                <div class="position-absolute top-0 start-0 bg-success text-white px-3 py-1 rounded-end">
                                    <small class="fw-bold">Stop {{ $index + 1 }}</small>
                                </div>

                                <div class="card-body pt-5">
                                    <!-- Farm Name -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle p-2 me-3">
                                            <i class="bi bi-arrow-right text-white"></i>
                                        </div>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $farm->fname }}</h5>
                                    </div>

                                    <!-- Location Display -->
                                    <div class="bg-light rounded p-3 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-geo-alt text-primary me-2 mt-1"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-2 text-primary fw-semibold">Farm Location</h6>
                                                <div class="bg-dark text-white p-3 rounded">
                                                    <span id="location-{{ $index }}" class="small">
                                                        <i class="bi bi-hourglass-split me-2"></i>Loading address...
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ dd($ticketID); }} --}}
                                    <!-- Action Button -->
                                    <div class="d-grid">
                                        <a class="btn btn-success btn-lg shadow-sm" href="{{ route('view.farm.stop',['id' => $farm->farmid, 'ticketID' => $ticketID]) }}">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Add Farm Stop
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Route Connector (except for last item) -->
                            @if (!$loop->last)
                            <div class="text-center mb-4">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-primary" style="width: 3px; height: 30px;"></div>
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                        <i class="bi bi-arrow-down text-white" style="font-size: 10px;"></i>
                                    </div>
                                    <div class="bg-primary" style="width: 3px; height: 30px;"></div>
                                </div>
                            </div>
                            @endif
                            <input type="hidden" value="{{ $farm->farmid }}" id="farmid">
                            <!-- Hidden inputs for coordinates -->
                            <input type="hidden" id="lat-{{ $index }}" value="{{ $farm->latitude }}">
                            <input type="hidden" id="long-{{ $index }}" value="{{ $farm->longitude }}">

                            <!-- Location fetching script -->
                            <script>
                                (function() {
                                    const locationElement = document.getElementById("location-{{ $index }}");
                                    const lat = document.getElementById("lat-{{ $index }}").value;
                                    const lon = document.getElementById("long-{{ $index }}").value;

                                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            locationElement.innerHTML = `<i class="bi bi-check-circle me-2"></i>${data.display_name}`;
                                            // console.log(data.display_name);
                                        })
                                        .catch(err => {
                                            locationElement.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>Location not found`;
                                            locationElement.parentElement.classList.remove('bg-dark');
                                            locationElement.parentElement.classList.add('bg-danger');
                                        });
                                })();
                            </script>
                           
                                
                           @endforeach
                           {{-- @if($tickets->platitude != null) --}}
                            @php
                            $lat2 = $tickets->platitude;
                            $long2 = $tickets->plongitude;
                            $lat1 = session('lat1');
                            $long1 = session('long1');

                            function distanceBtw($lat1, $lon1, $lat2, $lon2) {
                            $R = 6371; // Earth's radius in km

                            $lat1 = deg2rad($lat1);
                            $lon1 = deg2rad($lon1);
                            $lat2 = deg2rad($lat2);
                            $lon2 = deg2rad($lon2);

                            $dlat = $lat2 - $lat1;
                            $dlon = $lon2 - $lon1;

                            $a = sin($dlat / 2) * sin($dlat / 2) +
                            cos($lat1) * cos($lat2) *
                            sin($dlon / 2) * sin($dlon / 2);

                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                            return $R * $c;
                            }

                            $speed = 70;
                            $distance = distanceBtw($lat1, $long1, $lat2, $long2); // km

                            $timeInHours = $distance / $speed;
                            $totalSeconds = $timeInHours * 3600;

                            $hours = floor($totalSeconds / 3600);
                            $minutes = floor(($totalSeconds % 3600) / 60);
                            $seconds = floor($totalSeconds % 60);

                            $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

                            session()->put('arrivalTime', $formattedTime);

                            @endphp
                            {{-- @endif --}}

                            <!-- No Route Message -->
                            @if (!$found)
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 4rem;"></i>
                                </div>
                                <div class="alert alert-warning border-0 shadow-sm">
                                    <h5 class="alert-heading mb-2">No Route Defined</h5>
                                    {{-- <p class="mb-0">Please define a delivery route to get started.</p> --}}
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- <div class="card-footer bg-light border-0 text-center" id="plantReading">
            <a class="btn btn-outline-success btn-lg px-5" href="{{ route('view.scaleAtPlant',$ticketID) }}">
                        <i class="bi bi-check-circle me-2"></i>
                        Add Reading At Plant
                        </a>
                    </div> --}}
                    <div>
                        <h6>Your Estimated Arrival Time at Plant should be: {{session('arrivalTime')}}</h6>
                        <div class="card-footer bg-light border-0 text-center">
                            <a class="btn btn-outline-success btn-lg px-5 " onclick="showAlert()" href="{{ route('destinationPlant',['ticketID' => $ticketID, 'routeID' =>$tickets->rid ]) }}">
                                <i class="bi bi-check-circle me-2"></i>
                                Close Route
                            </a>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    {{-- <div class="card-footer bg-light border-0 text-center">
            <a class="btn btn-outline-success btn-lg px-5" href="{{ route('close.route',$ticketID) }}">
                    <i class="bi bi-check-circle me-2"></i>
                    Close Route
                    </a>
                </div> --}}
            </div>
        </div>
        <div class="col-lg-6 border rounded shadow-lg p-4">
            <h5 class="text-center">Ticket Details</h5>

            <h6>Ticket Number: </h6>
            <p>{{$tickets->ticket_number}}</p>
            <h6>Hauler Name: </h6>
            <p>{{$tickets->hname}}</p>
            <h6>Shipment Number:</h6>
            <p>{{$tickets->shipp_number}}</p>
            <h6>Truck:</h6>
            <p>{{$tickets->truckID}}</p>
            <h6>Trailer:</h6>
            <p>{{$tickets->trailerID}}</p>
            <h6>Total Capacity</h6>
            <p>{{$tickets->capacity}} lbs</p>

        </div>
    </div>
    </div>


    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Our Office</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Street 132, Lahore Pakistan</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+92 303 7249933</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>milk.hauling@company.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Business Hours</h5>
                    <p class="mb-1">Monday - Friday</p>
                    <h6 class="text-light">09:00 am - 07:00 pm</h6>
                    <p class="mb-1">Saturday</p>
                    <h6 class="text-light">09:00 am - 12:00 pm</h6>
                    <p class="mb-1">Sunday</p>
                    <h6 class="text-light">Closed</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p>Subscribe to our news letter to get updates.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-secondary py-2 position-absolute top-0 end-0 mt-2 me-2">Join Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid bg-secondary text-body copyright py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="fw-semi-bold" href="{{ route('home') }}">Milky</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="fw-semi-bold" href="https://htmlcodex.com">Code Euphoria</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        const x = document.getElementById("userLocation");

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }



        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;

        }



        function showAlert() {
            alert("Your milk collection will be completed and you will enter at your destination plant and email will be send to plant with your estimated arrival time");
        }
    </script>



</body>

</html>