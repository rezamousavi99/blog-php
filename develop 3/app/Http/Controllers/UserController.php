<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function logoutUserApi()
    {
        // Revoke the token that was used to authenticate the current request
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully']);
    }

    public function loginUserApi(Request $request){
        $incomingFields = $request->validate([
            'user_name' => 'required',
            'password' => 'required'
        ]);

        //true if username and password is valid
        if (auth()->attempt($incomingFields)) {
            /* ----------------------- Using sanctum approach -----------------------------*/
            $user = User::where('user_name', $incomingFields['user_name'])->first();
            //$token = $user->createToken('ourapptoken', ['expires_at' => DB::raw('CURRENT_TIMESTAMP + INTERVAL 1 HOUR')])->plainTextToken;

            //by default expires after one year
            $token = $user->createToken('ourapptoken')->plainTextToken;
            // Return the token
            return response()->json(['token' => $token], 200);

            /* ----------------------- without using sanctum approach -----------------------------*/
//             $user = DB::table('users')->where('user_name', $incomingFields['user_name'])->first();
//
//            // Generate a token
//             $token = Str::random(80);
//
//            // Store the token in the database
//             DB::table('tokens')->insert([
//                 'user_id' => $user->id,
//                 'token' => hash('sha256', $token),
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//            return response()->json(['token' => $token], 200);
            /*-------------------------------------------------------------------------------------- */
        }
        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function registerUserApi(Request $request){
        $incomingFields = $request->validate([
            'user_name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'user_name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $incomingFields["created_at"] = DB::raw('CURRENT_TIMESTAMP');

//        User::create($incomingFields);
        $userId = DB::table('users')->insertGetId($incomingFields);

        return response()->json(['message' => 'User registered successfully', 'user_id' => $userId]);
    }
}
