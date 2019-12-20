<?php

namespace App\Http\Controllers;

use App\LineUserBinding;
use App\Teacher;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        /** @var Teacher $user */
        $user = $request->user()->makeHidden(['password', 'deleted_at']);
        $user->load('line.user');

        $followers = $user->followers()->get()
            ->makeHidden(['password', 'email', 'created_at', 'updated_at', 'deleted_at', 'pivot']);

        return response()->json(compact('user', 'followers'));
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
