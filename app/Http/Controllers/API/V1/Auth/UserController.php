<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ApiResource;
use App\Http\Resources\V1\Auth\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken("customer", ["customer", "get"]);
        $user->token = $token->plainTextToken;

        return new ApiResource([
            "status" => 1,
            "message" => "Register successfully",
            "data" => new UserResource($user),
        ]);
    }


    // login
    public function login(Request $request)
    {
        $request->validate([
            "email" => ["required", "string", "email"],
            'password' => ['required', Rules\Password::defaults()],
        ]);


        if (Auth::attempt($request->only(["email", "password"]))) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken("user", ["user", "get"]);
            $user->token = $token->plainTextToken;

            return new ApiResource([
                "status" => 1,
                "message" => "login_successful",
                "data" => new UserResource($user),
            ]);
        } else {
            return new ApiResource([
                "status" => 0,
                "message" => "wrong_credentials",
                "data" => null,
            ]);
        }
    }

    // reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        User::where(["id" => Auth::user()->id])->update(["password" => Hash::make($request->password)]);

        return new ApiResource([
            "status" => 1,
            "message" => "Password has been changed",
            "data" => null,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);


        User::where(["id" => Auth::user()->id])->update($request->all());

        $user = Auth::user();
        $user->token = $request->token;

        return new ApiResource([
            "status" => 1,
            "message" => "User has been updated.",
            "data" => new UserResource($user),
        ]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $user->token = $request->token;

        return new ApiResource([
            "status" => 1,
            "message" => "User is logged.",
            "data" => new UserResource($user),
        ]);
    }
}