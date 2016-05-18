<?php

namespace App\Modules\Core\Auth\Controllers\Admin;

use App\Modules\BackendController;
use Dingo\Api\Routing\Helpers;
use App\Modules\Api\Models\User;
use App\Modules\Core\Auth\Helper\Facade\AuthHelper;

/**
 * Description of AuthController
 *
 * @author Hoangdv
 */
class AuthController extends BackendController {
    use Helpers;

    public function __construct()
    {
        parent::__construct();

        //$this->layout = $this->theme . '.layouts.adminlte_login';
        $this->layout = null;
    }

    /**
     * Login page
     * if $response['success'] = true then set session
     * else response errors on view
     *
     * @POST email/password
     * @GET 
     *
     * @return view
     */
    public function login()
    {
        $data = ['errors' => null, 'email' => '', 'password' => ''];

        if(\Request::isMethod('post')){
            //LoginRequest $request
            $params = \Input::all();
                
            $post = [
                'email' => $params['email'],
                'password' => $params['password'],
            ];
            
            try {
                $response = $this->api->post('api/auth/login', $post);
                
                // response sucess = true
                if (true == $response['success']) {
                    $user = [
                        'username' => $response['data']->username,
                        'email' => $response['data']->email,
                        'token' => $response['data']->token
                    ];
                    foreach ($user as $key => $value) {
                        \Request::session()->put($key, $value);
                    }
                    return redirect('/admin');
                }

                // default return errors
                $data['errors'] = $response['errors'];
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];
                
            } catch (\Dingo\Api\Exception\InternalHttpException $e) {
                $response = $e->getResponse();
                $data['errors'] = $response->original;
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];
            }
        }

        return view('Auth::'. $this->theme . '.layouts.login', $data);
    }

    /**
     * Register page
     * if $response['success'] = true then set session
     * else response errors on view
     *
     * @POST username/email/password/password_confirmation
     * @GET 
     *
     * @method any
     *
     * @return view
     */
    public function register()
    {
        $data = ['errors' => null, 'email' => '', 'password' => ''];

        if(\Request::isMethod('post')){
            $params = \Input::all();

            $post = [
                'username' => $params['username'],
                'email' => $params['email'],
                'password' => $params['password'],
                'password_confirmation' => $params['password_confirmation'],
            ];
            
            try {
                $response = $this->api->post('api/auth/register', $post);
                
                // $response sucess = true
                if (true == $response['success']) {
                    $user = [
                        'username' => $response['data']->username,
                        'email' => $response['data']->email,
                        'token' => $response['data']->token
                    ];

                    foreach ($arr as $key => $value) {
                        \Request::session()->put($key, $value);
                    }
                    return redirect('/admin');
                }

                // $response sucess = false
                $data['errors'] = $response['errors'];
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];

            } catch (\Dingo\Api\Exception\InternalHttpException $e) {
                $response = $e->getResponse();
                $data['errors'] = $response->original;
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];
            }
        }

        return view('Auth::'. $this->theme . '.layouts.register', $data);
    }

    /**
     * Logout page
     * @method any
     *
     * @return redirect
     */
    public function logout()
    {
        $rs = $this->api->post('api/auth/logout?get_object=1&access_token=' . \Request::session()->get('accessToken'));
        \Request::session()->flush();
        return redirect('/admin/login');
    }
}
