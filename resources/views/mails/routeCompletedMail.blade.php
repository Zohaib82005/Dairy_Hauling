@php
    $data = DB::table('farm_stop_scans')->select('collected_milk')->where('user_id',Auth::user()->id)->where('ticket_id', $ticketID)->where('created_at',now()->format('y-m-d'))->get();
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
    <h4 class="text-center bg-success text-white">Route Completion Report</h4>
    <p>The User with name {{Auth::user()->name}} has completed his route Successfully.</p>
    <p>The Route and total milk collected information are given below: </p>
    <div class="col-12 bg-success text-white p-3">
        <p class="p-1">Ticket Number: <br> {{$ticket->ticket_number}}</p>
    </div>
    <div class="col-12 bg-success text-white p-3">
        <p class="p-1">Route Number: <br> {{$ticket->route_number}}</p>
    </div>
    <div class="col-12 bg-success text-white p-3">
        <p class="p-1">Truck Number: <br> {{$ticket->truckNumber}}</p>
    </div>
    <div class="col-12 bg-success text-white p-3">
        <p class="p-1">Trailer Number: <br> {{$ticket->trailerNumber}}</p>
    </div>
    <div class="col-12 bg-success text-white p-3">
        <p class="p-1">Collected Milk: <br> {{$totalMilk}}</p>
    </div>
</body>
</html>