<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $followings = $user->followings()->get();
        $teachers = Teacher::all()->map(function (Teacher $teacher) use ($user) {
            $teacher['following'] = $teacher->isFollowedBy($user);

            return $teacher;
        });

        return response()->json(compact('user', 'followings', 'teachers'));
    }

    public function follow(Request $request, Teacher $teacher)
    {
        $request->user()->toggleFollow($teacher);

        return response()->json();
    }
}
