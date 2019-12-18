<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LineAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::with('line')->redirect();
    }

    public function handleProviderCallback()
    {
        return response()->json(Socialite::driver('line')->user());
    }
}
