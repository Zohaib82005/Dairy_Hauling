<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Milky - Dairy Hauling</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.4.0/fabric.min.js'></script>

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


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        #sheet {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="d-none">
        {{ $randNumber = rand(100, 999) }}
        {{ $str = Illuminate\Support\Str::random(3) }}
        {{ $ticketNumber = $str . $randNumber }}
    </div>
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
    <p class="p-3">Home/Dashboard/Get Ticket</p>
    <h3 class="p-3">Get Ticket Here</h3>
    <div class="container my-3">
        <div class="container">
            @if ($errors->any())

                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach

            @endif
            <form action="{{ route('storeTicket') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 my-2">
                        <h3>Ticket Number: {{ $ticketNumber }}</h3>
                        <input type="hidden" name="ticket_number" value="{{ $ticketNumber }}">
                        <div class="form-floating">

                            <select name="route_numb" id="routeNum" class="form-control">
                                <option selected disabled>--Select Route--</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->rid }}">{{ $route->route_number }}</option>
                                @endforeach
                            </select>
                            <label for="routeNum">Route Number</label>
                        </div>
                    </div>

                    <div class="col-12 my-2">
                        <div class="form-floating">

                            <input type="date" name="pickupDate" id="pickup" class="form-control">
                            <label for="pickup">Pickup Date</label>
                        </div>
                    </div>

                    <div class="col-12 my-2">
                        <div class="form-floating">

                            <select name="truckId" id="truckid" class="form-control">
                                <option selected disabled>--Select Truck--</option>
                                @foreach ($trucks as $truck)
                                    <option value="{{ $truck->id }}">{{ $truck->truck_id }}</option>
                                @endforeach
                            </select>
                            <label for="truckid">Truck ID</label>
                        </div>
                    </div>

                    <div class="col-12 my-2">
                        <div class="form-floating">

                            <select name="trailerId" id="trailerid" class="form-control">
                                <option selected disabled>--Select Trailer--</option>
                                @foreach ($trailers as $trailer)
                                    <option value="{{ $trailer->id }}">{{ $trailer->trailer_id }}</option>
                                @endforeach
                            </select>
                            <label for="trailerid">Trailer ID</label>
                        </div>
                    </div>

                    <div class="col-12 my-2">
                        <h5>Do Your Signature Here: </h5>
                        <canvas id="myCanvas" height="200" style="border:1px solid #000;"></canvas>
                        <button id="uploadSignature" type="button" class="btn btn-danger" onclick="convert()">Upload
                            Signature</button>
                        <button class="btn btn-primary" type="button" onclick="clearSignature()">Clear Signature</button>
                        <input type="hidden" value="" name="signature" id="sign">
                    </div>

                </div>
                <div class="text-center my-2">
                    <button type="submit" id="saveSignature" class="btn btn-success">Start Route</button>
                </div>
            </form>


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
                            class="btn btn-secondary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
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
                    {{-- Designed By <a class="fw-semi-bold" href="https://htmlcodex.com">Code Euphoria</a> --}}
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
const canvas = document.getElementById('myCanvas');
const ctx = canvas.getContext('2d');
let sign = document.getElementById('sign');
let isDrawing = false;
let lastX = 0;
let lastY = 0;

ctx.lineWidth = 5;
ctx.lineCap = 'round';
ctx.strokeStyle = 'black';

canvas.addEventListener('mousedown', (e) => startDraw(e.offsetX, e.offsetY));
canvas.addEventListener('mousemove', (e) => draw(e.offsetX, e.offsetY));
canvas.addEventListener('mouseup', stopDraw);
canvas.addEventListener('mouseout', stopDraw);

canvas.addEventListener('touchstart', (e) => {
    const rect = canvas.getBoundingClientRect();
    const touch = e.touches[0];
    startDraw(touch.clientX - rect.left, touch.clientY - rect.top);
    e.preventDefault();
});

canvas.addEventListener('touchmove', (e) => {
    const rect = canvas.getBoundingClientRect();
    const touch = e.touches[0];
    draw(touch.clientX - rect.left, touch.clientY - rect.top);
    e.preventDefault();
});

canvas.addEventListener('touchend', stopDraw);

function startDraw(x, y) {
    isDrawing = true;
    [lastX, lastY] = [x, y];
}

function draw(x, y) {
    if (!isDrawing) return;
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    ctx.stroke();
    [lastX, lastY] = [x, y];
}

function stopDraw() {
    isDrawing = false;
}

function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function convert() {
    const img = canvas.toDataURL('image/png');
    sign.value = img;
    alert('Signature saved!');
}
</script>

</body>

</html>
