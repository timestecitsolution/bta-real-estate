<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NotificationSeen;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->unseen()
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'count'         => $notifications->count(),
        ]);
    }

    public function markSeen($id)
    {
        Notification::where('user_id', auth()->id())
                    ->findOrFail($id)
                    ->update(['seen_at' => now()]);

        broadcast(new NotificationSeen(auth()->id(), $id));

        return response()->json(['success' => true]);
    }

    public function markAllSeen()
    {
        Notification::where('user_id', auth()->id())
                    ->unseen()
                    ->update(['seen_at' => now()]);

        broadcast(new NotificationSeen(auth()->id(), 'all'));

        return response()->json(['success' => true]);
    }
}
