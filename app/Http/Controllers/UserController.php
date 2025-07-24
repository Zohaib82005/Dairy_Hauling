<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetEmail;
use App\Mail\SendPdfMail;
use App\Mail\VerifyEmail;
use App\Mail\RouteCompletedMail;
use App\Models\Farm;
use App\Models\Farm_stop_scan;
use App\Models\Hauler;
use App\Models\Plant;
use App\Models\Route;
use App\Models\Tank;
use App\Models\Ticket;
use App\Models\Trailer;
use App\Models\Truck;
use App\Models\Chat;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $hashedPassword = Hash::make($data['password']);

        User::create($data);

        $otp = rand(10000, 99999);
        Session::put('otp', $otp);
        Session::put('otp_email', $data['email']);

        Mail::to($data['email'])->send(new VerifyEmail($otp, "Verify Email Address"));

        return view('verifyEmail');
    }

    public function verifyEmails(Request $request)
    {
        $otpData = $request->validate([
            'otp' => 'required'
        ]);


        $storedOtp = Session::get('otp');
        $email = Session::get('otp_email');

        if ($storedOtp == $request->otp) {
            Session::forget('otp');
            Session::forget('otp_email');


            User::where('email', $email)->update(['email_verified_at' => now()]);

            return view('login');
        }

        return back()->with('error', 'OTP is incorrect.');
    }

    public function dashboard()
    {
        $tickets = Ticket::join('routes', 'tickets.route_id', '=', 'routes.id')
            ->join('haulers', 'routes.hauler_id', '=', 'haulers.id')
            ->select('tickets.id as tkid', 'routes.id as rid', 'status', 'route_number', 'ticket_number', 'haulers.name as hname')
            ->where('tickets.user_id', Auth::user()->id)
            ->whereNot('status','completed')
            // ->where('tickets.status', 'active')          
            // ->Where('status','inactive')
            ->orderBy('tickets.id', 'desc')
            ->get();
        $previousTickets = Ticket::join('routes', 'tickets.route_id', '=', 'routes.id')
            ->join('haulers', 'routes.hauler_id', '=', 'haulers.id')
            ->join('trucks','tickets.truck_id','=','trucks.id')
            ->join('trailers','tickets.trailer_id','=','trailers.id')
            ->select('tickets.id as tkid', 'routes.id as rid', 'status', 'route_number', 'ticket_number', 'haulers.name as hname','trucks.truck_id as truckId','trailers.trailer_id as trailerId')
            ->where('tickets.user_id', Auth::user()->id)
            ->where('status','completed')
            ->orderBy('tickets.id', 'desc')
            ->get();

            $messages = Chat::select('id','sender_id','receiver_id','message','user_id')->where('user_id',Auth::user()->id)->get();
        return view('dashboard', compact('tickets','previousTickets','messages'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            if (Auth::user()->role == "Admin") {
                return redirect('/admin');
            } else if (Auth::user()->role == "User") {

                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->with('message', 'Incorrect Username Or Password');
    }

    public function sendLink(Request $request)
    {
        $data = $request->validate([
            'email' => 'required'
        ]);
        $findEmail = DB::table('users')->where('email', $request->email)->get();

        if ($findEmail->isNotEmpty()) {

            $token = Str::random(16);


            Mail::to($request->email)->send(new PasswordResetEmail($token, "Reset Your Password"));
            $insert = DB::table('password_reset_tokens')
                ->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now()
                ]);
            return back()->with('mess', "Link Sent Successfully");
        }
        return back()->with('mess', "Account with this email does not exists!");
    }

    public function updatePassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);
        $hashedPassword = Hash::make($request->password);
        $getEmail = DB::table('password_reset_tokens')
            ->select('email')
            ->where('token', $token)
            ->first();

        $updatePass =  DB::table('users')
            ->where('email', $getEmail->email)
            ->update([
                'password' => $hashedPassword
            ]);

        return redirect()->route('user.login')->with('message', "Password Updated Successfully. Please Login now to continue");
    }

    public function showCP()
    {
        $haulers = Hauler::select('id', 'name', 'shipp_number')->get();
        return view('completeProfile', compact('haulers'));
    }

    public function completeProfile(Request $request)
    {
        $data = $request->validate([
            'cnic' => 'required',
            'licence_number' => 'required',
            'address' => 'required',
            'expiration_date' => 'required',
            'hauler_id' => 'required'
        ]);

        User::where('id', Auth::user()->id)->update([
            'cnic' => $data['cnic'],
            'address' => $data['address'],
            'licence_number' => $data['licence_number'],
            'expiration_date' => $data['expiration_date'],
            'hauler_id' => $data['hauler_id']
        ]);

        return redirect('/dashboard');
    }

    public function ticket()
    {
        $routes = Route::select('routes.id as rid', 'route_number')
            ->where('hauler_id', Auth::user()->hauler_id)->get();
        $trucksInUse = Ticket::select('truck_id')->where('status', 'active')->get();
        $trailersInUse = Ticket::select('trailer_id')->where('status', 'active')->get();
        $trucks = Truck::select('id', 'truck_id', 'hauler_id')->where('hauler_id', Auth::user()->hauler_id)->whereNotIn('id', $trucksInUse)->get();
        $trailers = Trailer::select('id', 'trailer_id', 'hauler_id')->where('hauler_id', Auth::user()->hauler_id)->whereNotIn('id', $trailersInUse)->get();
        return view('ticket', compact('routes', 'trucks', 'trailers'));
    }

    public function storeTicket(Request $request)
{
    $data = $request->validate([
        'route_numb' => 'required',
        'ticket_number' => 'required|unique:tickets,ticket_number',
        'truckId' => 'required',
        'trailerId' => 'required',
        'pickupDate' => 'required',
        'signature' => 'required'
    ]);

 
    $image = $request->input('signature'); 
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $imageData = base64_decode($image);

   
    $fileName = 'signature_' . time() . '.png';
    $filePath = 'signatures/' . $fileName;
// dd($filePath);
   $store =  Storage::disk('public')->put($filePath, $imageData);
// dd($store);
    // Create the ticket record
    Ticket::create([
        'route_id' => $data['route_numb'],
        'ticket_number' => $data['ticket_number'],
        'truck_id' => $data['truckId'],
        'trailer_id' => $data['trailerId'],
        'pickup_date' => $data['pickupDate'],
        'signature' => $filePath, // Save path in DB
        'user_id' => Auth::id()
    ]);

    return redirect('/dashboard')->with('success', 'Ticket created successfully.');
}

    public function viewRoutes($ticketID)
    {
        //  $farmStops = Farm_stop_scan::
        //                 select('id','farm_id','patron_id')->get();
        Ticket::where('id',$ticketID)->update([
            'status' => 'active'
        ]);
        $collectedMilkTanks = Farm_stop_scan::select('tank_id')->where('user_id', Auth::user()->id)->where('ticket_id', $ticketID)->get();
        
        $routeID = Ticket::select('route_id')->where('id',$ticketID)->first();
$ticketFarm = Farm_stop_scan::where('ticket_id', $ticketID)
            ->pluck('farm_id')
            ->toArray();
        $farmsInRoute = Farm::select('name','latitude','longitude')
                        ->where('route_id',$routeID->route_id)
                        ->whereNotIn('farm_id',$ticketFarm)
                        ->orderBy('latitude','asc')
                        ->get();
        // dd($farmsInRoute);
        // dd($routeID);
        // dd($farmsInRoute);
        $tickets = Ticket::join('routes', 'tickets.route_id', '=', 'routes.id')
            ->join('haulers', 'routes.hauler_id', '=', 'haulers.id')
            ->join('trucks', 'tickets.truck_id', '=', 'trucks.id')
            ->join('trailers', 'tickets.trailer_id', '=', 'trailers.id')
            ->join('plants','routes.destination_plant','=','plants.id')
            ->select('tickets.id as tkid','pickup_date', 'ticket_number', 'routes.id as rid','plants.latitude as platitude','plants.longitude as plongitude', 'status', 'route_number', 'ticket_number', 'haulers.name as hname', 'shipp_number', 'trucks.truck_id as truckID', 'trailers.trailer_id as trailerID', 'capacity')
            ->where('tickets.user_id', Auth::user()->id)
            ->where('tickets.status', 'active')
            ->where('tickets.id', $ticketID)
            ->first();

        $collectedFarms = Farm_stop_scan::join('farms','farms.farm_id','=','farm_stop_scans.farm_id')
        ->join('tanks','farm_stop_scans.tank_id','=','tanks.tank_id')
        ->select('farms.name as fname','method','tanks.tank_id as tankId','collected_milk','farm_stop_scans.created_at as farmCollectedAt')
        ->where('ticket_id', $ticketID)
        ->where('user_id',Auth::user()->id)
        ->get();

        // $farmsInRoutes = 

        return view('viewRoutes', compact('collectedFarms','farmsInRoute', 'tickets', 'ticketID'));
    }

    public function viewFarmStopDetails($ticketID)
    {
        $farm = Farm::select('id', 'name', 'farm_id', 'patron_id')->first();
        $ticketFarm = Farm_stop_scan::where('user_id', Auth::user()->id)
            ->where('ticket_id', $ticketID)
            ->pluck('tank_id')
            ->toArray();

        $tans = Tank::select('id as tankid', 'tank_id', 'type', 'height', 'radius', 'width', 'length', 'capacity')
            ->whereNotIn('id', $ticketFarm)
            ->get();

        $farms = Farm::join('routes','farms.route_id','=','routes.id')
                ->join('haulers','haulers.id','=','routes.hauler_id')
                ->join('users','haulers.id','=','users.hauler_id')
                ->select('farms.id as fid','haulers.id as hid','farms.farm_id as farmID','farms.patron_id as farmPtrID','farms.latitude as flat','farms.longitude as flong')
                ->where('haulers.id',Auth::user()->hauler_id)
                ->where('users.id',Auth::user()->id)
                ->get();
        // dd($farms);
       
        
        // dd($tanks);
        return view('addFarmStop', compact('ticketID'));
    }

    public function showTank(Request $request, $farmID)
    {
        // dd($request);
        $request->validate([
            'tankId' => 'required',
            'ticketID' => 'required',
        ]);
        $ticketID = $request->ticketID;

        $farm = Farm::select('id', 'name', 'farm_id', 'patron_id')->where('id', $farmID)->first();
        $tanks = Tank::join('farms', 'tanks.farm_id', '=', 'farms.id')
            ->select('tanks.id as tankid', 'farms.id as farmid', 'tank_id', 'type', 'height', 'radius', 'width', 'length', 'capacity')
            ->where('tanks.farm_id', $farmID)
            ->get();

        $oneTank = Tank::select('id', 'tank_id', 'type', 'height', 'radius', 'width', 'length', 'capacity')
            ->where('id', $request->tankId)
            ->first();

        return view('addFarmStop', compact('farm', 'tanks', 'oneTank', 'ticketID'));
    }

    public function addFarmStop(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required',
            'farm_id' => 'required',
            'tank_id' => 'required',
            'calculated_milk' => 'required',
            'patron_id' => 'required',
            'method' => 'required',
            'ticketID' => 'required'
        ]);
        // var_dump($request);
        // session('tracking_id',$request->tracking_id);
        // Session::put('tracking_id',$request->tracking_id);
        Farm_stop_scan::create([
            'tracking_id' => $request->tracking_id,
            'tank_id' => $request->tank_id,
            'collected_milk' => $request->calculated_milk,
            'farm_id' => $request->farm_id,
            'patron_id' => $request->ticketID,
            'method' => $request->method,
            'ticket_id' => $request->ticketID,
            'user_id' => Auth::user()->id,
            'created_at' => (now()->format('y-m-d'))

        ]);

        return redirect('/dashboard/view/route/' . $request->ticketID);
    }

    public function destinationPlant($ticketID)
    {
        $routeID = Ticket::select('route_id')->where('id',$ticketID);
        $destinationPlant = Route::join('plants', 'routes.destination_plant', '=', 'plants.id')
            ->select('route_number', 'routes.id as rid', 'plants.id as pid', 'name', 'latitude', 'longitude','email')
            ->where('routes.id', $routeID)
            ->first();
        // Ticket::where('id', $ticketID)
        //     ->update(
        //         [
        //             'status' => 'inactive'
        //         ]
        //     );
            $data = [
            'ticketID' => $ticketID,
            'userId' => Auth::user()->id
        ];
        Mail::to('mzohaibfakhar786@gmail.com')->send(new SendPdfMail($data));
        return view('destinationPlant', compact('destinationPlant', 'ticketID'));
    }

    public function viewScaleAtPlant($ticketID)
    {
        return view('scaleAtPlant', compact('ticketID'));
    }

    public function collectMilkAtPlant(Request $request, $ticketID)
    
    {
        // dd($request);
        $method = Farm_stop_scan::select('method')->where('ticket_id',$ticketID)->first();
        $request->validate([
            'temprature',
            'collected_milk'
        ]);

        
        if ($request->collected_milk == null) {
            Farm_stop_scan::where('user_id', Auth::user()->id)
                ->where('ticket_id', $ticketID)
                ->update(
                    [
                        'temprature' => $request->temprature,

                    ]
                );
        }else{
             Farm_stop_scan::where('user_id', Auth::user()->id)
                ->where('ticket_id', $ticketID)
                ->where('method', 'Scale At Plant')
                ->latest() 
                ->first()
                ->update(
                    [
                        'temprature' => $request->temprature,
                        'collected_milk' => $request->collected_milk

                    ]
                );
        }
        // dd($request);

        Ticket::where('id',$ticketID)
        ->update([
            'status' => 'completed'
        ]);
        
        Mail::to("mzohaibfakhar786@gmail.com")->send(new RouteCompletedMail($ticketID));
        
        return redirect('/dashboard')->with('message', 'Congratulations!😍 You have Completed your Route Successfully.');
    }

    public function closeRoute($ticketID)
    {
        Ticket::where('id', $ticketID)
            ->update(
                [
                    'status' => 'completed'
                ]
            );
        $data = [
            'ticketID' => $ticketID,
            'userId' => Auth::user()->id
        ];
        Mail::to('mzohaibfakhar786@gmail.com')->send(new SendPdfMail($data));
        return redirect('/dashboard')->with('message', 'Congratulations!😍 You have Completed your Route Successfully.');
    }
    public function sendPdf()
    {
        
        $data = [
            'ticketID' => 22,
            'userId' => Auth::user()->id
        ];
        Mail::to('mzohaibfakhar786@gmail.com')->send(new SendPdfMail($data));


        $pdf = Pdf::loadView('pdfsend', $data);

        return $pdf->stream('userprogress.pdf');
    }

    public function checkData(Request $request){
        $farms = Farm::join('routes','farms.route_id','=','routes.id')
                ->join('haulers','haulers.id','=','routes.hauler_id')
                ->join('users','haulers.id','=','users.hauler_id')
                ->select('farms.id as fid','haulers.id as hid','farms.farm_id as farmID','farms.patron_id as farmPtrID','farms.latitude as flat','farms.longitude as flong')
                ->where('haulers.id',Auth::user()->hauler_id)
                ->where('users.id',Auth::user()->id)
                ->get();
         $tanks = Tank::join('farms','tanks.farm_id','=','farms.id')
                 ->join('routes','farms.route_id','=','routes.id')
                 ->join('haulers','haulers.id','=','routes.hauler_id')
                 ->join('users','haulers.id','=','users.hauler_id')
                 ->select('tanks.id as tid','tanks.tank_id as tankID','length','radius','width','height','type','capacity')
                 ->where('haulers.id',Auth::user()->hauler_id)
                 ->where('users.id',Auth::user()->id)
                 ->get();   
        foreach($farms as $farm){
            if($farm->farmID == $request->farmId && $farm->farmPtrID == $request->patronId){
                foreach($tanks as $tank){
                    if($tank->tankID == $request->tankId){
                        return response()->json([
                            'farmId'=> $farm->farmID, 
                            'patronId' => $farm->farmPtrID, 
                            'tankId' => $tank->tankID,
                            'height' => $tank->height,
                            'radius' => $tank->radius,
                            'length' => $tank->length,
                            'width' => $tank->width,
                            'type' => $tank->type,
                            'capacity' => $tank->capacity,
                            'trackingId' => $request->trackingId,
                            'data' => "found"
                        ]);
                    }
                }
            }
        }
        return response()->json(['data'=> "not Found"]);
    }

    public function sendMessage(Request $request){
        $request->validate([
            'message' => 'required',
        ]);

       $sent =  Chat::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => Auth::user()->hauler_id,
            'message' => $request->message,
            'user_id' => Auth::user()->id
        ]);
        if($sent){
            return response()->json(['status'=>"Sent"]);
            
        }
        return response()->json(['status'=>"not Sent"]);

    }

    public function getMessages(){
        $message = Chat::select('id','sender_id','receiver_id','message','user_id')->where('user_id',Auth::user()->id)->where('status','unseen')->get();
        if(!($message->isEmpty())){
            Chat::where('status','unseen')
            ->where('user_id',Auth::user()->id)
            ->update([
                'status' => 'seen'
            ]);
        }
        return response()->json($message);
       
    }
}
