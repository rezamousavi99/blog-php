<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function logoutUser()
    {
        try {
            // Check if the user has a current access token
            $currentToken = auth()->user()->currentAccessToken();

            if (!$currentToken) {
                return response()->json(['message' => 'No active session found.'], 200);
            }

            // Revoke the token that was used to authenticate the current request
            $currentToken->delete();

            return response()->json(['message' => 'User logged out successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to log out. Please try again later.'], 500);
        }
    }

    public function loginUser(LoginUserRequest  $request){
        $incomingFields = $request->validated();

        // Extract the identifier
        $identifier = $incomingFields['identifier'];
        $password = $incomingFields['password'];

        // Check if the identifier is an email or user name
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('user_name', $identifier)->first();

        //true if username and password is valid
        if ($user && auth()->attempt(['user_name' => $user->user_name, 'password' => $password])) {
//            $user = User::where('user_name', $incomingFields['user_name'])->first();

            $tokenobj = $user->createToken('ourapptoken');

            // Set the token expiration manually
            $token = $tokenobj->accessToken;
            $token->expires_at = now()->addHours(24);
            $token->created_at = now();
            $token->updated_at = null;
            $token->save();

            // Return the token
            return response()->json(['token' => $tokenobj->plainTextToken], 200);
        }
        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function registerUser(RegisterUserRequest $request){
        $incomingFields = $request->validated();

        $incomingFields["created_at"] = now();
        $incomingFields["updated_at"] = null;

        $user = User::create($incomingFields);


        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }
}
