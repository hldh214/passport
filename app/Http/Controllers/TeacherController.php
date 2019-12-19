<?php

namespace App\Http\Controllers;

use App\LineUserBinding;
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
        $user = $request->user()->makeHidden(['password', 'deleted_at']);
        $user->load('line.user');

        $followers = $user->followers()->get();

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
