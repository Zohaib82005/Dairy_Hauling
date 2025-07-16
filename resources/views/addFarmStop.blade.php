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
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/@undecaf/barcode-detector-polyfill@0.9.20/dist/index.js"></script>
    <!-- Template Stylesheet -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .scanner-container {
            border: 2px solid #28a745;
            border-radius: 0.375rem;
            overflow: hidden;
        }
    </style>

</head>

<body>

    <!-- Spinner Start -->
    {{-- <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div> --}}
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
    <p class="p-3">Home/Dashboard/View Ticket/Add farm Stop

    <div class="container my-3">
        <div class="container">
            @if ($errors->any())

                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach

            @endif
            <div class="container">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Scan Barcode</h5>
                        <div class="scanner-container mb-3">
                            <video id="scanner-video" autoplay playsinline style="width: 100%; height: 300px;"></video>
                        </div>
                        <div class="text-center">
                            <div id="result" class="text-center d-inline ">Scanning...</div>
                        </div>

                        <input type="hidden" value="" id="tracking_id" name="tracking_id">
                        <input type="hidden" value="" id="farm_id" name="farm_id">
                        <input type="hidden" value="" id="tank_id" name="tank_id">
                        <input type="hidden" value="" id="patron_id" name="patron_id">
                        <button type="submit" class="btn btn-success float-right" id="checkBtn">Stop Scan</button>



                    </div>
                </div>

            </div>

            <div class="border my-2 shadow-lg rounded p-2 bg-success" id="getMethod">
                <h5 class="text-center text-white">Measure The Quantity of Milk Collected</h5>
                <select name="measurement_method" id="method" onchange="selectMethod()" class="form-control">
                    <option diabled>--Select Measurement Method</option>
                    <option value="Stick Reading">Stick Reading</option>
                    <option value="Scale At Farm">Scale At Farm</option>
                    <option value="Scale At Plant">Scale At Plant</option>
                    <option value="Estimated Value">Estimated Values</option>
                </select>


                <div class="col-12" id="sr">
                    <label for="startReading" class="text-white">Enter start reading</label>
                    <input type="number" name="startReading" required id="startReading" class="form-control">

                </div>
                <div class="col-12" id="er">
                    <label for="endReading" class="text-white">Enter End Reading</label>
                    <input type="number" name="endReading" required id="endReading" class="form-control">
                    <div class="text-center my-2">
                        <button onclick="calculateStickReadings()" class="btn btn-danger">Calculate</button>
                    </div>
                </div>
                <div class="col-12" id="scr">
                    <label for="scaleReading" class="text-white">Enter Scale Values</label>
                    <input type="number" name="scaleReading" id="scaleReading" class="form-control">
                    <div class="text-center my-2">
                        <button onclick="calaculateScaleReadings()" class="btn btn-danger">Calculate</button>
                    </div>
                </div>
                <div class="col-12" id="ev">
                    <label for="estimatedReading" class="text-white">Enter Estimated Values</label>
                    <input type="number" name="estimatedReading" id="estimatedReading" class="form-control">
                    <div class="text-center my-2">
                        <button onclick="calculateEstimatedValue()" class="btn btn-danger">Calculate</button>
                    </div>
                </div>
                <h6 class="text-center text-white">Collected Milk: <span id="collectedMilk"></span> lbs</h6>
            </div>

        </div>
    </div>


    </div>
    </div>
    {{-- special container --}}
    <div class="container " id="milkValues">
        <form action="{{ route('add.farm.stop') }}" method="POST">
            @csrf
            <input type="hidden" value="" name="farm_id" id="fid">
            <input type="hidden" value="" name="tracking_id" id="trid">
            <input type="hidden" name="tank_id" value="" id="tid">
            <input type="hidden" name="patron_id" id="pid" value="">
            <input type="hidden" name="calculated_milk" id="colMilk" value="">
            <input type="hidden" name="method" value="" id="meth">
            <input type="hidden" name="ticketID" value="{{ $ticketID }}">
            <div class="col-12 text-center">
            <button class="btn btn-success" class="text-center" type="submit">Mark as Collected</button>
            </div>
        </form>
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
            class="bi bi-arrow-up"></i>
    </a>



    <script>
        let showMethod = document.getElementById('getMethod');
        showMethod.style.display = "none";
        let milkVal = document.getElementById('milkValues');
        milkVal.style.display = "none";
        // document.getElementById("result").style.display = "none";
        let result = "TR02FARM001TANK001PTR445";
        let trackingID = "",
            farmID = "",
            tankID = "",
            patronID = "";
        let track = document.getElementById("tracking_id");
        let farm = document.getElementById("farm_id");
        let tank = document.getElementById("tank_id");
        let patron = document.getElementById("patron_id");
        let trid = document.getElementById("trid");
        document.addEventListener("DOMContentLoaded", async function() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert("Camera not supported on this device/browser.");
                return;
            }
            const video = document.getElementById("scanner-video");
            video.srcObject = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment'
                }
            });

            const barcodeDetector = new BarcodeDetector({
                formats: ['code_128', 'ean_13', 'upc_a']
            });

            setInterval(async () => {
                const barcodes = await barcodeDetector.detect(video);
                if (barcodes.length > 0) {
                    const value = barcodes[0].rawValue;
                    result = value;
                    
                    document.getElementById("result").innerText = value;
                }
            }, 50);

        });
        console.log("scanning");

        
        let fid = document.getElementById('fid');
        let pid = document.getElementById('pid');
        let tid = document.getElementById('tid');

        let tankHeight, tankWidth, tankRadius, tankLength, tankType;
        $('#checkBtn').click(function() {
            for (let i = 0; i < result.length; i++) {
            if (i < 4) {
                trackingID = trackingID + result[i];
            } else if (i < 11) {
                farmID = farmID + result[i];
            } else if (i < 18) {
                tankID = tankID + result[i];
            } else if (i < 24) {
                patronID = patronID + result[i];
            }
        }
        track.value = trackingID;
        farm.value = farmID;
        tank.value = tankID;
        patron.value = patronID;
        console.log(track.value);
        console.log(tank.value);
        console.log(farm.value);
        console.log(patron.value);
                    console.log(result);
            console.log('button clicked');
            let trackingid = $('#tracking_id').val();
            let farmid = $('#farm_id').val();
            let tankid = $('#tank_id').val();
            let patronid = $('#patron_id').val();
            
            console.log(trackingid);
            $.ajax({
                url: '/check-data',
                type: 'GET',
                data: {
                    trackingId: trackingid,
                    farmId: farmid,
                    tankId: tankid,
                    patronId: patronid
                },
                success: function(response) {
                    if(response.data == "found"){
                        milkVal.style.display = "block"
                        fid.value = response.farmId;
                        pid.value = response.patronId;
                        tid.value = response.tankId;
                        trid.value = response.trackingId;
                        tankHeight = response.height;
                        tankLength = response.length;
                        tankRadius = response.radius;
                        tankWidth = response.width;
                        tankType = response.type;
                        showMethod.style.display = "block";

                    }
                    else{
                        showMethod.style.display = "block";
                        showMethod.style.color = "white";
                        showMethod.innerHTML = "Sorry We don't have this tank or farm in database or this farm doesn't belongs to your Hauler OR  the tank does not belong to this farm";
                    }
                    


                    // console.log(response.height);
                }
            })
        })

        // let farmid = document.getElementById("farmid").value;
        // localStorage.setItem("farmid", farmid);
        document.getElementById("sr").style.display = "none";
        document.getElementById("er").style.display = "none";
        document.getElementById("ev").style.display = "none";
        document.getElementById("scr").style.display = "none";
        let collectedMilk = document.getElementById("collectedMilk");
        let colMilk = document.getElementById("colMilk");
        let scaleReading;
        let meth = document.getElementById("meth");


        // let meth = document.getElementById("meth");

        function selectMethod() {
            let method = document.getElementById("method").value;
            meth.value = method;

            // console.log(meth.value);
            if (method == "Stick Reading") {
                document.getElementById("sr").style.display = "block";
                document.getElementById("er").style.display = "block";
                document.getElementById("ev").style.display = "none";
                document.getElementById("scr").style.display = "none";
                localStorage.clear();
                collectedMilk.innerHTML = "";
            } else if (method == "Scale At Farm") {
                document.getElementById("sr").style.display = "none";
                document.getElementById("er").style.display = "none";
                document.getElementById("ev").style.display = "none";
                document.getElementById("scr").style.display = "block";
                localStorage.clear();
                collectedMilk.innerHTML = "";
            } else if (method == "Estimated Value") {
                document.getElementById("sr").style.display = "none";
                document.getElementById("er").style.display = "none";
                document.getElementById("ev").style.display = "block";
                document.getElementById("scr").style.display = "none";
                localStorage.clear();
                collectedMilk.innerHTML = "";
            } else if (method == "Scale At Plant") {
                document.getElementById("sr").style.display = "none";
                document.getElementById("er").style.display = "none";
                document.getElementById("ev").style.display = "none";
                document.getElementById("scr").style.display = "none";
                localStorage.setItem("scaleReadingAtPlant", "Yes");
                collectedMilk.innerHTML = "You Will have to Enter The Reading At Plant";
                colMilk.value = 0;
                localStorage.setItem('milk', 0);
            }
        }

        function calculateStickReadings() {

            let startReading = document.getElementById("startReading").value;
            let endReading = document.getElementById("endReading").value;
            // tankHeight = parseFloat(document.getElementById("tankHeight").value);
            if (startReading > tankHeight) {
                alert("Start reading can't be greater than tank's height");
                return;
            }
            if (startReading < endReading) {
                alert("Please Enter The Valid Value");
                return;
            } else {
                let height = startReading - endReading;

                if (tankType == "rectangular") {
                    // console.log(tankWidth);
                    // console.log(tankLength);
                    // console.log(height);
                    volume = ((tankWidth * tankHeight * tankLength) * 7.48) * 8.6;
                    collectedMilk.innerHTML = volume;
                    colMilk.value = volume;
                } else if (tankType == "cylindrical") {
                    volume = ((3.14 * tankRadius * tankRadius * height) * 8.6) / 231;
                    collectedMilk.innerHTML = volume;
                    colMilk.value = volume;
                    localStorage.setItem('milk', volume);
                }
            }

        }

        function calaculateScaleReadings() {
            scaleReading = document.getElementById("scaleReading").value;
            collectedMilk.innerHTML = scaleReading;
            colMilk.value = scaleReading;
            localStorage.setItem('milk', scaleReading);
        }

        function calculateEstimatedValue() {
            let estimatedValue = document.getElementById("estimatedReading").value;
            collectedMilk.innerHTML = estimatedValue;
            colMilk.value = estimatedValue;
            localStorage.setItem('milk', estimatedValue);
        }

    </script>

</body>

</html>
