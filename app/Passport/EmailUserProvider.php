<?php

namespace App\Passport;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Sk\Passport\UserProvider;

class EmailUserProvider extends UserProvider
{

    /**
     * @param ServerRequestInterface $request
     * @return void
     * @throws OAuthServerException
     */
    public function validate(ServerRequestInterface $request)
    {
        // It is not necessary to validate the "grant_type", "client_id",
        // "client_secret" and "scope" expected parameters because it is
        // already validated internally.

        $this->validateRequest($request, [
            'user_email' => ['required', 'email', 'exists:users,email'],
            'user_password' => ['required', 'string'],
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed|void|null
     */
    public function retrieve(ServerRequestInterface $request)
    {
        $inputs = $this->only($request, [
            'user_email',
            'user_password',
        ]);

        // Get user data
        $user = User::where('email', $inputs['user_email'])->first();

        // Check user password
        if (!Hash::check($inputs['user_password'], $user->password)) {
            return false;
        }

        return $user;
    }
}