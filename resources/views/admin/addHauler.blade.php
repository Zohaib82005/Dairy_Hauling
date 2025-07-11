<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add haulers</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
</head>

<body class="">
    <h5 class="text-center bg-warning p-1 text-white">Add Hauler</h5>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <form action="{{ route('admin.add.hauler') }}" method="POST" class="m-5 p-5 border shadow-lg">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="form-floating">
                    <input type="text" name="name" class="form-control my-2" id="FullName" placeholder="Your Full Name">
                    <label for="FullName">Full Name</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" name="address" class="form-control my-2" id="address" placeholder="Address of Haulers">
                    <label for="address">Address</label>

                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number" max="99" min="10" name="shipp_number" class="form-control my-2" id="shipNumber" placeholder="Ship Number 2 digit">
                    <label for="shipNumber">2 Digit Shipp Number</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating text-center">
                    <button type="submit" class=" btn btn-warning m-2 p-2 px-5" >Add Hauler</button>
                </div>
            </div>

        </div>
    </form>
</body>

</html>