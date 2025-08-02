<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Hauling Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/adminStyle.css') }}">
    <style>
        .flip-card {
            background-color: transparent;
            width: 300px;
            height: 135px;
            perspective: 1000px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .flip-card-front {
            background-color: green;
            color: black;
        }

        .flip-card-back {
            background-color: rgb(16, 163, 16);
            color: white;
            transform: rotateY(180deg);
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="brand">
            <i class="fas fa-bolt"></i> Welcome {{ $haulerName->name }}
        </div>
        <nav class="nav flex-column">
            <button class="nav-link active" data-tab="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </button>

            <button class="nav-link" data-tab="driver">
                <i class="fa-solid fa-user"></i> Drivers
            </button>



            <button class="nav-link" data-tab="Trucks">
                <i class="fas fa-truck"></i> Trucks
            </button>

            <button class="nav-link" data-tab="trailers">
                <i class="fas fa-trailer"></i> Trailers
            </button>


            <button class="nav-link" data-tab="farms">
                <i class="fas fa-house-chimney-window"></i> Farms
            </button>

            <button class="nav-link" data-tab="tanks">
                <i class="fa-solid fa-database"></i> Tanks
            </button>

            <button class="nav-link" data-tab="tickets">
                <i class="fas fa-ticket"></i> Tickets
            </button>

            <button class="nav-link" data-tab="chats">
                {{-- <div class="row"> --}}
                {{-- <div class="col-lg-10"> --}}
                <i class="bi bi-chat-dots-fill"></i> Chats &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ $newMessages }}
                {{-- </div> --}}
                {{-- <div class="col-lg-2">{{$newMessages}}</div> --}}
                {{-- </div> --}}

            </button>

        </nav>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <i class="fas fa-bars"></i>
            <i class="fas fa-search"></i>
            <div class="search-box">
                <input type="text" placeholder="type to search">
            </div>
            <div class="icons">
                <i class="fab fa-github"></i>
                <div class="notification-badge">
                    <i class="fas fa-bell"></i>
                </div>
                <i class="fas fa-user"></i>
            </div>
        </div>

        <div class="content-area">
            <!-- Dashboard Tab Content -->
            <div class="tab-content active" id="dashboard">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stat-card blue">
                            <div class="subtitle">Sign ups</div>
                            <h3>{{ $totalUser }}</h3>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="flip-card rounded">
                            <div class="flip-card-inner rounded">
                                <div class="flip-card-front rounded text-white p-5">
                                    <div class="subtitle">Revenue</div>
                                    <h3 id="showPrice">${{ $totalMilk }}</h3>
                                    <input type="hidden" id="totalMilk" value="{{ $totalMilk }}">

                                </div>
                                <div class="flip-card-back rounded text-dark">
                                    <p class="py-2">Please Set the Price for 1 Lb</p>
                                    <input type="number" class="form-control my-2" id="price">
                                    <button class="btn btn-primary" onclick="setPrice()">Set Price</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card red">
                            <div class="subtitle">Open tickets</div>
                            <h3>{{ $ticketCount }}</h3>
                            <div class="icon">
                                <i class="fas fa-phone"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-container">
                            <div class="chart-header">
                                <div class="chart-title">
                                    <i class="fas fa-chart-bar"></i>
                                    Bar Chart
                                </div>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="chart-area">
                                <div class="y-axis">
                                    <span>20</span>
                                    <span>15</span>
                                    <span>10</span>
                                    <span>5</span>
                                    <span>0</span>
                                </div>
                                <div class="bar bar1">
                                    <div class="bar-label">Monday</div>
                                </div>
                                <div class="bar bar2">
                                    <div class="bar-label">Tuesday</div>
                                </div>
                                <div class="bar bar3">
                                    <div class="bar-label">Wednesday</div>
                                </div>
                                <div class="bar bar4">
                                    <div class="bar-label">Thursday</div>
                                </div>
                                <div class="bar bar5">
                                    <div class="bar-label">Friday</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="notifications-container">
                            <div class="notifications-header">
                                <i class="fas fa-bell"></i>
                                Notifications
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text">New comment</div>
                                </div>
                                <div class="notification-time">21 days ago</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text">New comment</div>
                                </div>
                                <div class="notification-time">21 days ago</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text">New comment</div>
                                </div>
                                <div class="notification-time">21 days ago</div>
                            </div>
                            <a href="#" class="show-all-link">Show all</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Driver Tab Content -->
            <div class="tab-content" id="driver">
                <a href="{{ route('hauler.addDriver') }}" class="btn btn-danger">Add Driver</a>
                <div class="row">
                    @foreach ($users as $index => $user)
                        <div class="col-lg-4 col-md-6 shadow-lg p-3"
                            style="
                        overflow:scroll; scrollbar-width:none;">
                            <div class="row bg-danger text-white p-1">
                                <div class="col-lg-10">
                                    <h5 class=""><b>Name:</b> {{ $user->uname }} </h5>
                                </div>
                                <div class="col-lg-2">
                                    @foreach ($activeUsers as $ac)
                                        @if ($ac->uid == $user->uid)
                                            <i class="fa-solid fa-circle m-2"
                                                style="font-size: 20px; color: rgb(4, 211, 4);"></i>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <img src="{{ asset('images/testimonial-1.jpg') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="col-lg-8">
                                    <p><b>Email:</b> <br>{{ $user->uemail }}</p>
                                    <p><b>License Number:</b> {{ $user->licence_number }}
                                    </p>
                                    <p><b>Expiration Date:</b> {{ $user->expiration_date }}</p>
                                    <p><b>Address:</b> {{ $user->uaddress }}</p>
                                    <p><b>Hauler:</b> {{ $user->haulerName }}</p>
                                </div>
                            </div>
                            <a href="{{ route('hauler.editDriver', $user->uid) }}"
                                class="btn btn-primary mx-2">Edit</a><a
                                href="{{ route('hauler.deleteDriver', $user->uid) }}"
                                class="btn btn-danger">Delete</a>
                            <button type="button" class="btn btn-warning" id="showProgress-{{ $index }}"
                                data-toggle="modal" data-target=".bd-progress-modal-sm-{{ $index }}">Show
                                Progress</button>

                            <div class="modal fade bd-progress-modal-sm-{{ $index }}" tabindex="-1"
                                role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content text-center">
                                        <div class="py-2 cont-{{ $index }}">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                        <th>Farm Name </th>
                                                        <th>Stop Time </th>
                                                        <th>Collected Milk</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-{{$index}}">
                                                    <tr class="tr-{{$index}}">
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#showProgress-{{ $index }}').click(function() {
                                    $.ajax({
                                        url: '/getUserProgress/{{ $user->uid }}',
                                        type: 'GET',
                                        success: function(response) {
                                            let progress = response.userProgress;

                                            $('.tbody-{{$index}}').empty();
                                            progress.forEach(function(item) {
                                                $('.tbody-{{$index}}').append(`<tr><td>${item.fname}</td><td>${item.stopTime}</td><td>${item.totalMilk}</td></tr>`);
                                                // console.log('Farm Name:', item.fname);
                                                // console.log('Stop Time:', item.stopTime);
                                                // console.log('Milk:', item.totalMilk);
                                            });
                                        },
                                        error: function(xhr) {

                                            console.log('Response Text:', xhr.responseText);
                                        }

                                    });
                                })
                            </script>

                            <button type="button" class="btn btn-success" id="viewLocation-{{ $index }}"
                                data-toggle="modal"
                                data-target=".bd-example-modal-sm-{{ $index }}">Location</button>

                            <div class="modal fade bd-example-modal-sm-{{ $index }}" tabindex="-1"
                                role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content text-center">
                                        <div class="py-2">
                                            <span class="py-1 d-block"><strong>Latitude: </strong><span
                                                    id="latitude-{{ $index }}"></span></span>
                                            <span class="py-1 d-block"><strong>Longitude: </strong><span
                                                    id="longitude-{{ $index }}"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#viewLocation-{{ $index }}').click(function() {
                                lat = document.getElementById('latitude-{{ $index }}');
                                long = document.getElementById('longitude-{{ $index }}');
                                $.ajax({
                                    url: '/hauler/viewLocation/{{ $user->uid }}',
                                    type: 'GET',
                                    success: function(response) {
                                        if (response.latitude == null) {
                                            lat.innerHTML = "Location is not Updated";
                                            long.innerHTML = "Location is not Updated";
                                        } else {
                                            lat.innerHTML = response.latitude;
                                            long.innerHTML = response.longitude;
                                        }
                                        // console.log(response);
                                    }

                                });
                            });
                        </script>
                    @endforeach
                </div>
            </div>


            <!-- Trucks Tab Content -->
            <div class="tab-content" id="Trucks">
                <a href="{{ route('hauler.add.trucks') }}" class="btn btn-primary my-2">Add Trucks</a>
                <div class="row">
                    <div class="col-12">

                        <table class="table table-striped" border>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Hauler Name</th>
                                    <th>Shippment Number</th>
                                    <th>Truck ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trucks as $truck)
                                    <tr>
                                        <td>{{ $truck->hauler_name }}</td>
                                        <td>{{ $truck->hauler_number }}</td>
                                        <td>{{ $truck->truck_id }}</td>
                                        <td><a href="{{ route('hauler.editTruck', $truck->tid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('hauler.deleteTruck', $truck->tid) }}"
                                                class="btn btn-danger">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Trailers tab content --}}
            <div class="tab-content" id="trailers">
                <a href="{{ route('hauler.add.trailer') }}" class="btn btn-warning my-2">Add Trailer</a>
                <div class="row">

                    <div class="col-12">
                        <table class="table table-striped" border>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Hauler Name</th>
                                    <th>Shippment Number</th>
                                    <th>Trailer ID</th>
                                    <th>Capacity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trailers as $trailer)
                                    <tr>
                                        <td>{{ $trailer->haname }}</td>
                                        <td>{{ $trailer->shippNumber }}</td>
                                        <td>{{ $trailer->trailer_id }}</td>
                                        <td>{{ $trailer->capacity }}</td>
                                        <td><a href="{{ route('hauler.edit.Trailer', $trailer->trid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('hauler.delete.trailer', $trailer->trid) }}"
                                                class="btn btn-danger">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- farms tab content --}}
            <div class="tab-content" id="farms">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" border>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Farm Name</th>
                                    <th>Farm ID</th>
                                    <th>Patron ID</th>
                                    <th>Latitude/longitude</th>
                                    <th>Route Number</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($farms as $farm)
                                    <tr>
                                        <td>{{ $farm->name }}</td>
                                        <td>{{ $farm->farm_id }}</td>
                                        <td>{{ $farm->patron_id }}</td>
                                        <td>{{ $farm->latitude }} / {{ $farm->longitude }}</td>
                                        <td>{{ $farm->route_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- tanks Tab Content -->
            <div class="tab-content" id="tanks">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" border>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tank ID</th>
                                    <th>Farm</th>
                                    <th>Farm ID</th>
                                    <th>Type</th>
                                    <th>Capacity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tanks as $tank)
                                    <tr>
                                        <td>{{ $tank->tank_id }}</td>
                                        <td>{{ $tank->fname }}</td>
                                        <td>{{ $tank->tankFarmId }}</td>
                                        <td>{{ $tank->type }}</td>
                                        <td>{{ $tank->capacity }} lbs </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tickets Tab Content -->
            <div class="tab-content" id="tickets">
                <div class="container py-2">
                    <table class="table table-striped table-dark" border>
                        <thead>
                            <th>Ticket Number</th>
                            <th>Driver Name</th>
                            <th>Driver Email</th>
                            <th>Truck ID</th>
                            <th>Trailer ID</th>
                            <th>Route Number</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->ticket_number }}</td>
                                    <td>{{ $ticket->uname }}</td>
                                    <td>{{ $ticket->uemail }}</td>
                                    <td>{{ $ticket->truckNumber }}</td>
                                    <td>{{ $ticket->trailerNumber }}</td>
                                    <td>{{ $ticket->route_number }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>{{ $ticket->createdAt }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="tab-content" id="chats">
            <div class="container" style="width: 786px;">
                @foreach ($messageUsers as $mu)
                    <div class="alert alert-primary">
                        <div class="row">
                            <div class="col-lg-10">
                                <h4>{{ $mu->name }}</h4>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('view.chat', $mu->uid) }}" class="btn btn-success"
                                    style="float: right;">View Chat</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    {{-- Chats tab content --}}



    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let totalMilk = document.getElementById('totalMilk').value;
        document.getElementById('showPrice').innerHTML = "$    " + totalMilk * 2;
        let price, totalPrice;

        function setPrice() {
            price = document.getElementById('price').value;
            totalPrice = price * totalMilk;
            document.getElementById('showPrice').innerHTML = "$" + totalPrice;
        }
        // Tab functionality
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all nav links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

                // Add active class to clicked link
                this.classList.add('active');

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Show selected tab content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>

</html>
