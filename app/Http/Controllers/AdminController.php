<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Hauler;
use App\Models\Plant;
use App\Models\Route;
use App\Models\Tank;
use App\Models\Ticket;
use App\Models\Trailer;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminDashboard()
    {
       $users = User::join('haulers','users.hauler_id','=','haulers.id')
            ->select('users.id as uid', 'users.name as uname', 'username', 'email', 'password', 'cnic', 'users.address as uaddress', 'licence_number', 'expiration_date','haulers.id as haul_id','haulers.name as haulerName','haulers.shipp_number as shipNumber')
            ->get();
        $haulers = Hauler::select('id', 'name', 'address', 'shipp_number')->get();
        $trucks = Truck::join('haulers', 'trucks.hauler_id', '=', 'haulers.id')
            ->select('trucks.id as tid', 'truck_id', 'hauler_id', 'haulers.name as hauler_name', 'haulers.shipp_number as hauler_number')
            ->get();
        $farms = Farm::join('routes', 'farms.route_id', '=', 'routes.id')
            ->select('farms.id as fid', 'name', 'farm_id', 'patron_id', 'latitude', 'longitude', 'route_number')->get();
        $tanks = Tank::join('farms', 'tanks.farm_id', '=', 'farms.id')
            ->select('tanks.id as tankid', 'farms.name as fname', 'tank_id', 'farms.farm_id as tankFarmId', 'type', 'capacity')
            ->get();
        $plants = Plant::select('id', 'plant_id', 'name','email','latitude','longitude', 'address')->get();
        $trailers = Trailer::join('haulers', 'trailers.hauler_id', '=', 'haulers.id')
            ->select('trailers.id as trid', 'trailer_id', 'hauler_id as hid', 'haulers.name as haname', 'haulers.shipp_number as shippNumber', 'capacity')
            ->get();
        $routes = Route::join('haulers', 'routes.hauler_id', '=', 'haulers.id')
            ->select('routes.id as rid', 'haulers.name as hname', 'haulers.shipp_number as shipNumber', 'route_number')
            ->get();

        $tickets = Ticket::join('routes','tickets.route_id','=','routes.id')
                    ->join('trucks','tickets.truck_id','=','trucks.id')
                    ->join('trailers','tickets.trailer_id','=','trailers.id')
                    ->join('users','tickets.user_id','=','users.id')
                    ->select('ticket_number','users.name as uname','tickets.created_at as createdAt','users.email as uemail','route_number','trucks.truck_id as truckNumber','trailers.trailer_id as trailerNumber','tickets.signature','status')
                    ->orderBy('tickets.created_at','desc')
                    ->orderBy('status','desc')
                    ->get();
        $ticketCount = Ticket::where('status','active')->count();
        return view('admin.admin', compact('users', 'haulers', 'trucks', 'farms', 'tanks', 'plants', 'trailers', 'routes','tickets','ticketCount'));
    }
    public function controlDriver()
    {
        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();
        return view('admin.addDriver', compact('haulers'));
    }
    public function addDriver(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required',
            'password' => 'required|confirmed',
            'cnic' => 'required',
            'address' => 'required',
            'licence_number' => 'required',
            'expiration_date' => 'required',
            'hauler_id' => 'required'
        ]);

        $hashedPass = Hash::make($data['password']);
        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $hashedPass,
            'cnic' => $data['cnic'],
            'address' => $data['address'],
            'licence_number' => $data['licence_number'],
            'expiration_date' => $data['expiration_date'],
            'email_verified_at' => now(),
            'hauler_id' => $data['hauler_id'],
            'role' => 'User'
        ]);
        return redirect('/admin');
    }
    public function deleteDriver($id)
    {
        User::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function editDriver($id)
    {
        $user = User::join('haulers','users.hauler_id','=','haulers.id')
            ->select('users.id as uid', 'users.name as uname', 'username', 'email', 'password', 'cnic', 'users.address as uaddress', 'licence_number', 'expiration_date','haulers.id as haul_id','haulers.name as haulerName','haulers.shipp_number as shipNumber')
            ->where('users.id', $id)
            ->first();
        $haulers = Hauler::select('id','name','shipp_number')->get();
        // dd($user);
        return view('admin.editDriver', compact('user', 'id','haulers'));
    }

    public function updateDriver(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'cnic' => 'required',
            'address' => 'required',
            'licence_number' => 'required',
            'expiration_date' => 'required',
            'hauler_id' => 'required'
        ]);

        User::where('id', $id)->update([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'cnic' => $data['cnic'],
            'address' => $data['address'],
            'licence_number' => $data['licence_number'],
            'expiration_date' => $data['expiration_date'],
            'hauler_id' => $data['hauler_id']
        ]);

        return redirect('/admin');
    }

    public function addHauler(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'shipp_number' => 'required|unique:haulers,shipp_number,except,id'
        ]);

        Hauler::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'shipp_number' => $data['shipp_number']
        ]);

        return redirect('/admin');
    }

    public function editHauler($id)
    {
        $hauler = Hauler::select('id', 'name', 'address', 'shipp_number')
            ->where('id', $id)
            ->first();

        return view('admin.editHauler', compact('hauler', 'id'));
    }

    public function updateHauler(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'shipp_number' => 'required'
        ]);

        Hauler::where('id', $id)->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'shipp_number' => $data['shipp_number']
        ]);

        return redirect('/admin');
    }

    public function deleteHauler($id)
    {
        Hauler::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function addTruck()
    {
        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();
        return view('admin.addTrucks', compact('haulers'));
    }

    public function insertTruck(Request $request)
    {
        $data = $request->validate([
            'truck_id' => 'required|unique:trucks,truck_id',
            'hauler_id' => 'required|exists:haulers,id'
        ]);

        Truck::create([
            'truck_id' => $data['truck_id'],
            'hauler_id' => $data['hauler_id']
        ]);

        return redirect('/admin');
    }

    public function editTruck($id)
    {
        $truck = Truck::join('haulers', 'trucks.hauler_id', '=', 'haulers.id')
            ->select('trucks.id as tid', 'truck_id', 'hauler_id', 'haulers.name as hauler_name', 'haulers.shipp_number as hauler_number')
            ->where('trucks.id', $id)
            ->first();

        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();

        return view('admin.editTruck', compact('truck', 'haulers'));
    }

    public function updateTruck(Request $request, $id)
    {
        $data = $request->validate([
            'truck_id' => 'required',
            'hauler_id' => 'required|exists:haulers,id'
        ]);

        Truck::where('id', $id)->update([
            'truck_id' => $data['truck_id'],
            'hauler_id' => $data['hauler_id']
        ]);

        return redirect('/admin');
    }

    public function deleteTruck($id)
    {
        Truck::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function addFarm()
    {
        $routes = Route::select('id', 'route_number')->get();
        return view('admin.addFarms', compact('routes'));
    }

    public function insertFarm(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'farm_id' => 'required',
            'patron_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'route_numb' => 'required'
        ]);

        Farm::create([
            'name' => $data['name'],
            'farm_id' => $data['farm_id'],
            'patron_id' => $data['patron_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'route_id' => $data['route_numb']
        ]);

        return redirect('/admin');
    }

    public function editFarm($id)
    {
        $farm = Farm::select('id', 'name', 'farm_id', 'patron_id', 'latitude', 'longitude')->where('id', $id)->first();
        return view('admin.editFarms', compact('farm'));
    }

    public function deleteFarm($id)
    {
        Farm::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function updateFarm(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'farm_id' => 'required',
            'patron_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        Farm::where('id', $id)->update([
            'name' => $request->name,
            'farm_id' => $request->farm_id,
            'patron_id' => $request->patron_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect('/admin');
    }

    public function addTank()
    {
        $farms = Farm::select('id', 'name', 'farm_id')->get();
        return view('admin.addTanks', compact('farms'));
    }

    public function insertTank(Request $request)
    {
        $data = $request->validate([
            'farm_id' => 'required',
            'tank_id' => 'required',
            'type' => 'required',
            'height' => 'required',
            'radius' => 'required_if:type,cylindrical',
            'length' => 'required_if:type,rectangular',
            'width' => 'required_if:type,rectangular'
        ]);
        if ($request->type == "cylindrical") {
            $volume = ((3.14 * $data['radius'] * $data['radius'] * $data['height']) * 8.6) / 231;
        } else if ($request->type == "rectangular") {
            $volume = ($data['length'] * $data['width'] * $data['height']) * 7.4 * 8.6;
        } else {
            $volume = 0;
        }
        Tank::create([
            'farm_id' => $data['farm_id'],
            'tank_id' => $data['tank_id'],
            'type' => $data['type'],
            'height' => $data['height'],
            'radius' => $data['radius'],
            'width' => $data['width'],
            'length' => $data['length'],
            'capacity' => $volume
        ]);

        // dd($data['length']);
        return redirect('/admin');
    }

    public function editTank($id)
    {
        $tank = Tank::join('farms', 'tanks.farm_id', '=', 'farms.id')
            ->select('tanks.id as tankid', 'farms.name as tfname', 'tank_id', 'farms.farm_id as tankFarmId', 'type', 'capacity', 'width', 'radius', 'height', 'length')
            ->where('tanks.id', $id)
            ->first();
        $farms = Farm::select('id', 'name', 'farm_id')->get();
        return view('admin.editTanks', compact('tank', 'farms'));
    }

    public function updateTank(Request $request, $id)
    {
        $data = $request->validate([
            'farm_id' => 'required',
            'tank_id' => 'required',
            'type' => 'required',
            'height' => 'required',
            'radius' => 'required_if:type,cylindrical',
            'length' => 'required_if:type,rectangular',
            'width' => 'required_if:type,rectangular'
        ]);

        if ($request->type == "cylindrical") {
            $volume = ((3.14 * $data['radius'] * $data['radius'] * $data['height']) * 8.6) / 231;
        } else if ($request->type == "rectangular") {
            $length = $data['length'];
            $width = $data['width'];
            $height = $data['height'];

            $volume_ft3 = $length * $width * $height;
            $volume_gallons = $volume_ft3 * 7.48;
            $volume_pounds = $volume_gallons * 8.6;

            $volume = $volume_pounds;
        } else {
            $volume = 0;
        }

        Tank::where('id', $id)->update([
            'farm_id' => $data['farm_id'],
            'tank_id' => $data['tank_id'],
            'type' => $data['type'],
            'height' => $data['height'],
            'radius' => $data['radius'],
            'width' => $data['width'],
            'length' => $data['length'],
            'capacity' => $volume
        ]);

        return redirect('/admin');
    }

    public function deleteTank($id)
    {
        Tank::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function insertPlant(Request $request)
    {
        $request->validate([
            'plant_id' => 'required|unique:plants,plant_id',
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'email' =>'required'
        ]);

        // dd($request->plant_id);
        Plant::create([
            'plant_id' => $request->plant_id,
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'email' => $request->email
        ]);

        return redirect('/admin');
    }

    public function editPlant($id)
    {
        $plant = Plant::select('id', 'plant_id', 'name', 'address','email','latitude','longitude')->where('id', $id)->first();
        return view('admin.editPlant', compact('plant'));
    }

    public function updatePlant(Request $request, $id)
    {
        $request->validate([
            'plant_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'email' => 'required'
        ]);

        Plant::where('id', $id)
            ->update([
                'plant_id' => $request->plant_id,
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'email' => $request->email
            ]);
        return redirect('/admin');
    }
    public function deletePlant($id)
    {
        Plant::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function addTrailer()
    {
        $haulers = Hauler::select('id', 'shipp_number', 'name')->get();
        return view('admin.addTrailer', compact('haulers'));
    }

    public function insertTrailer(Request $request)
    {
        $request->validate([
            'trailer_id' => 'required',
            'capacity' => 'required',
            'hauler_id' => 'required'
        ]);

        Trailer::create([
            'trailer_id' => $request->trailer_id,
            'capacity' => $request->capacity,
            'hauler_id' => $request->hauler_id
        ]);

        return redirect('/admin');
    }

    public function editTrailer($id)
    {
        $trailer = Trailer::join('haulers', 'trailers.hauler_id', '=', 'haulers.id')
            ->select('trailers.id as trid', 'trailer_id', 'hauler_id', 'haulers.name as haname', 'haulers.shipp_number as shippNumber', 'capacity')
            ->where('trailers.id', $id)
            ->first();

        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();

        return view('admin.editTrailer', compact('trailer', 'haulers'));
    }

    public function updateTrailer(Request $request, $id)
    {
        $request->validate([
            'trailer_id' => 'required',
            'hauler_id' => 'required',
            'capacity' => 'required'
        ]);

        Trailer::where('id', $id)->update([
            'trailer_id' => $request->trailer_id,
            'hauler_id' => $request->hauler_id,
            'capacity' => $request->capacity
        ]);

        return redirect('/admin');
    }

    public function deleteTrailer($id)
    {
        Trailer::where('id', $id)->delete();
        return redirect('/admin');
    }

    public function addRoute()
    {
        $plants = Plant::select('id', 'name', 'address')->get();
        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();
        return view('admin.addRoute', compact('haulers', 'plants'));
    }

    public function insertRoute(Request $request)
    {
        $request->validate([
            'route_number' => 'required|unique:routes,route_number',
            'hauler_id' => 'required',
            'destination_plant' => 'required'
        ]);

        Route::create([
            'route_number' => $request->route_number,
            'hauler_id' => $request->hauler_id,
            'destination_plant' => $request->destination_plant
        ]);

        return redirect('/admin');
    }

    public function editRoute($id)
    {
        $route = Route::join('haulers', 'routes.hauler_id', '=', 'haulers.id')
            ->join('plants', 'routes.destination_plant', '=', 'plants.id')
            ->select('routes.id as rid', 'plants.id as pid', 'plants.name as pname', 'plants.address as paddress', 'haulers.id as hid', 'route_number', 'haulers.name as hname', 'haulers.shipp_number as shippNumber')
            ->where('routes.id', $id)
            ->first();
        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();
        $plants = Plant::select('id', 'name', 'address')->get();
        return view('admin.editRoute', compact('route', 'haulers', 'plants'));
    }

    public function updateRoute(Request $request, $id)
    {
        $request->validate([
            'hauler_id' => 'required',
            'route_number' => 'required',
            'destination_plant' => 'required'
        ]);

        Route::where('id', $id)->update([
            'hauler_id' => $request->hauler_id,
            'route_number' => $request->route_number,
            'destination_plant' => $request->destination_plant
        ]);

        return redirect('/admin');
    }

    public function deleteRoute($id)
    {
        Route::where('id', $id)->delete();
        return redirect('/admin');
    }
}
