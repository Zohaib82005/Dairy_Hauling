<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Milky - Dairy Hauling</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        .chat {
            position: fixed;
            bottom: 20px;
            left: 20px;
        }

        .chatbox {
            position: fixed;
            bottom: 20px;
            left: 70px;
            width: 350px;
            height: 500px;
            border: 2px solid green;
            border-radius: 20px;
            background-color: rgb(209, 208, 208);
            display: flex;
            flex-direction: column;
        }

        #chatMessages {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
            padding: 10px;
        }

        #chatInput {
            display: flex;
            gap: 10px;
            padding: 10px;
            background: #fff;
            border-top: 1px solid #ccc;
            border-radius: 0 0 20px 20px;
        }

        #messagebox {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #sendBtn {
            padding: 8px 15px;
            background: #25D366;
            /* WhatsApp green */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }



        .receivedMessage {
            background-color: #ffffff;
            border-radius: 8px 8px 8px 0px;
            max-width: 60%;
            padding: 8px 12px;
            margin: 8px 0;
            float: left;
            clear: both;
            color: #000;
            font-family: Arial, sans-serif;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .sentMessages {
            background-color: #dcf8c6;
            border-radius: 8px 8px 0px 8px;
            max-width: 60%;
            padding: 8px 12px;
            margin: 8px 0;
            float: right;
            clear: both;
            color: #000;
            font-family: Arial, sans-serif;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .prevActivTable{
            overflow: scroll;
            scrollbar-width: none;
        }
    </style>
</head>

<body>
    
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
        <h5 class="text-success">Loading...</h5>
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
                    <a class="btn btn-link text-light" href="https://www.instagram.com"><i
                            class="fab fa-instagram"></i></a>
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

    <h3 class="px-3">Welcome!</h3>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (!Auth::user()->cnic || !Auth::user()->licence_number || !Auth::user()->expiration_date || !Auth::user()->address)
        <div class="container">
            <div class="container text-center">
                <div class="alert alert-primary" id="completeProfileAlert">
                    Please Complete Your Profile To Continue your Journey.😊
                </div>
                <a href="{{ route('user.complete.profile', Auth::user()->id) }}" class="btn btn-success my-2">Complete
                    Profile</a>
            </div>
        </div>
    @endif
    <div class="container my-3">
        <div class="row">
            <div class="col-lg-6 shadow-lg rounded p-4">
                <div class="">
                    <h3 class="bg-success p-1 text-white">Driver Info</h3>
                    <p><b>Name:</b> {{ Auth::user()->name }}</p>
                    <p><b>Email: </b> {{ Auth::user()->email }}</p>
                    <p><b>CNIC: </b>{{ Auth::user()->cnic }}</p>
                    <p><b>Address: </b>{{ Auth::user()->address }}</p>
                    <p><b>License Number: </b>{{ Auth::user()->licence_number }}</p>
                </div>

            </div>
            <div class="col-lg-6  shadow-lg p-4 text-center rounded">
                <div class="" onclick="showTicketAlert()">
                    <h3>Start Hauling Now</h3>
                    <ul class="p-2 my-1" type="none">
                        <li>Get Your Ticket</li>
                        <li>Fill in The details of route</li>
                        <li>Then start your journey</li>

                    </ul>
                    <a href="{{ route('getTicket') }}" id="ticket" class="btn btn-success rounded p-2 mt-1 ">Get
                        Ticket</a>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <h5>Your Tickets</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ticket Number</th>
                    <th>Hauler Name</th>
                    <th>Route Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->ticket_number }}</td>
                        <td>{{ $ticket->hname }}</td>
                        <td>{{ $ticket->route_number }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td><a href="{{ route('view.route', $ticket->tkid) }}" class="btn btn-success">Start Now</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="container p-4" style="border: 2px solid green;">
        <h4 class="text-center text-white bg-success py-2">Your Previous Activities</h4>
        <div class="prevActivTable">
        <table class="table table-striped border">
            <thead>
                <tr>
                    <th>Hauler Name</th>
                    <th>Ticket Number</th>
                    <th>Route Number</th>
                    <th>Trcuk ID</th>
                    <th>Trailer ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($previousTickets as $pt)
                    <tr>
                        <td>{{ $pt->hname }}</td>
                        <td>{{ $pt->ticket_number }}</td>
                        <td>{{ $pt->route_number }}</td>
                        <td>{{ $pt->truckId }}</td>
                        <td>{{ $pt->trailerId }}</td>

                        <td>{{ $pt->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    <button class="btn btn-success chat" onclick="showChatBox()" title="Chat with Your Hauler"><i
            class="bi bi-chat-dots-fill"></i></button>
    <div class="container chatbox" id="chatbox">
        <h4 class="text-center border bg-white rounded">Chat</h4>
        <div id="chatMessages">
            @if ($messages)
                @foreach ($messages as $m)
                    @if ($m->sender_id == Auth::user()->id)
                        <div class="sentMessages">{{ $m->message }}</div>
                    @elseif ($m->sender_id == Auth::user()->hauler_id)
                        <div class="receivedMessage">{{ $m->message }}</div>
                    @endif
                @endforeach
            @endif
        </div>
        <div id="chatInput">
            <input type="text" class="form-control" style="width:270px;" id="messagebox">
            <button class="btn btn-success" id="sendBtn" onclick="sendMessage()">Send</button>
        </div>
    </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
     let chatbox = document.getElementById('chatbox');
    chatbox.style.visibility = "hidden";

    function showChatBox() {
        if (chatbox.style.visibility === "hidden") {
            chatbox.style.visibility = "visible";
        } else {
            chatbox.style.visibility = "hidden";
        }
    }

    function scrollToBottom() {
        let chatMessages = document.getElementById("chatMessages");
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    window.onload = scrollToBottom;

    function sendMessage() {
        let messages = document.getElementById('messagebox').value;
        $.ajax({
            url: '/sendMessage',
            type: 'POST',
            data: {
                message: messages,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#messagebox').val('');
                scrollToBottom();
            }
        });
    }
        let userId = {{ Auth::user()->id }};
        let haulerId = ({{ Auth::user()->hauler_id }}) ? {{ Auth::user()->hauler_id }} : 0 ;
console.log(haulerId);
console.log(userId);
        function viewMessage() {
            $.ajax({
                url: '/getMessages',
                type: 'GET',
                success: function(response) {
                    let chatBox = $('#chatMessages');
                    response.forEach(function(msg) {
                        if (msg.sender_id == userId) {
                            chatBox.append(`<div class="sentMessages">${msg.message}</div>`);
                        } else if (msg.sender_id == haulerId) {
                            chatBox.append(`<div class="receivedMessage">${msg.message}</div>`);
                        }

                        scrollToBottom();
                    });
                }
            });
        }

        setInterval(viewMessage, 900);


        let cpalert = document.getElementById("completeProfileAlert");
        let ticket = document.getElementById("ticket");

        if (cpalert) {
            ticket.classList.add('disabled');
        } else {
            ticket.classList.remove('disabled');
        }

        function showTicketAlert() {
            if (cpalert) {
                alert("Please Complete Your Profile To Continue");
            }
        }

        function scrollToBottom() {
            let chatMessages = document.getElementById("chatMessages");
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        window.onload = scrollToBottom;
    </script>
</body>

</html>
