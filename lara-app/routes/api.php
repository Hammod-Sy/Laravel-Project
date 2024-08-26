<?php

use App\Http\Controllers\admincontroller;
use App\Http\Controllers\productscontroller;
use App\Http\Controllers\userscontroller;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\authenticateusers;
use App\Http\Requests\productRequest;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\testnotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use function Laravel\Prompts\progress;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:admins')->group(function() {
Route::post('/addproduct' , [productscontroller::class , 'addproduct']);
Route::post('/updateproduct/{id}' ,[productscontroller::class , 'updateproduct']);
Route::delete('/deleteproduct/{id}' , [productscontroller::class , 'deleteproduct']);
Route::get('/myBookings' , [NotificationController::class] , 'myBookings');
});
Route::get('/getproducts' , [productscontroller::class , 'getproducts']);
Route::get('/getproduct/{id}' , [productscontroller::class , 'getproduct']);
Route::get('/getusers' ,[userscontroller::class , 'getusers']);
Route::post('/updateusers/{id}' , [userscontroller::class , 'updateusers']);
Route::post('/register' , [userscontroller::class , 'register']);
Route::post('/login' ,[userscontroller::class ,'login']);
Route::delete('/delete/{id}' ,[userscontroller::class ,'delete']);
Route::post('/logout' ,[userscontroller::class , 'logout']);
Route::post('/admin' ,[admincontroller::class , 'admin']);
Route::post('/add' , [admincontroller::class , 'add']);
Route::get('/sendnotifications', function(){
    $admins = Admin::all();
    $name = 'user';
    $date = '2024-08-11';
    $time = '7:00PM';
    $phone = '1234';
    $totalperson = '3';
    $notification = new testnotification($name , $date,$time,$phone,$totalperson);
    Notification::send($admins , $notification);
    $firstAdmin = $admins->first();
    Log::info('Notification Sent', $notification->toArray($firstAdmin));
    // $user = Admin::find(1);
    // foreach ($user->unreadNotifications as $notification) {
    //     $notification->markAsRead();
    // }
    $user = App\Models\Admin::find(1);
foreach ($user->notifications as $notification) {
    echo $notification->type;
}
    return 'done';
});
Route::post('/accept/{id}' ,[NotificationController::class , 'accept']);
Route::post('/notifications/{id}/accept', [NotificationController::class, 'accept']);
Route::post('/notifications/{id}/reject', [NotificationController::class, 'reject']);
Route::get('/notiffy' , [NotificationController::class , 'notiffy']);
