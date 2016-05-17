<?php

/**
 * Authenticate controller Api
 * @method login() login to system,
 * 
 * @author Hoang Dru
 */

namespace App\Modules\Core\Auth\Controllers\Api;

use Validator;
use App\Modules\Core\Auth\Validator\LoginValidator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Modules\Controller;
use Dingo\Api\Routing\Helpers;
use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Helper\Facade\UserHelper;
use App\Modules\Core\Auth\Helper\Facade\AuthHelper;

class AuthController extends Controller
{
    use Helpers;

    // Constructor
    public function __construct() {
    
    }
    
    /**
     * Authenticate the User
     * @param email $email, string $password
     * @return JSON Response
     */
    public function authenticate()
    {
        // grab credentials from the request
        $credentials = \Input::only('email', 'password');

        $validator = AuthHelper::validatorLogin($credentials);
        
        if ($validator->fails()) {
            return $this->response->array([
                "success" => false,
                "message" => "Login failure",
                "errors" =>  $validator->errors(),
                "code" => 422,
                "status_code" => 422,
            ]);
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
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

    /**
     * Register the User
     * @param string $username, email $email, string $password
     * @return JSON Response
     */
    public function register() 
    {
        $params = \Input::only('username', 'email', 'password', 'password_confirmation');

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
                "message" => "Register",
                "errors" =>  "Register successfully.",
                "code" => 00,
                "status_code" => 200,
                "data" => $user
            ]);
    }

    /**
     * Invalidate a token (Logout).
     *
     * @param mixed $token
     *
     * @return bool
     */
    public function logout() 
    {
        try {

            if (!$res = JWTAuth::parseToken()->invalidate()) {
                return \Response::json(['error' => 'could_not_invalid_token'], 401);
            }

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        
        }
        
        if (\Session::has('token')) {
            \Session::forget('token');
        }
        if (\Session::has('user_logged')) {
            \Session::forget('user_logged');
        }

        return $this->response->array([
                "success" => true,
                "message" => "Logout",
                "errors" =>  "Logout successfully.",
                "code" => 00,
                "status_code" => 200
            ]);
    }

    /**
     * Authenticate with social (facebook, google)
     *
     *
     */
    public function socialLogin()
    {

    }

}