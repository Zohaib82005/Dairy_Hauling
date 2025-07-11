<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Route</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
</head>

<body class="">
    <h5 class="text-center bg-primary p-1 text-white">Updates Routes</h5>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <form action="{{ route('admin.update.route',$route->rid) }}" method="POST" class="m-5 p-5 border shadow-lg">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="form-floating">
                    <input type="text" name="route_number" value="{{ $route->route_number }}" required class="form-control my-2" id="truck_id" placeholder="Enter Truck ID">
                    <label for="truck_id">Route Number</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select name="hauler_id" id="" class="form-control my-2" required>
                        <option value="{{ $route->hid }}">{{$route->hname}} - {{$route->shippNumber}}</option>
                       @foreach ($haulers as $hauler)
                           
                       <option value="{{ $hauler->id }}">{{$hauler->name}} - {{$hauler->shipp_number}}</option>
                       @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select name="destination_plant" id="dp" class="form-control my-2" required>
                        <option value="{{ $route->pid }}">{{$route->pname}} - {{$route->paddress}}</option>
                       @foreach ($plants as $plant)
                           
                       <option value="{{ $plant->id }}">{{$plant->name}} - {{$plant->address}}</option>
                       @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating text-center">
                    <button type="submit" class=" btn btn-primary m-2 p-2 px-5" >Update Route</button>
                </div>
            </div>

        </div>
    </form>
</body>

</html>