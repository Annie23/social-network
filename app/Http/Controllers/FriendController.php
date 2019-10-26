<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $friends = Auth::user()->friends();
        return view('friends.index')->with('friends', $friends);
    }

    public function addFriend($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('info', 'No such user.');
        }

        Auth::user()->addFriend($user);

        return redirect()
            ->back()
            ->with('info', 'Friend request sent.');
    }

    public function acceptFriendReq($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('info', 'No such a user.');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()
            ->back()
            ->with('info', 'Friend request is accepted.');
    }

    public function rejectFriendReq($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('info', 'No such user.');
        }

        Auth::user()->rejectFriendRequest($user);

        return redirect()
            ->back()
            ->with('info', 'Friend request is accepted.');
    }
}
