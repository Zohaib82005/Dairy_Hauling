
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit haulers</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
    </head>

    <body class="">
        {{-- {{ dd($id); }} --}}
        <h5 class="text-center bg-warning p-1 text-white">Edit Hauler's Information</h5>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
        @endif
        {{-- @foreach ($user as $u) --}}

        <form action="{{ route('admin.updateHauler',$hauler->id) }}" method="POST" class="m-5 p-5 border shadow-lg">
            @csrf
            <div class="row">

                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="name" value="{{ $hauler->name }}" class="form-control my-2" id="FullName" placeholder="Your Full Name">
                        <label for="FullName">Full Name</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="address" value="{{ $hauler->address }}" class="form-control my-2" id="add" placeholder="Address of Hauler Company">
                        <label for="add">Address</label>

                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="shipp_number" value="{{ $hauler->shipp_number }}" class="form-control my-2" id="sn" placeholder="2 digit hauler number">
                        <label for="sn">2 digit Shipp Number</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating text-center">
                        <button type="submit" class=" btn m-2 p-2 px-5 btn-warning" >Update Hauler</button>
                    </div>
                </div>

            </div>
        </form>
        {{-- @endforeach --}}
    </body>

    </html>