<?php

namespace App\Http\Controllers;

use App\LineUser;
use App\LineUserBinding;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class TeacherAuthController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:teachers',
            'password' => 'required|string|confirmed'  // with password_confirmation
        ]);

        $teacher = new Teacher([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        $teacher->save();

        $token_result = $teacher->createToken('Personal Access Token');

        return response()->json([
            'access_token' => $token_result->accessToken,
            'token_type'   => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|string|email',
            'password' => 'required|string',
            'token'    => 'nullable|string'
        ]);

        /** @var Teacher|null $teacher */
        $teacher = Teacher::where('email', $request->get('email'))->first();

        if (blank($teacher) || !Hash::check($request->get('password'), $teacher->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        if (filled($request->get('token'))) {
            $line_user_data = Socialite::driver('line')->userFromToken($request->get('token'));
            $line_user      = LineUser::whereOpenid($line_user_data->id)->first();  // null?

            if (!LineUserBinding::whereLineUserId($line_user->id)
                ->where('teacher_id', '<>', 0)
                ->exists()) {
                LineUserBinding::create([
                    'line_user_id' => $line_user->id,
                    'teacher_id'   => $teacher->id
                ]);
            }
        }

        $token_result = $teacher->createToken('Personal Access Token');

        return response()->json([
            'access_token' => $token_result->accessToken,
            'token_type'   => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
