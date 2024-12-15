<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request){
            $user = auth()->user();
            var_dump($user->id);
            // Fetch notifications for the authenticated user
            $notifications = Notification::where('user_id', $user->id)->get();

            return response()->json($notifications);
    }
}
