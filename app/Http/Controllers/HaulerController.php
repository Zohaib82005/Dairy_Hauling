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
use App\Models\Chat;
use App\Models\Farm_stop_scan;
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
            ->select('users.id as uid', 'users.name as uname','latitude','longitude', 'users.username as usname', 'users.email as uemail', 'users.password as upassword', 'cnic', 'users.address as uaddress', 'licence_number', 'expiration_date','haulers.id as haul_id','haulers.name as haulerName','haulers.shipp_number as shipNumber')
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

        $messageUsers = Chat::join('users', 'chats.user_id', '=', 'users.id')
                    ->select('users.id as uid', 'name')
                    ->where('receiver_id',session('haulerId'))
                    ->groupBy('users.id', 'name')
                    ->orderBy('chats.id','desc')
                    ->get();
        $newMessages = Chat::where('hstatus','unseen')->count();
        $collectedMilk = Farm_stop_scan::join('users','farm_stop_scans.user_id','=','users.id')
                         ->select('collected_milk','method')
                         ->where('users.hauler_id',session('haulerId'))
                         ->get();
        $totalMilk = 0;
        if($collectedMilk != null){
            foreach($collectedMilk as $cm){
                if($cm->collected_milk == null){
                    continue;
                }
                $totalMilk = $totalMilk + $cm->collected_milk;
        }
        }
        $totalUser = User::where('role','User')->where('hauler_id',session('haulerId'))->count();
                    // dd($newMessages);
        $haulerName = Hauler::select('name')->where('id',session('haulerId'))->first();

        $activeUsers = User::join('tickets','users.id','=','tickets.user_id')
                        ->select('users.id as uid')
                        ->where('tickets.status','active')
                        ->where('users.hauler_id',$id)
                        ->get();
        // dd($activeUsers);
        return view('hauler.hauler', compact('activeUsers','users',  'trucks', 'trailers','tickets','ticketCount','farms','tanks','messageUsers','newMessages','totalMilk','totalUser','haulerName'));
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

    public function viewDriverLocation($id){
        $userLocation = User::select('latitude','longitude')->where('id',$id)->first();
        if($userLocation){
            return response()->json($userLocation);
        }
        return response()->json(['latitude'=> "Not Found", 'longitude'=>"Not Found"]);
    }

    public function viewChat($id){
        $userName = User::select('name')->where('id',$id)->first();
        $messages = Chat::select('id','sender_id','receiver_id','user_id','message')->where('user_id',$id)->get();
        Chat::where('hstatus','unseen')
        ->update([
            'hstatus'=>'seen'
        ]);
        return view('hauler.chat',compact('messages','id','userName'));
    }

    public function sendHaulerMessage(Request $request){
        $request->validate([
            'message' => 'required',
            'senderId' => 'required',
            'receiverId' => 'required'
        ]);

       $sent =  Chat::create([
            'sender_id' => $request->senderId,
            'receiver_id' => $request->receiverId,
            'message' => $request->message,
            'user_id' => $request->receiverId
        ]);
        if($sent){
            return response()->json(['status'=>"Sent"]);
            
        }
        return response()->json(['status'=>"not Sent"]);
    }

    public function getHaulerMessages(Request $request){
        $request->validate([
            'userid' => 'required'
        ]);
        $message = Chat::select('id','sender_id','receiver_id','message','user_id')->where('user_id',$request->userid)->where('hstatus','unseen')->get();

        if(!($message->isEmpty())){
            Chat::where('hstatus','unseen')
            ->where('user_id',$request->userid)
            ->update([
                'hstatus' => 'seen'
            ]);
        }

        // dd($message);
        
        return response()->json($message);
       
    }

    public function getUserProgress($id){
        $userProgress = Farm_stop_scan::join('farms','farm_stop_scans.farm_id','=','farms.farm_id')
                        ->join('tickets','farm_stop_scans.ticket_id','=','tickets.id')
                        ->select('farm_stop_scans.created_at as stopTime','farms.name as fname','collected_milk as totalMilk')->where('farm_stop_scans.user_id',$id)->where('status','active')->get();

        return response()->json(['userProgress'=>$userProgress]);
    }
}
