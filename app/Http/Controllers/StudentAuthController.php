<?php

namespace App\Http\Controllers;


use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:students',
            'password' => 'required|string|confirmed'  // with password_confirmation
        ]);

        $student = new Student([
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

        /** @var Student|null $student */
        $student = Student::where('email', $request->get('email'))->first();

        if (blank($student) || !Hash::check($request->get('password'), $student->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token_result = $student->createToken('Personal Access Token');

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
