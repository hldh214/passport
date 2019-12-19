<?php

namespace App\Http\Controllers;

use App\LineUser;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;

class LineAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::with('line')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        if ($request->has('error')) {
            return response()->json($request->get('error_description'));
        }

        /** @var AbstractUser $line_user_data */
        $line_user_data = Socialite::driver('line')->user();

        LineUser::firstOrCreate([
            'openid' => $line_user_data->getId()
        ], [
            'name' => $line_user_data->getName()
        ]);

        return response()->redirectTo('/login?token=' . $line_user_data->token);
    }
}
