<?php

namespace App\Modules\Core\User\Helper;

use App\Modules\Core\User\Models\User;
use App\Modules\Core\Helper\Abstractor;
use DB;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Session;

class UserHelper extends Abstractor {

    use Helpers;

    /**
     * Find an User from id|unique_code
     * @param int|string $userId : id of user or unique_code
     * @return User
     */
    public function findUser($userId) {
	$user = User::find($userId);
	return $user;
    }

    /**
     * Find User form token
     * @return User
     */
    public function findFromToken() {
	   return JWTAuth::parseToken()->authenticate();
    }

    /**
     * Conver User to Array
     * @param object $user
     * @return User
     */
    public function userToArray($user) {
	$user = (isset($user->id) && !empty($user->id)) ? $user : [];
	if (!empty($user)) {
	    $user = $this->userTransformer($user);
	    $user = $user->toArray();
	}
	return $user;
    }

}
