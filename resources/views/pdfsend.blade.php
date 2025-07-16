@php
    $data = DB::table('farm_stop_scans')->select('collected_milk')->where('user_id',$userId)->where('ticket_id', $ticketID)->get();
    $totalMilk = 0;
    foreach ($data as $d) {
        $totalMilk = $totalMilk + $d->collected_milk;
    }

    $ticket = DB::table('tickets')->join('routes','tickets.route_id','=','routes.id')
                                  ->join('trucks','tickets.truck_id','=','trucks.id')
                                  ->join('trailers','tickets.trailer_id','=','trailers.id')
                                  ->select('route_number','ticket_number','trucks.truck_id as truckNumber','trailers.trailer_id as trailerNumber')
                                  ->where('tickets.id',$ticketID)
                                  ->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Route Completion Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .report-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            border-radius: 10px 10px 0 0;
        }
        .report-body {
            background: #f8f9fa;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .milk-total {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: burlywood;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            margin: 1rem 0;
        }
        .info-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .success-badge {
            background: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            display: inline-block;
        }
        .report-container {
            max-width: 600px;
            margin: 2rem auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="report-container">
            <!-- Header Section -->
            <div class="report-header text-center">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                </div>
                <h2 class="mb-2">Route Completion Report</h2>
                <div class="success-badge">
                    <i class="bi bi-check2"></i> Route Completed Successfully
                </div>
            </div>

            <!-- Body Section -->
            <div class="report-body p-4">
                <!-- Greeting -->
                <div class="mb-4">
                    <h4 class="text-primary">
                        <i class="bi bi-person-circle me-2"></i>Dear Sir,
                    </h4>
                </div>

                <!-- Main Message -->
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Route Completion Notice:</strong> I am very pleased to inform you that I have successfully completed my assigned route and collected all required milk samples. I am coming to your plant with the estimated time:

                    <span class="p-2 bg-primary text-white">{{session('arrivalTime')}}</span>
                </div>

                <!-- Milk Collection Summary -->
                <div class="milk-total">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <i class="bi bi-droplet-fill" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-1">Total Milk Collected</h3>
                            <h2 class="mb-0">{{ $totalMilk }} Liters</h2>
                        </div>
                    </div>
                </div>

                <!-- Details Cards -->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="p-2">
                                <h3>Driver name: </h3>
                                <p>{{Auth::user()->name}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-2">
                                <h3>Ticket Number: </h3>
                                <p>{{$ticket->ticket_number}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="p-2">
                                <h3>Truck ID: </h3>
                                <p>{{$ticket->truckNumber}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-2">
                                <h3>Trailer ID: </h3>
                                <p>{{$ticket->trailerNumber}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Additional Info -->
                <div class="info-card mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-check text-info me-2"></i>
                                <div>
                                    <small class="text-muted">Completion Date</small>
                                    <div class="fw-bold">{{ now()->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock text-warning me-2"></i>
                                <div>
                                    <small class="text-muted">Completion Time</small>
                                    <div class="fw-bold">{{ now()->format('h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Message -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        This report has been automatically generated upon route completion.
                        Please Don't reply on this email.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>