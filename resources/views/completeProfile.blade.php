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

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

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
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
        <a href="index.html" class="navbar-brand d-flex align-items-center">
            <h1 class="m-0">Milky</h1>
        </a>
        <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Services</a>
                <a href="product.html" class="nav-item nav-link">Products</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Signup/login</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="{{ route('signup') }}" class="dropdown-item">Sign Up</a>
                        <a href="" class="dropdown-item active">Login</a>

                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <div class="border-start ps-4 d-none d-lg-block">
                <button type="button" class="btn btn-sm p-0"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">Login Here</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Signup/login</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container p-5 text-center">
        <h4>Complete Your Proile</h4>
        @if ($errors->any())
            @foreach ($errors as $error)
                <div class="alert alert-warning">{{$error}}</div>
            @endforeach
        @endif
        <form action="{{ route('user.update.profile') }}" method="POST">
            @csrf
        <div class="row my-2">
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="text" value="{{ Auth::user()->cnic }}" name="cnic" class="form-control " id="cnic" placeholder="Enter CNIC">
                    <label for="cnic">CNIC</label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <textarea name="address" class="form-control"  value="{{ Auth::user()->address }}" id="address" cols="30" rows="30"></textarea>
                    <label for="address">Address</label>
                </div>
            </div>
            
            <div class="col-12 my-2">
                                <div class="form-floating">
                                    <input type="text" name="licence_number"  value="{{ Auth::user()->licence_number }}" class="form-control" id="licence_number" placeholder="Enter License Number">
                                    <label for="licence_number">License Number</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="date" name="expiration_date"  value="{{ Auth::user()->expiration_date }}" class="form-control mb-2" id="expdate" placeholder="Enter Expiration Date">
                                    <label for="expdate">Expiration Date</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="hauler_id" id="hauler" class="form-control">
                                        <option selected disabled>--Select Hauler--</option>
                                        @foreach ($haulers as $hauler)
                                            <option value="{{ $hauler->id }}">{{$hauler->name}} | {{ $hauler->shipp_number }}</option>
                                        @endforeach
                                    </select>
                                    <label for="hauler">Select Hauler</label>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"><button type="submit" class="btn btn-success">Submit</button></div>
                            <div class="col-lg-4"></div>
                            
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
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/parallax/parallax.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>