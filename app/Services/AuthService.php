<?php


namespace App\Services;


use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Models\User;
use Illuminate\Support\Str;

class AuthService
{
    public function login(string $email, string $password)
    {
        $login = [
            'email' => $email,
            'password' => $password
        ];

        if ( ! $token = auth()->attempt($login)) {
            throw new LoginInvalidException();
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];

    }


    public function register(string $firstName, string $lastName, string $email, string $password)
    {
        $user = User::where('email', $email)->exists();

        if ( ! empty($user)) {
            throw new UserHasBeenTakenException();
        }

        $userPassword = bcrypt($password ?? Str::random(10));
        $confirmation_token = Str::random(60);

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $userPassword,
            'confirmation_token' => $confirmation_token
        ]);


        event(new UserRegistered($user));
        return $user;
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('confirmation_token', $token)->first();
        if (empty($user)) {
            throw new VerifyEmailTokenInvalidException();
        }

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;

    }
}
