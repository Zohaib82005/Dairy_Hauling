<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Hauling Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
            <i class="fas fa-bolt"></i> Milk Hauling Admin
        </div>
        <nav class="nav flex-column">
            <button class="nav-link active" data-tab="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </button>

            <button class="nav-link" data-tab="haulers">
                <i class="fas fa-building"></i> Haulers
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

            <button class="nav-link" data-tab="plants">
                <i class="fas fa-place-of-worship"></i> Plants
            </button>

            <button class="nav-link" data-tab="routes">
                <i class="fa-solid fa-road"></i> Routes
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
                <a href="{{ route('addDriver') }}" class="btn btn-danger">Add Driver</a>
                <div class="row">
                    <script>
                        let lat;
                        let long;
                    </script>
                    @foreach ($users as $index => $user)
                        <div class="col-lg-4 col-md-6 shadow-lg p-3"
                            style="
                        overflow:scroll; scrollbar-width:none;">
                            <h5 class="bg-danger text-white p-1"><b>Name:</b> {{ $user->uname }}</h5>
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
                            <a href="{{ route('admin.editDriver', $user->uid) }}"
                                class="btn btn-primary mx-2">Edit</a><a
                                href="{{ route('admin.deleteDriver', $user->uid) }}"
                                class="btn btn-danger">Delete</a>
                            {{-- <a href="{{  }}" class="btn btn-success">Location</a> --}}
                            <!-- Small modal -->
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
                                            <span class="py-2 d-block"><strong>Location: </strong><span
                                                    id="location-{{ $index }}"></span></span>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#viewLocation-{{ $index }}').click(function() {
                                lat = document.getElementById('latitude-{{ $index }}');
                                long = document.getElementById('longitude-{{ $index }}');
                                let location = document.getElementById('location-{{ $index }}');
                                $.ajax({
                                    url: '/admin/viewLocation/{{ $user->uid }}',
                                    type: 'GET',
                                    success: function(response) {
                                        lat.innerHTML = response.latitude;
                                        long.innerHTML = response.longitude;
                                        fetch(
                                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${response.latitude}&lon=${response.longitude}`
                                                )
                                            .then(response => response.json())
                                            .then(data => {
                                                location.innerHTML =
                                                    `<i class="bi bi-check-circle me-2"></i>${data.display_name}`;
                                            })
                                            .catch(err => {
                                                location.innerHTML =
                                                    `<i class="bi bi-exclamation-triangle me-2"></i>Location not found`;
                                                lcate.classList.remove('bg-dark');
                                                lcate.parentElement.classList.add('bg-danger');
                                            });
                                    }

                                });
                            });
                        </script>
                    @endforeach
                </div>
            </div>

            <!-- haulers Tab Content -->
            <div class="tab-content" id="haulers">
                <a href="{{ route('admin.addHauler') }}" class="btn btn-warning">Add Hauler</a>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" border>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Shipp Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($haulers as $hauler)
                                    <tr>
                                        <td>{{ $hauler->name }}</td>
                                        <td>{{ $hauler->address }}</td>
                                        <td>{{ $hauler->email }}</td>
                                        <td>{{ $hauler->shipp_number }}</td>
                                        <td><a href="{{ route('admin.editHauler', $hauler->id) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.deleteHauler', $hauler->id) }}"
                                                class="btn btn-danger">Delete</a> <a
                                                href="{{ route('hauler.adminSide.login', $hauler->id) }}"
                                                class="btn btn-success">Login</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Trucks Tab Content -->
            <div class="tab-content" id="Trucks">
                <a href="{{ route('admin.add.trucks') }}" class="btn btn-primary my-2">Add Trucks</a>
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
                                        <td><a href="{{ route('admin.editTruck', $truck->tid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.deleteTruck', $truck->tid) }}"
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
                <a href="{{ route('admin.add.trailer') }}" class="btn btn-warning my-2">Add Trailer</a>
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
                                        <td><a href="{{ route('admin.edit.Trailer', $trailer->trid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.delete.trailer', $trailer->trid) }}"
                                                class="btn btn-danger">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Routes tab content --}}
            <div class="tab-content" id="routes">
                <a href="{{ route('admin.add.route') }}" class="btn btn-dark my-2">Add Routes</a>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" border>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Route Number</th>
                                    <th>Hauler </th>
                                    <th>Shipp Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routes as $route)
                                    <tr>
                                        <td>{{ $route->route_number }}</td>
                                        <td>{{ $route->hname }}</td>
                                        <td>{{ $route->shipNumber }}</td>

                                        <td><a href="{{ route('admin.edit.route', $route->rid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.delete.route', $route->rid) }}"
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
                <a href="{{ route('admin.addFarms') }}" class="btn btn-success my-2">Add Farms</a>
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
                                    <th>Action</th>
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
                                        <td><a href="{{ route('admin.edit.farm', $farm->fid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.delete.farm', $farm->fid) }}"
                                                class="btn btn-danger">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- tanks Tab Content -->
            <div class="tab-content" id="tanks">
                <a href="{{ route('admin.add.tank') }}" class="btn btn-dark my-2">Add Tanks</a>
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
                                    <th>Action</th>
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
                                        <td><a href="{{ route('admin.edit.tank', $tank->tankid) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.delete.tank', $tank->tankid) }}"
                                                class="btn btn-danger">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- plants Tab Content -->
            <div class="tab-content" id="plants">
                <a href="{{ route('admin.add.plant') }}" class="btn btn-success my-2 ">Add Plant</a>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" border>
                            <thead>
                                <th>Plant ID</th>
                                <th>Plant Name</th>
                                <th>Plant Address</th>
                                <th>Plant Email</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($plants as $plant)
                                    <tr>
                                        <td>{{ $plant->plant_id }}</td>
                                        <td>{{ $plant->name }}</td>
                                        <td>{{ $plant->address }}</td>
                                        <td>{{ $plant->email }}</td>
                                        <td>{{ $plant->latitude }}</td>
                                        <td>{{ $plant->longitude }}</td>
                                        <td><a href="{{ route('admin.edit.plant', $plant->id) }}"
                                                class="btn btn-primary">Edit</a> <a
                                                href="{{ route('admin.delete.plant', $plant->id) }}"
                                                class="btn btn-danger">Delete</a></td>
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
    </div>






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
