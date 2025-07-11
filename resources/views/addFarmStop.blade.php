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
      <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>


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

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
 
</head>

<body>
    <div class="d-none">
        {{$randNumber = rand(100,999); }}
        {{ $str = Illuminate\Support\Str::random(3); }}
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
    <p class="p-3">Home/Dashboard/View Route/Verify Farm</p>
    <h3 class="p-3">Verify The Farm </h3>
    <div class="container my-3">
        <div class="container">
            @if ($errors->any())

            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
            @endforeach

            @endif
            <div class="container">
                <h5 class="text-center">Please Verify the Farm</h5>
                <div class="container">
                    <div class="container">
                        <div class="border my-2 rounded p-2">
                            <h6>Name:</h6>
                            <p>{{$farm->name}}</p>
                            <input type="hidden" value="{{ $farm->id }}" id="farmid">
                        </div>
                        <div class="border my-2 rounded p-2">
                            <h6>Farm ID:</h6>
                            <p>{{$farm->farm_id}}</p>
                        </div>
                        <div class="border my-2 rounded p-2">
                            <h6>Patron ID:</h6>
                            <p>{{$farm->patron_id}}</p>
                        </div>
                    </div>
                </div>

                <div class="container bg-success p-3 text-white rounded">
                    <div class="col-12 text-white">
                        {{-- {{ dd($tanks); }} --}}
                        <form action="{{ route('show.tank',$farm->id) }}" method="get">
                            <h6 for="tankID" class="text-white">Please Select Tank</h6>
                            <select name="tankId" id="tankID" onchange="this.form.submit();" class="form-control">
                                <option selected disabled>--Please Select Tank--</option>
                                @foreach ($tanks as $tanki)

                                <option value="{{ $tanki->tankid }}">{{$tanki->tank_id}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="ticketID" value="{{ $ticketID }}">
                        </form>
                    </div>

                    @if (isset($oneTank))
                    <div class="my-2 text-center bg-dark p-2 rounded text-white">
                        <h6 class="text-white">Tank: {{$oneTank->tank_id}}</h6>
                        <h6 class="text-white">Tank Type: {{$oneTank->type}}</h6>


                        {{-- <h6>Tank Total Capacity: {{$tank->capacity}}</h6> --}}
                        <input type="hidden" name="" value="{{ $oneTank->type }}" id="tankType">
                        <input type="hidden" name="" value="{{ $oneTank->height }}" id="tankHeight">
                        <input type="hidden" name="" value="{{ $oneTank->width }}" id="tankWidth">
                        <input type="hidden" name="" value="{{ $oneTank->radius }}" id="tankRadius">
                        <input type="hidden" name="" value="{{ $oneTank->length }}" id="tankLength">

                    </div>
                    {{-- <h6 class="my-2">Total Capacity of Tank {{$tank->tank_id}} = {{$tank->capacity}}</h6> --}}
                    {{-- {{ $tank->capacity }} --}}



                    <div class="border my-2 shadow-lg rounded p-2">
                        <h5 class="text-center text-white">Measure The Quantity of Milk Collected</h5>
                        <select name="measurement_method" id="method" onchange="selectMethod()" class="form-control">
                            <option diabled>--Select Measurement Method</option>
                            <option value="Stick Reading">Stick Reading</option>
                            <option value="Scale At Farm">Scale At Farm</option>
                            <option value="Scale At Plant">Scale At Plant</option>
                            <option value="Estimated Value">Estimated Values</option>
                        </select>


                        <div class="col-12" id="sr">
                            <label for="startReading">Enter start reading</label>
                            <input type="number" name="startReading" required id="startReading" class="form-control">

                        </div>
                        <div class="col-12" id="er">
                            <label for="endReading">Enter End Reading</label>
                            <input type="number" name="endReading" required id="endReading" class="form-control">
                            <div class="text-center my-2">
                                <button onclick="calculateStickReadings()" class="btn btn-danger">Calculate</button>
                            </div>
                        </div>
                        <div class="col-12" id="scr">
                            <label for="scaleReading">Enter Scale Values</label>
                            <input type="number" name="scaleReading" id="scaleReading" class="form-control">
                            <div class="text-center my-2">
                                <button onclick="calaculateScaleReadings()" class="btn btn-danger">Calculate</button>
                            </div>
                        </div>
                        <div class="col-12" id="ev">
                            <label for="estimatedReading">Enter Estimated Values</label>
                            <input type="number" name="estimatedReading" id="estimatedReading" class="form-control">
                            <div class="text-center my-2">
                                <button onclick="calculateEstimatedValue()" class="btn btn-danger">Calculate</button>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-center text-white">Collected Milk: <span id="collectedMilk"></span> lbs</h6>
                </div>
            </div>
            <form action="{{ route('add.farm.stop') }}" method="POST">
                @csrf
                <input type="hidden" name="farm_id" value="{{ $farm->id }}">

                {{-- {{ dd($oneTank->tank_id); }} --}}
                <input type="hidden" name="tank_id" value="{{ $oneTank->id }}">
                <input type="hidden" name="tracking_id" value="{{ Illuminate\Support\Str::random(5) }}">
                <input type="hidden" name="calculated_milk" value="" id="colMilk">
                <input type="hidden" name="method" id="meth" value="">
                <input type="hidden" name="ticketID" value="{{ $ticketID }}">
                <div class="text-center">
                    <button class="btn btn-success my-2">Mark As Collected</button>
                </div>
            </form>
            @endif
            {{-- {{ dd($ticketID); }} --}}
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
                        <button type="button" class="btn btn-secondary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
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






    <script>
        let farmid = document.getElementById("farmid").value;
        localStorage.setItem("farmid", farmid);
        document.getElementById("sr").style.display = "none";
        document.getElementById("er").style.display = "none";
        document.getElementById("ev").style.display = "none";
        document.getElementById("scr").style.display = "none";
        let collectedMilk = document.getElementById("collectedMilk");
        let colMilk = document.getElementById("colMilk");
        let scaleReading;
        let meth = document.getElementById("meth");

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

        let tankType = document.getElementById("tankType").value;
        let tankRadius;
        let tankWidth, tankHeight, tankLength, volume;

        if (tankType) {
            if (tankType == "rectangular") {
                tankWidth = document.getElementById("tankWidth").value;
                tankHeight = document.getElementById("tankHeight").value;
                tankLength = document.getElementById("tankLength").value;
                // console.log(tankLength);

            } else if (tankType == "cylindrical") {
                tankHeight = document.getElementById("tankHeight").value;
                tankRadius = document.getElementById("tankRadius").value;
            }
        }

        function calculateStickReadings() {

            let startReading = document.getElementById("startReading").value;
            let endReading = document.getElementById("endReading").value;
            tankHeight = parseFloat(document.getElementById("tankHeight").value);
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
                    volume = ((tankWidth * height * tankLength) * 7.48) * 8.6;
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

  <h2>📷 Scan Barcode (Code 128)</h2>
  <div id="yourElement"></div>
  <div id="result">Waiting for scan...</div>

  <script>
    Quagga.init({
      inputStream: {
        name: "Live",
        type: "LiveStream",
        target: document.querySelector('#yourElement'),
        constraints: {
          facingMode: "environment" // Use back camera on mobile
        }
      },
      locator: {
        patchSize: "medium",
        halfSample: true
      },
      numOfWorkers: navigator.hardwareConcurrency || 4,
      decoder: {
        readers: ["code_128_reader"]
      },
      locate: true
    }, function (err) {
      if (err) {
        console.error("Quagga init error:", err);
        return;
      }
      console.log("Quagga initialization finished.");
      Quagga.start();
    });

    // Handle detected barcode
    Quagga.onDetected((data) => {
      const code = data.codeResult.code;
      const resultDiv = document.getElementById("result");

      // Show result if different from previous
      if (resultDiv.innerText !== code) {
        console.log("Barcode detected:", code);
        resultDiv.innerText = "Scanned: " + code;

        // Optional: stop after successful scan
        Quagga.stop();

        // Optional: Redirect or send to server
        // window.location.href = "?id=" + code;
      }
    });
  </script>

</body>

</html>