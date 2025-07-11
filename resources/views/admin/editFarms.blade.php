
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Farms</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
    </head>

    <body class="">
        {{-- {{ dd($id); }} --}}
        <h5 class="text-center bg-success p-1 text-white">Edit Farms' Information</h5>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
        @endif
        {{-- @foreach ($user as $u) --}}
            
        <form action="{{ route('admin.update.farm',$farm->id) }}" method="POST" class="m-5 p-5 border shadow-lg">
            @csrf
            <div class="row">
                
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="name" value="{{ $farm->name }}" class="form-control my-2" id="FullName" placeholder="Farm Full Name">
                        <label for="FullName">Farm Name</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="farm_id" value="{{ $farm->farm_id }}" class="form-control my-2" id="farmid" placeholder="Choose Unique Username">
                        <label for="farmid">Farm ID</label>
                        
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="patron_id" value="{{ $farm->patron_id }}"  class="form-control my-2" id="pid" placeholder="Patron ID">
                        <label for="pid">Patron ID</label>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-floating">
                        <input type="number"  name="latitude" value="{{ $farm->latitude }}" step="any" class="form-control my-2" id="lat" placeholder="Latitude">
                        <label for="lat">Latitude</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="number" step="any" name="longitude" value="{{ $farm->longitude }}" class="form-control my-2" id="long"  placeholder="longitude">
                        <label for="long">Longitude</label>
                    </div>
                </div>
                
                
                <div class="col-12">
                    <div class="form-floating text-center">
                        <button type="submit" class=" btn btn-success m-2 p-2 px-5" >Add Farm</button>
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