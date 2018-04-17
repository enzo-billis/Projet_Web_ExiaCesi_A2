<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use App\Idea;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
    }

    /*
     * Function get return all unread notifications about the actual user
     */

    function get(){
        $user = Auth::user();
        $notifications = $user->unreadNotifications;
        return ($notifications);
    }

    /*
     * Function mark as read the notification contained in the $request
     */

    function read(Request $request){
        Auth::user()->unreadNotifications()->find($request->id)->markAsRead();
    }
}
