<?php

/**
 * Authenticate controller Api
 * @method login() login to system,
 * 
 * @author Hoang Dru
 */

namespace App\Modules\Core\Auth\Controllers\Api;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Modules\Controller;
use Dingo\Api\Routing\Helpers;
use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Helper\Facade\UserHelper;

class AuthController extends Controller
{
    use Helpers;

    // Constructor
    public function __construct() {
    
    }
    
    public function authenticate()
    {
        // grab credentials from the request
        $credentials = \Input::only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return \Response::json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return \Response::json(['error' => 'could_not_create_token'], 500);
        }
        
        // update token
        $user = JWTAuth::toUser($token);
        $user->token = $token;
        unset($user->id);
        unset($user->created_at);
        unset($user->updated_at);
        unset($user->deleted_at);
        // all good so return the token
        return $this->response->array([
                "success" => true,
                "message" => "Login",
                "errors" =>  "Login successfully.",
                "code" => 00,
                "status_code" => 200,
                "data" => $user
            ]);
    }

    public function register() {
        $params = \Input::only('username', 'email', 'password');

        User::unguard();
        $newUser = [
            'username' => $params['username'],
            'email' => $params['email'],
            'password' => \Hash::make($params['password']),
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        unset($user->id);
        unset($user->created_at);
        unset($user->updated_at);
        unset($user->deleted_at);
        User::reguard();

        // all good so return the token
        return $this->response->array([
                "success" => true,
                "message" => "Login",
                "errors" =>  "Login successfully.",
                "code" => 00,
                "status_code" => 200,
                "data" => $user
            ]);
    }

    public function test() {
        
        return \Response::json(User::all());
    }
}