<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $conversations = Chat::with(['sender', 'receiver'])
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->get()
            ->groupBy(function ($chat) use ($user) {
                return $chat->sender_id === $user->id ? $chat->receiver_id : $chat->sender_id;
            });

        return view('chat.index', compact('conversations'));
    }

    // public function showChatDetail($receiverId)
    // {
    //     $receiver = User::findOrFail($receiverId);
    //     $user = Auth::user();

    //     $messages = Chat::where(function ($query) use ($user, $receiver) {
    //         $query->where('sender_id', $user->id)
    //             ->where('receiver_id', $receiver->id);
    //     })
    //     ->orWhere(function ($query) use ($user, $receiver) {
    //         $query->where('sender_id', $receiver->id)
    //             ->where('receiver_id', $user->id);
    //     })
    //     ->orderBy('created_at', 'asc')
    //     ->get();

    //     Log::info('Messages:', $messages->toArray());
    //     Log::info('Receiver:', $receiver->toArray());

    //     return view('chat.detail', compact('messages', 'receiver'));
    // }

    public function showChatDetail($receiverId)
    {
        $receiver = User::findOrFail($receiverId);
        $user = Auth::user();

        $messages = Chat::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })
        ->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Chat::where('receiver_id', $user->id)
            ->where('sender_id', $receiver->id)
            ->update(['read' => true]);

        return view('chat.detail', compact('messages', 'receiver'));
    }

    public function sendMessage(Request $request)
    {
        Log::info('sendMessage called', $request->all());
    
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:user,id',
        ]);
    
        try {
            $chat = Chat::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]);
    
            Log::info('Message stored:', $chat->toArray());
    
            return redirect()->route('chat.detail', ['receiverId' => $request->receiver_id]);
        } catch (\Exception $e) {
            Log::error('Error storing message:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to send the message.');
        }
    }
}
