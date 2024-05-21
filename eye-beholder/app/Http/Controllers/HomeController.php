<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        unset($user->created_at);
        unset($user->deleted_at);
        unset($user->email_verified_at);
        unset($user->provider);
        unset($user->provider_id);
        unset($user->updated_at);

        return view('home', compact('user'));
    }
}
