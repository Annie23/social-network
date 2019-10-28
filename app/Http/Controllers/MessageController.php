<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Notifications\NewMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        /*todo*/
        return view('message', compact('messages'));
    }

    public function createMessage($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('info', 'No such a user.');
        }

        return view('partials.message-form', compact('user'));
    }

    public function sendMessage(Request $request, $userId)
    {
        $sendToUser = User::find($userId);

        if (!$sendToUser) {
            return redirect()->back()->with('info', 'No such a user.');
        }

        $validator =$validator = Validator::make($request->all(), [
            'message'    => 'required|max:250'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $userId,
            'message' => $request->input('message')
        ]);

        $sendToUser->notify(new NewMessage($user));

        return redirect()->route('profile')->with('info', 'Message is sent.');
    }
}
