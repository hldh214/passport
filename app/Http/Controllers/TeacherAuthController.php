<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherAuthController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:teachers',
            'password' => 'required|string|confirmed'  // with password_confirmation
        ]);

        $student = new Teacher([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        $student->save();

        return response()->json([
            'message' => 'Successfully created student!'
        ], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|string|email',
            'password' => 'required|string'
        ]);

        /** @var Teacher|null $teacher */
        $teacher = Teacher::where('email', $request->get('email'))->first();

        if (blank($teacher) || !Hash::check($request->get('password'), $teacher->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
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
