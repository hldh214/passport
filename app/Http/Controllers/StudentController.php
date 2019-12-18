<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $followings = $user->followings(Teacher::class)->get();
        $teachers = Teacher::all();

        return response()->json(compact('user', 'followings', 'teachers'));
    }

    public function follow(Request $request)
    {

    }
}
