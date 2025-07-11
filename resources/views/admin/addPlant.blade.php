<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Plant</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
</head>

<body class="">
    <h5 class="text-center bg-success p-1 text-white">Add Trucks of Haulers</h5>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <form action="{{ route('admin.insert.plant') }}" method="POST" class="m-5 p-5 border shadow-lg">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="form-floating">
                    <input type="text" name="plant_id" required class="form-control my-2" id="plant_id" placeholder="Enter Plant ID">
                    <label for="plant_id">Plant ID</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" name="name" required class="form-control my-2" id="name" placeholder="Enter Name">
                    <label for="name">Name</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" name="address" required class="form-control my-2" id="Address" placeholder="Enter Address">
                    <label for="Address">Address</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="email" name="email" required class="form-control my-2" id="email" placeholder="Enter Email">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number" name="latitude" step="any" required class="form-control my-2" id="lat" placeholder="Enter Latitude">
                    <label for="lat">Latitude</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number" name="longitude" step="any" required class="form-control my-2" id="long" placeholder="Enter Longitude">
                    <label for="long">Longitude</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating text-center">
                    <button type="submit" class=" btn btn-success m-2 p-2 px-5" >Add Plant</button>
                </div>
            </div>

        </div>
    </form>
</body>

</html>