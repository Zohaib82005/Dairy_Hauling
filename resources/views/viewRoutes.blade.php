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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .rounded {
            border: 3px solid green !important;
        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
        Loading...
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
            <h3 class="text-success mb-4"><i class="fas fa-ticket me-2"></i>Ticket Details</h3>

            {{-- <p>Here are the details how you will go and collect milk from different Farms</p> --}}
        </div>
        <div class="container m-2 p-2 border rounded">
            <h5 class="my-2">Ticket Number: {{ $tickets->ticket_number }}</h5>
            <div class="row mb-2">
                <div class="col-lg-6">
                    <h6 class="my-4">Pickup Date: {{ $tickets->pickup_date }}</h6>
                    <h6 class="my-4">Route Number: {{ $tickets->route_number }}</h6>
                    <h6 class="my-4">Hauler:{{ $tickets->hname }}</h6>
                </div>
                <div class="col-lg-6">
                    <h6 class="my-4">Truck ID: {{ $tickets->truckID }}</h6>
                    <h6 class="my-4">Trailer ID: {{ $tickets->trailerID }}</h6>
                    <h6 class="my-4">Status: {{ $tickets->status }}</h6>
                </div>
            </div>
            <div class="container">
                <div class="my-2">
                    <h5 class="bg-success text-white d-inline p-2 rounded"><i class="bi bi-sign-stop-fill"></i> Next
                        Stop</h5>
                </div>
                <script>
                    let lcate, lat, lon;
                </script>
                @foreach ($farmsInRoute as $fir)
                    <span class="bg-warning p-1"><strong class="text-dark">Farm Name:
                        </strong>{{ $fir->name }}</span>
                    <div class="container bg-dark my-2 p-2 rounded">
                        <h5 class="text-white"><i class="bi bi-geo-alt"></i> Location: </h5>
                        <p id="lcate" class="text-white">Loading...</p>
                    </div>
                    <script>
                        lcate = document.getElementById("lcate");
                        lat = "{{ $fir->latitude }}";
                        lon = "{{ $fir->longitude }}";


                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                            .then(response => response.json())
                            .then(data => {
                                lcate.innerHTML = `<i class="bi bi-check-circle me-2"></i>${data.display_name}`;
                                // console.log(data.display_name);
                            })
                            .catch(err => {
                                lcate.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>Location not found`;
                                lcate.classList.remove('bg-dark');
                                lcate.parentElement.classList.add('bg-danger');
                            });
                    </script>
                @endforeach
            </div>
            <a href="{{ route('view.farm.stop', $ticketID) }}" class="btn btn-success my-2"><i
                    class="fas fa-plus me-2"></i>Add Farm Stop</a>
            <a href="{{ route('destinationPlant', $ticketID) }}" onclick="closeLoad()" class="btn btn-success my-2"><i
                    class="fas fa-stop me-2"></i>Close
                Load</a>

            {{-- <a href="" class="btn btn-success my-2"><i class="fas fa-truck me-2"></i>Complete Delivery</a> --}}
        </div>

        {{-- ------------------------------- --}}
    </div>

    <div class="container rounded border">
        <table class="table table-striped text-center" style="border: 2px solid green; border-radius: 3px;">
            <thead>
                <th>Farm Name</th>
                <th>Tank</th>
                <th>Collection Date</th>
                <th>Collected Milk</th>
            </thead>
            <tbody>
                @php
                    $totalMilk = 0;
                    $plantMilk = 0;
                    // dd($collectedFarms);
                @endphp
                @foreach ($collectedFarms as $cf)
                    @php
                    
                        if($cf->method == "Scale At Plant"){
                            $plantMilk = $cf->collected_milk;
                        }else{
                            $totalMilk = $totalMilk + $cf->collected_milk;
                        }

                    @endphp

                    <tr>
                        <td>{{ $cf->fname }}</td>
                        <td>{{ $cf->tankId }}</td>
                        <td>{{ $cf->farmCollectedAt }}</td>
                        <td>{{ $cf->collected_milk }}</td>
                    </tr>
                @endforeach

                @php
                    $totalMilk = $totalMilk + $plantMilk;
                @endphp
            </tbody>
        </table>

        <span><strong>Total Milk Colleted: </strong>{{ $totalMilk }} lbs</span>

        @php
            $desPlant = DB::table('routes')
                ->join('plants', 'routes.destination_plant', '=', 'plants.id')
                ->select('latitude', 'longitude')
                ->where('route_number', $tickets->route_number)
                ->first();
            // dd($destinationPlant);
            $lat2 = $desPlant->latitude;
            $long2 = $desPlant->longitude;
            $lat1 = session('lat1');
            $long1 = session('long1');
            function distanceBtw($lat1, $lon1, $lat2, $lon2)
            {
                $R = 6371; // Earth's radius in km

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;

    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * $c;
}

$speed = 70;
$distance = distanceBtw($lat1, $long1, $lat2, $long2); // km
session()->put('distance', $distance);
$timeInHours = $distance / $speed;
$totalSeconds = $timeInHours * 3600;

$hours = floor($totalSeconds / 3600);
$minutes = floor(($totalSeconds % 3600) / 60);
$seconds = floor($totalSeconds % 60);

$formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

session()->put('arrivalTime', $formattedTime);

        @endphp
    </div>
    {{-- <p>Estimated Arrival Time:{{ session('arrivalTime') }}</p> --}}
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
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-linkedin-in"></i></a>
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
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text"
                            placeholder="Your email">
                        <button type="button"
                            class="btn btn-secondary py-2 position-absolute top-0 end-0 mt-2 me-2">Join Now</button>
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
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <img src="" alt="" id="mapholder">
    <script>
        function closeLoad() {
            alert(
                "Your milk collection will be completed and you will enter at your destination plant and email will be send to plant with your estimated arrival time"
            );
        }
setInterval(() => {
    navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const long = position.coords.longitude;
            $.ajax({
                url: '/getLocation',
                type: 'GET',
                data: {
                    latitude: lat,
                    longitude: long
                },
                success: function(response) {
                    console.log(response);
                }
            });
        });
}, 5000);
        
    </script>



</body>

</html>
