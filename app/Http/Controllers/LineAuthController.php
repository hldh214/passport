<?php

namespace App\Http\Controllers;

use App\LineUser;
use App\LineUserBinding;
use Illuminate\Database\Eloquent\Builder;
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

        return redirect()->secure('/login?token=' . $line_user_data->token);
    }

    public function queryBindings(Request $request)
    {
        $line_user_data = Socialite::driver('line')->userFromToken($request->get('token'));
        $line_user      = LineUser::whereOpenid($line_user_data->id)->first();  // null?

        if (blank($line_user)) {
            return [];
        }

        $line_user_bindings = LineUserBinding::whereLineUserId($line_user->id)
            ->with(['teacher', 'student'])
            ->get();

        $bindings = [];
        foreach ($line_user_bindings as $line_user_binding) {
            if ($line_user_binding['teacher']) {
                $bindings[] = [
                    'type'       => 'teacher',
                    'id'         => $line_user_binding['teacher']['id'],
                    'name'       => $line_user_binding['teacher']['name'],
                    'created_at' => $line_user_binding['teacher']['created_at']->toDateTimeString()
                ];
            }

            if ($line_user_binding['student']) {
                $bindings[] = [
                    'type'       => 'student',
                    'id'         => $line_user_binding['student']['id'],
                    'name'       => $line_user_binding['student']['name'],
                    'created_at' => $line_user_binding['student']['created_at']->toDateTimeString()
                ];
            }
        }

        return $bindings;
    }

    public function loginWithBinding(Request $request)
    {
        $type  = $request->get('type');
        $id    = $request->get('id');
        $token = $request->get('token');

        $line_user_data = Socialite::driver('line')->userFromToken($token);
        $line_user      = LineUser::whereOpenid($line_user_data->id)->first();  // null?

        $line_user_bindings = LineUserBinding::whereLineUserId($line_user->id)
            ->whereHas($type, function (Builder $builder) use ($id) {
                $builder->where('id', $id);
            })
            ->with($type)
            ->first();

        // fixme: null check
        $user = $line_user_bindings->$type;

        $token_result = $user->createToken('Personal Access Token');

        return response()->json([
            'access_token' => $token_result->accessToken,
            'token_type'   => 'Bearer'
        ]);
    }
}
