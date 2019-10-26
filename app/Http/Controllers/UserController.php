<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::/*with('images')->*/get();
        return view('user.index', compact('users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        $user = User::with(['images'])->where('id', Auth::id())->first();

        return view('user.profile', compact('user'));
    }
}
