<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Tanks</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/carousel-1.jpg') }}" type="image/x-icon">
</head>

<body class="">
    <h5 class="text-center bg-dark p-1 text-white">Update Tanks of Farms</h5>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <form action="{{ route('admin.update.tank',$tank->tankid) }}" method="POST" class="m-5 p-5 border shadow-lg">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="form-floating">
                    <select name="farm_id" id="farm_id" class="form-control">
                        <option value="{{ $tank->fid }}" selected>{{$tank->tfname}} |{{ $tank->tankFarmId }}</option>
                        @foreach ($farms as $farm)
                            <option value="{{ $farm->id }}">{{$farm->name}} | {{$farm->farm_id}}</option>
                        @endforeach
                    </select>
                    <label for="farm_id">Select Farm to which it relates</label>
                </div>
            </div>
             <div class="col-12">
                <div class="form-floating">
                    <input type="text" step="any" name="tank_id" value="{{ $tank->tank_id }}" id="tid" class="form-control my-2">
                    <label for="tid">Enter Tank ID</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select name="type" id="type" onclick="toShow()"  class="form-control my-2">
                        <option selected value="{{ $tank->type }}" >{{$tank->type}}</option>
                        <option value="cylindrical">Cylindrical</option>
                        <option value="rectangular" >Rectangular</option>
                    </select>
                    <label for="type">Select Type of Tank</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number" step="any" value="{{ $tank->height }}" name="height" id="height" class="form-control my-2">
                    <label for="height">Enter Height of Tank</label>
                </div>
            </div>
            <div class="col-12" id="toShowWidth">
                <div class="form-floating">
                    <input type="number" step="any" name="width" value="{{ $tank->width }}" id="Width" class="form-control my-2">
                    <label for="Width">Enter Width of Tank</label>
                </div>
            </div>
            <div class="col-12" id="toShowRadius">
                <div class="form-floating">
                    <input type="number" step="any" name="radius" value="{{ $tank->radius }}" id="radius" class="form-control my-2">
                    <label for="radius">Enter Radius of Tank</label>
                </div>
            </div>
            <div class="col-12" id="toShowLength">
                <div class="form-floating">
                    <input type="number" step="any" value="{{ $tank->length }}" name="length" id="length" class="form-control my-2">
                    <label for="length">Enter Length of Tank</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating text-center">
                    <button type="submit" class=" btn btn-dark m-2 p-2 px-5" >Update Tank</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let toShowWidth = document.getElementById("toShowWidth");
        let toShowRadius = document.getElementById("toShowRadius");
        let toShowLength = document.getElementById("toShowLength");
        toShowLength.style.display = "none";
        toShowRadius.style.display = "none";
        toShowWidth.style.display = "none";
        function toShow(){
            let option = document.getElementById("type").value;
            if(option === "cylindrical"){
                toShowRadius.style.display = "block";
                toShowLength.style.display = "none";
                toShowWidth.style.display = "none";
            }
            else if(option === "rectangular"){
                toShowLength.style.display = "block";
                toShowWidth.style.display = "block";
                toShowRadius.style.display = "none";
            }
        }
    </script>
</body>

</html>