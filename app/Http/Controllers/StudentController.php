<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
