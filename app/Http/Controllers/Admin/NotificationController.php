<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Fetch unread notifications for the dropdown.
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return response()->json($notifications);
    }

    /**
     * Fetch all notifications for the history page.
     */
    public function history()
    {
        $notifications = auth()->user()->notifications()->paginate(15);
        return view('admin.notifications.history', compact('notifications'));
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    }
}