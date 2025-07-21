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
use Illuminate\Support\Facades\Crypt;

class HaulerController extends Controller
{
    public function haulerLogin(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',

        ]);
        $hauler = Hauler::select('id','username', 'password')->get();
        // dd($hauler, $request);
        $found = false;
        $haulerId = 0;
        foreach($hauler as $h){
            $password = Crypt::decrypt($h->password);
            if($request->username == $h->username && $request->password == $password){
                $found = true;
                $haulerId = $h->id;
                session()->put('haulerId', $haulerId);
                break;
            }
        }
        if($found){
                session()->put('haulerLogin', "Yes");
                $found = false;
                return redirect('/viewHauler/'.$haulerId);
            }else{
                // dd($password);
                $validator = "Incorrect Username or Password";
                return back()->withErrors($validator);
        }
    }
    public function hauler($id){
        $users = User::join('haulers','users.hauler_id','=','haulers.id')
            ->select('users.id as uid', 'users.name as uname', 'users.username as usname', 'users.email as uemail', 'users.password as upassword', 'cnic', 'users.address as uaddress', 'licence_number', 'expiration_date','haulers.id as haul_id','haulers.name as haulerName','haulers.shipp_number as shipNumber')
            ->where('haulers.id' , $id)
            ->get();
       
        $trucks = Truck::join('haulers', 'trucks.hauler_id', '=', 'haulers.id')
            ->select('trucks.id as tid', 'truck_id', 'hauler_id', 'haulers.name as hauler_name', 'haulers.shipp_number as hauler_number')
            ->where('haulers.id', $id)
            ->get();
        $farms = Farm::join('routes', 'farms.route_id', '=', 'routes.id')
            ->select('farms.id as fid', 'name', 'farm_id', 'patron_id', 'latitude', 'longitude', 'route_number')
            ->where('routes.hauler_id',$id)
            ->get();
        $tanks = Tank::join('farms', 'tanks.farm_id', '=', 'farms.id')
            ->join('routes','farms.route_id','=','routes.id')
            ->select('tanks.id as tankid', 'farms.name as fname', 'tank_id', 'farms.farm_id as tankFarmId', 'type', 'capacity')
            ->where('routes.hauler_id', $id)
            ->get();
        $trailers = Trailer::join('haulers', 'trailers.hauler_id', '=', 'haulers.id')
            ->select('trailers.id as trid', 'trailer_id', 'hauler_id as hid', 'haulers.name as haname', 'haulers.shipp_number as shippNumber', 'capacity')
            ->where('haulers.id', $id)
            ->get();
       
        $tickets = Ticket::join('routes','tickets.route_id','=','routes.id')
                    ->join('trucks','tickets.truck_id','=','trucks.id')
                    ->join('trailers','tickets.trailer_id','=','trailers.id')
                    ->join('users','tickets.user_id','=','users.id')
                    ->select('ticket_number','users.name as uname','tickets.created_at as createdAt','users.email as uemail','route_number','trucks.truck_id as truckNumber','trailers.trailer_id as trailerNumber','tickets.signature','status')
                    ->where('routes.hauler_id',$id)
                    ->orderBy('tickets.created_at','desc')
                    ->orderBy('status','desc')
                    ->get();
        $ticketCount = Ticket::join('users','tickets.user_id','=','users.id')
                       ->where('status','active')
                       ->where('users.hauler_id',$id)
                       ->count();
        return view('hauler.hauler', compact('users',  'trucks', 'trailers','tickets','ticketCount','farms','tanks'));
    }

    public function editDriver($id)
    {
        $user = User::select('users.id as uid', 'users.name as uname','username', 'email','licence_number','expiration_date','address','cnic')
            ->where('id', $id)
            ->first();
        // dd($user);
        return view('hauler.editDriver', compact('user', 'id'));
    }

    public function deleteDriver($id)
    {
        User::where('id', $id)->delete();
        return redirect('/viewHauler/'.session('haulerId'));
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
        return redirect('/viewHauler/'.session('haulerId'));
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

        return redirect('/viewHauler/'.session('haulerId'));
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

    return redirect('/viewHauler/'.session('haulerId'));    
}

    public function editTruck($id)
    {
        $truck = Truck::select('trucks.id as tid', 'truck_id', 'hauler_id')
            ->where('trucks.id', $id)
            ->first();


        return view('hauler.editTruck', compact('truck'));
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

return redirect('/viewHauler/'.session('haulerId'));
    }

    public function deleteTruck($id)
    {
        Truck::where('id', $id)->delete();
        return redirect('/viewHauler/'.session('haulerId'));
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

        return redirect('/viewHauler/'.session('haulerId'));

    }

    public function editTrailer($id)
    {
        $trailer = Trailer::join('haulers', 'trailers.hauler_id', '=', 'haulers.id')
            ->select('trailers.id as trid', 'trailer_id', 'hauler_id', 'haulers.name as haname', 'haulers.shipp_number as shippNumber', 'capacity')
            ->where('trailers.id', $id)
            ->first();

        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();

        return view('hauler.editTrailer', compact('trailer', 'haulers'));
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

        return redirect('/viewHauler/'.session('haulerId'));
    }

    public function deleteTrailer($id)
    {
        Trailer::where('id', $id)->delete();
        return redirect('/viewHauler/'.session('haulerId'));
    }


}
