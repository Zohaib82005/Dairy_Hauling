<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HaulerController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckHauler;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

//haulers routes
Route::get('/hauler/login', function(){
    return vieW('haulerLogin');
})->name('hauler.gologin');

Route::post('/checkhauler/login',[HaulerController::Class,'haulerLogin'])->name('hauler.login');
Route::middleware([CheckHauler::class])->group(function(){
    Route::get('/viewHauler/{id}',[HaulerController::class, 'hauler'])->name('hauler.dashboard');
// done
    Route::get('/hauler/addDrivers',function(){
        return view('hauler.addDriver');
    })->name('hauler.addDriver');
    Route::post('/hauler/addDrver',[HaulerController::class, 'addDriver'])->name('hauler.add.driver');
    Route::get('/hauler/delete/{id}',[HaulerController::class, 'deleteDriver'])->name('hauler.deleteDriver');
    Route::get('/hauler/drivers/edit/{id}', [HaulerController::class, 'editDriver'])->name('hauler.editDriver');
    Route::post('/hauler/drivers/update/{id}', [HaulerController::class, 'updateDriver'])->name('hauler.updateDriver');
//haulers add trucks
// done
    Route::get('/hauler/addTrucks',function (){
        return view('hauler.addTrucks');
    })->name('hauler.add.trucks');
    Route::post('/hauler/truck/add',[HaulerController::class,'insertTruck'])->name('hauler.insert.truck');
    Route::get('/hauler/trucks/edit/{id}', [HaulerController::class, 'editTruck'])->name('hauler.editTruck');
    Route::post('/hauler/trucks/update/{id}', [HaulerController::class, 'updateTruck'])->name('hauler.updateTruck');
    Route::get('/hauler/trucks/delete/{id}', [HaulerController::class, 'deleteTruck'])->name('hauler.deleteTruck');
    
    //admin Trailers routes done
    Route::get('/hauler/addTrailer',function(){
        return view('hauler.addTrailer');
    })->name('hauler.add.trailer');
    Route::post('/hauler/insertTrailer',[HaulerController::class, 'insertTrailer'])->name('hauler.insert.trailer');
    Route::get('/hauler/editTrailer/{id}',[HaulerController::class, 'editTrailer'])->name('hauler.edit.Trailer');
    Route::post('/hauler/updateTrailer/{id}',[HaulerController::class, 'updateTrailer'])->name('hauler.update.trailer');
    Route::get('/hauler/deletetrailer/{id}',[HaulerController::class,'deleteTrailer'])->name('hauler.delete.trailer');

    Route::get('/hauler/viewLocation/{id}',[HaulerController::class, 'viewDriverLocation']);
    Route::get('/hauler/chat/{id}',[HaulerController::class, 'viewChat'])->name('view.chat');
    Route::post('/sendHaulerMessage',[HaulerController::class, 'sendHaulerMessage']);
    Route::get('/getHaulerMessages',[HaulerController::class, 'getHaulerMessages']);

    Route::get('/getUserProgress/{id}',[HaulerController::class, 'getUserProgress']);
});

//admin routes
Route::middleware([CheckAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class, 'adminDashboard'])->name('admin.login');
    // Admin Driver Routes
    Route::get('/admin/addDrivers',[AdminController::class ,'controlDriver'])->name('addDriver');
    Route::post('/addDrver',[AdminController::class, 'addDriver'])->name('admin.add.driver');
    Route::get('/admin/delete/{id}',[AdminController::class, 'deleteDriver'])->name('admin.deleteDriver');
    Route::get('/admin/drivers/edit/{id}', [AdminController::class, 'editDriver'])->name('admin.editDriver');
    Route::post('/admin/drivers/update/{id}', [AdminController::class, 'updateDriver'])->name('admin.updateDriver');

    // Admin Hauler Routes
    Route::get('/admin/addHauler',function (){
        return view('admin.addHauler');
    })->name('admin.addHauler');
    Route::post('/addHauler', [AdminController::class, 'addHauler'])->name('admin.add.hauler');
    Route::get('/admin/haulers/edit/{id}', [AdminController::class, 'editHauler'])->name('admin.editHauler');
    Route::post('/admin/haulers/update/{id}', [AdminController::class, 'updateHauler'])->name('admin.updateHauler');
    Route::get('/admin/haulers/delete/{id}', [AdminController::class, 'deleteHauler'])->name('admin.deleteHauler');

    // Admin Truck Routes
    Route::get('/admin/addTrucks',[AdminController::class,'addTruck'])->name('admin.add.trucks');
    Route::post('/admin/truck/add',[AdminController::class,'insertTruck'])->name('admin.insert.truck');
    Route::get('/admin/trucks/edit/{id}', [AdminController::class, 'editTruck'])->name('admin.editTruck');
    Route::post('/admin/trucks/update/{id}', [AdminController::class, 'updateTruck'])->name('admin.updateTruck');
    Route::get('/admin/trucks/delete/{id}', [AdminController::class, 'deleteTruck'])->name('admin.deleteTruck');

    // Admin Farms Routes
    Route::get('/admin/addFarms', [AdminController::class, 'addFarm'])->name('admin.addFarms');
    Route::post('/admin/farms/add',[AdminController::class,'insertFarm'])->name('admin.insert.farm');
    Route::get('/admin/editFarm/{id}',[AdminController::class, 'editFarm'])->name('admin.edit.farm');
    Route::post('/admin/updateFarm/{id}',[AdminController::class,'updateFarm'])->name('admin.update.farm');
    Route::get('/admin/del/farm/{id}',[AdminController::class,'deleteFarm'])->name('admin.delete.farm');

    //Admin Tanks routes
    Route::get('/admin/addTanks',[AdminController::class,'addTank'])->name('admin.add.tank');
    Route::post('/admin/insertTank',[AdminController::class,'insertTank'])->name('admin.insert.tank');
    Route::get('/admin/editTank/{id}',[AdminController::class,'editTank'])->name('admin.edit.tank');
    Route::post('/admin/updateTank/{id}',[AdminController::class,'updateTank'])->name('admin.update.tank');
    Route::get('/admin/deleteTank/{id}',[AdminController::class,'deleteTank'])->name('admin.delete.tank');

    //Admin Plant Routes

    Route::get('/admin/addplants',function (){
        return view('admin.addPlant');
    })->name('admin.add.plant');
    Route::post('/admin/insertPlant',[AdminController::class ,'insertPlant'])->name('admin.insert.plant');
    Route::get('/admin/editPlant/{id}',[AdminController::class,'editPlant'])->name('admin.edit.plant');
    Route::post('/admin/update/{id}',[AdminController::class,'updatePlant'])->name('admin.update.plant');
    Route::get('/admin/deletePlant/{id}',[AdminController::class,'deletePlant'])->name('admin.delete.plant');

    //admin Trailers routes
    Route::get('/admin/addTrailer',[AdminController::class, 'addTrailer'])->name('admin.add.trailer');
    Route::post('/admin/insertTrailer',[AdminController::class, 'insertTrailer'])->name('admin.insert.trailer');
    Route::get('/admin/editTrailer/{id}',[AdminController::class, 'editTrailer'])->name('admin.edit.Trailer');
    Route::post('/admin/updateTrailer/{id}',[AdminController::class, 'updateTrailer'])->name('admin.update.trailer');
    Route::get('/admin/deletetrailer/{id}',[AdminController::class,'deleteTrailer'])->name('admin.delete.trailer');

    //admin Routes routes
    Route::get('/admin/addRoute',[AdminController::class,'addRoute'])->name('admin.add.route');
    Route::post('/admin/insertRoutes',[AdminController::class,'insertRoute'])->name('admin.insert.route');
    Route::get('/admin/routes/editRoutes/{id}',[AdminController::class,'editRoute'])->name('admin.edit.route');
    Route::post('/admin/routes/updateRoutes/{id}',[AdminController::class , 'updateRoute'])->name('admin.update.route');
    Route::get('/admin/deleteRoute/{id}',[AdminController::class, 'deleteRoute'])->name('admin.delete.route');

    Route::get('/admin/{id}/login',[AdminController::class, 'adminHaulerLogin'])->name('hauler.adminSide.login');
    Route::get('/admin/viewLocation/{id}',[AdminController::Class, 'viewDriverLocation'])->name('viewDriver.location');
});


//User Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/signup', function () {
    return view('signup');
})->name('signup');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/verify', [UserController::class, 'verifyEmails'])->name('verify.email');
Route::get('/Login', function () {
    return view('login');
})->name('user.login');

Route::post('/login/check', [UserController::class, 'login'])->name('login.check');
Route::get('/login/forgetpassword', function () {
    return view('forgetPassword');
})->name('forget.password');

Route::post('/sendlink', [UserController::class, 'sendLink'])->name('send.link');
Route::get('/resetMail/resetpassword/{token}', function ($token) {
    return view('resetPassword', ['token' => $token]);
})->name('password.Reset');
Route::post('/update/{token}', [UserController::class, 'updatePassword'])->name('update.password');

Route::middleware([CheckUser::class])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/dashboard/tickets',[UserController::class,'ticket'])->name('getTicket');
    Route::get('/dashboard/completeProfile/{id}',[UserController::class,'showCP'])->name('user.complete.profile');
    Route::post('/dashboard/update',[UserController::class,'completeProfile'])->name('user.update.profile');
    Route::post('/dashboard/startTicket',[UserController::class, 'storeTicket'])->name('storeTicket');
    Route::get('/dashboard/view/route/{id}',[UserController::class, 'viewRoutes'])->name('view.route');
    Route::get('/routes/addfarmstops/ticket/{ticketID}',[UserController::class,'viewFarmStopDetails'])->name('view.farm.stop');

    Route::post('/route/addfarmStop',[UserController::class, 'addFarmStop'])->name('add.farm.stop');
    Route::get('/routes/addfarmstops/tank/{farmID}',[UserController::class, 'showTank'])->name('show.tank');

    Route::get('/routes/destinationplant/{ticketID}',[UserController::class, 'destinationPlant'])->name('destinationPlant');


    Route::get('/routes/closeroutes/{ticketID}',[UserController::class, 'closeRoute'])->name('close.route');
    Route::post('/collectmilk/atplant/{ticketID}',[UserController::class,'collectMilkAtPlant'])->name('collect.at.plant');
    Route::get('/routes/scaleat/plant/{ticketID}',[UserController::class, 'viewScaleAtPlant'])->name('view.scaleAtPlant');
    Route::get('/pdf',[UserController::class, 'sendPdf'])->name('sendPDF');

    Route::get('/check-data',[UserController::class, 'checkData']);
    Route::get('/getLocation',function (Request $request){
        session()->put('lat1', $request->latitude);
        session()->put('long1',$request->longitude);
       $updatePos =  User::where('id',Auth::user()->id)
        ->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        // dd($updatePos);

        if($updatePos){

            return response()->json(['status'=>"Success"]);

        }
        else{
            return response()->json(['status'=>"not Success"]);
        }
        Route::post('/sendMessage',[UserController::class, 'sendMessage']);
        Route::get('/getMessages',[UserController::class, 'getMessages']);
    });

    
});

