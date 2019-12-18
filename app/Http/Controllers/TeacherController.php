<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $followers = $user->followers()->get();

        return response()->json(compact('user', 'followers'));
    }
}
