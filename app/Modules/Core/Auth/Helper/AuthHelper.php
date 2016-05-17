<?php

namespace App\Modules\Core\Auth\Helper;

use App\Modules\Core\Helper\Abstractor;
use DB;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Session;
use Validator;

class AuthHelper extends Abstractor {

    use Helpers;

    /**
	 * validator login
	 * @param array $credentials
	 * @return Validator
     */
    public function validatorLogin($credentials)
    {
    	// Rules validator
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|alpha_dash'
        ];

        return Validator::make($credentials, $rules);
    }

    /**
	 * validator Register
	 * @param array $credentials
	 * @return Validator
     */
    public function validatorRegister($credentials)
    {
    	// Rules validator
        $rules = [
        	'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|alpha_dash'
        ];

        return Validator::make($credentials, $rules);
    }
}
