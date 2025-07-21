<!DOCTYPE html>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Drivers</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
    </head>

    <body class="">
        {{-- {{ dd($id); }} --}}
        <h5 class="text-center bg-danger p-1 text-white">Edit Driver's Information</h5>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
        @endif
        {{-- @foreach ($user as $u) --}}
            
        <form action="{{ route('hauler.updateDriver',$id) }}" method="POST" class="m-5 p-5 border shadow-lg">
            @csrf
            <div class="row">
                
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="name" value="{{ $user->uname }}" class="form-control my-2" id="FullName" placeholder="Your Full Name">
                        <label for="FullName">Full Name</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="username" value="{{ $user->username }}" class="form-control my-2" id="username" placeholder="Choose Unique Username">
                        <label for="username">Username</label>
                        
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control my-2" id="email" placeholder="email">
                        <label for="email">Email</label>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-floating">
                        <input type="CNIC" name="cnic" class="form-control my-2" value="{{ $user->cnic }}" id="CNIC" placeholder="Confirm password">
                        <label for="CNIC">CNIC</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="address" class="form-control my-2" id="address" value="{{ $user->address }}" placeholder="Choose Unique address">
                        <label for="address">Address</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="licence_number" class="form-control my-2" value="{{ $user->licence_number }}" id="ln" placeholder="License Number">
                        <label for="ln">License Number</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="date" name="expiration_date" class="form-control my-2" value="{{ $user->expiration_date }}" id="epd" placeholder="Choose Unique Username">
                        <label for="epd">Expiration Date</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                      <input type="hidden" name="hauler_id" value="{{ session('haulerId') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating text-center">
                        <button type="submit" class=" btn m-2 p-2 px-5" style="background-color:#EDDD5E;">Update Driver</button>
                    </div>
                </div>
                
            </div>
        </form>
        {{-- @endforeach --}}
    </body>

    </html>

    <script>
        document.getElementById("viewPass").addEventListener("change", function () {
            const passwordField = document.getElementById("password");
            passwordField.type = this.checked ? "text" : "password";
         });
    </script>
</body>

</html>