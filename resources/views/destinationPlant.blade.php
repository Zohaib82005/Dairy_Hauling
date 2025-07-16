<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Milky - Dairy Hauling</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



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


    <!-- Navbar Start -->

    <!-- Navbar End -->
    <div class="container py-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success bg-gradient text-white text-center rounded-top py-4">
                <h3 class="mb-0 text-white"><i class="bi bi-geo-alt-fill me-2"></i>Destination Plant Overview</h3>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="card-title"><i class="bi bi-tree-fill text-success me-2"></i>Plant Name:</h5>
                        <p class="ms-4">{{ $destinationPlant->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="card-title"><i class="bi bi-signpost-2-fill text-primary me-2"></i>Route Number:</h5>
                        <p class="ms-4">{{ $destinationPlant->route_number }}</p>
                    </div>

                    <!-- Additional Info (You can dynamically replace these with $destinationPlant->property if available) -->
                    <div class="col-md-6">
                        <h5 class="card-title"><i class="bi bi-pin-map-fill text-warning me-2"></i>Location:</h5>
                        <p class="ms-4"><span id="location"></span></p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="card-title"><i class="bi bi-person-circle text-info me-2"></i>Plant Email:</h5>
                        <p class="ms-4">{{ $destinationPlant->email }}</p>
                    </div>
                
                    <div class="col-md-6">
                        <h5 class="card-title"><i class="bi bi-clock-fill text-danger me-2"></i>Estimated Arrival Time:
                        </h5>
                        <p class="ms-4">{{ session('arrivalTime') }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="card-title"><i class="bi bi-rulers text-dark me-2"></i>Total Distance:</h5>
                        <p class="ms-4">{{ round(session('distance'), 2) }} KM</p>
                    </div>
                </div>

                <hr class="my-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Validation Errors:</h5>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('collect.at.plant', $ticketID) }}" method="POST" onsubmit="clearStorage()">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" step="any" required name="temprature"
                                    id="temprature" placeholder="Temperature">
                                <label for="temprature">Milk Temperature (°F)</label>
                            </div>
                        </div>

                        <div class="col-md-6" id="tankReading">
                            <div class="form-floating">
                                <input type="number" name="collected_milk" id="cm" class="form-control"
                                     placeholder="Collected Milk">
                                <label for="cm">Milk Reading at Plant (lbs)</label>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-lg btn-success mt-3 px-5">
                                <i class="bi bi-check-circle-fill me-2"></i>Close Route
                            </button>
                        </div>
                    </div>
                </form>
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
        let plantReading = localStorage.getItem("scaleReadingAtPlant");
        let tankReading = document.getElementById("tankReading");
        tankReading.style.display = "none";
        if (plantReading == "Yes") {
            tankReading.style.display = "block";

            let inputField = document.getElementById("cm");
            inputField.setAttribute("required");
            
        }
        
        function clearStorage() {
            inputField.removeAttribute("required");
            localStorage.clear();
        }

        let locat = document.getElementById("location");
        let lat = "{{ $destinationPlant->latitude }}";
        let lon = "{{ $destinationPlant->longitude }}";
        console.log(lat);
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
            .then(response => response.json())
            .then(data => {
                locat.innerHTML = `<i class="bi bi-check-circle me-2"></i>${data.display_name}`;
                // console.log(data.display_name);
            })
            .catch(err => {
                locationElement.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>Location not found`;
                locationElement.parentElement.classList.remove('bg-dark');
                locationElement.parentElement.classList.add('bg-danger');
            });
    </script>
</body>

</html>
