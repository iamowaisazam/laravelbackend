<?php
namespace App\Http\Controllers\V1;

use Con;
use Illuminate\Http\Request;
use ZipArchive;
use File;
use Hash;
use Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout Successfully',
        ],200);
    }


    public function profile(Request $request)
    {
        return response()->json([
            'message' => 'Get User Successfully',
            'data' => $request->user(),
        ],200);
    }


    public function getUsers(Request $request)
    {
        $users = User::all();
        return response()->json([
            'message' => 'Get User Successfully',
            'data' => $users,
        ],200);
    }

}