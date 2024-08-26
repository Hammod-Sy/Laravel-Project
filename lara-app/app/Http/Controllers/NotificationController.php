<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\testnotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationController extends Controller
{
    public function accept($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->accepted = true;
            $notification->save();
            $users = User::all();
            $name = 'user';
            $date = '2024-08-11';
            $time = '7:00PM';
            $phone = '1234';
            $totalperson = '3';
            $newnotification = new testnotification($name , $date,$time,$phone,$totalperson);
     FacadesNotification::send($users, $newnotification);

            return response()->json(['message' => 'Notification accepted successfully.']);
        }

        return response()->json(['message' => 'Notification not found.'], 404);
    }

    public function reject($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->accepted = false;
            $notification->save();

            return response()->json(['message' => 'Notification rejected successfully.']);
        }

        return response()->json(['message' => 'Notification not found.'], 404);
    }
    public function myBookings()
{
    $userId = auth()->id();
    $notifications = Notification::where('user_id', $userId)->get();

    return view('my-bookings', compact('notifications'));
}
    public function notiffy(){
        $notification = Notification::all();
        return response($notification ,200);
    }
}
