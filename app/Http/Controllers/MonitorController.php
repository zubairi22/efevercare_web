<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;
use Inertia\Response;

class MonitorController extends Controller
{
    public function index(User $user): Response
    {
        $monitorPatient = $user->load('recentTemperatureReadings');
        if (Auth::user()->hasRole(['Tenaga Kesehatan'])) {
            $chat = Chat::with('messages.user')
                ->where('patient_id' , $user->id)
                ->where('doctor_id' , Auth::id())
                ->latest()
                ->first();
        } else if (Auth::user()->hasRole(['User'])) {
            $chat = Chat::with('messages.user')
                ->where('patient_id' , Auth::id())
                ->latest()
                ->first();
        }


        return Inertia::render('Monitor', [
            'patient' => $monitorPatient,
            'chat' => $chat
        ]);
    }

    public function storeMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = new ChatMessage([
            'user_id' => Auth::id(),
            'message' => $request->input('message'),
        ]);

        $chat->messages()->save($message);

        event(new MessageSent($message));
    }
}
