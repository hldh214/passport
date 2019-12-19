<?php

namespace App\Http\Controllers;

use App\Events\Follow;
use App\LineUserBinding;
use App\Student;
use App\Teacher;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        /** @var Student $user */
        $user = $request->user()->makeHidden(['password', 'deleted_at']);
        $user->load('line.user');

        $teachers = Teacher::all()->map(function (Teacher $teacher) use ($user) {
            $teacher['following'] = $teacher->isFollowedBy($user);

            return $teacher;
        });

        return response()->json(compact('user', 'teachers'));
    }

    /**
     * @param  Request  $request
     * @param  Teacher  $teacher
     * @return JsonResponse
     */
    public function follow(Request $request, Teacher $teacher)
    {
        $result = $request->user()->toggleFollow($teacher);

        if ($result['attached']) {
            broadcast(new Follow($request->user()->only(['id', 'name']), $teacher->only(['id', 'name']), 'follow'));
        }
        if ($result['detached']) {
            broadcast(new Follow($request->user()->only(['id', 'name']), $teacher->only(['id', 'name']), 'unfollow'));
        }

        return response()->json();
    }

    /**
     * @param  LineUserBinding  $binding
     * @return JsonResponse
     * @throws Exception
     */
    public function unlink(LineUserBinding $binding)
    {
        $binding->delete();

        return response()->json();
    }
}
