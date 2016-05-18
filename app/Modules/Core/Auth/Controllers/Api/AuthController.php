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
     * @method POST
     * @param email $email, string $password
     * @return JSON Response
     */
    public function login()
    {
        // grab credentials from the request
        $credentials = \Input::only('email', 'password');

        $validator = AuthHelper::validatorLogin($credentials);
        
        if ($validator->fails()) {
            return $this->response->array([
                "success" => false,
                "message" => "Login failure",
                "errors" =>  $validator->errors()->all(),
                "code" => 422,
                "status_code" => 422,
            ]);
        }
        // authenticate
        return $this->authenticate($credentials);

    }
    /**
     * Register the User
     * @method POST
     * @param string $username, email $email, string $password
     * @return JSON Response
     */
    public function register() 
    {
        $credentials = \Input::only('username', 'email', 'password', 'password_confirmation');

        $validator = AuthHelper::validatorLogin($credentials);
        
        if ($validator->fails()) {
            return $this->response->array([
                "success" => false,
                "message" => "Login failure",
                "errors" =>  $validator->errors()->all(),
                "code" => 422,
                "status_code" => 422,
            ]);
        }

        User::unguard();
        $newUser = [
            'username' => $credentials['username'],
            'email' => $credentials['email'],
            'password' => \Hash::make($credentials['password']),
        ];
        $user = User::create($newUser);
        User::reguard();
        // authenticate
        return $this->authenticate(\Input::only('email', 'password'));
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
                return $this->response->array([
                    "success" => false,
                    "message" => "Logout",
                    "errors" =>  "could not invalid token.",
                    "code" => 401,
                    "status_code" => 401
                ]);
            }

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            
            return $this->response->array([
                "success" => false,
                "message" => "Logout",
                "errors" =>  "token absent",
                "code" => $e->getStatusCode(),
                "status_code" => $e->getStatusCode()
            ]);
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
    /**
     * authenticate
     * @param email email, string password
     * @return JSON response
     */
    protected function authenticate($credentials)
    {
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->response->array([
                    "success" => false,
                    "message" => "Login failure",
                    "errors" =>  ['invalid credentials'],
                    "code" => 401,
                    "status_code" => 401,
                ]);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->response->array([
                    "success" => false,
                    "message" => "Login failure",
                    "errors" =>  ['could not create token'],
                    "code" => 500,
                    "status_code" => 500,
                ]);
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
                "errors" =>  ["Login successfully"],
                "code" => 200,
                "status_code" => 200,
                "data" => $user
            ]);
    }

}