<?php

/**
 * Created by PhpStorm.
 * Role: Hoang Dru
 * Date: 3/24/2016
 * Time: 10:49 PM
 */

namespace App\Modules\Core\Role\Helper;

use App\Modules\Core\Role\Models\Role;
use App\Modules\Core\Helper\Abstractor;
use DB;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Session;

class RoleHelper extends Abstractor {

    use Helpers;

    /**
     * Find an Role from id|unique_code
     * @param int|string $roleId : id of Role or unique_code
     * @return Role
     */
    public function findRole($roleId) {
	$role = Role::find($roleId);
	return $role;
    }


    /**
     * Conver Role to Array
     * @param object $Role
     * @return Role
     */
    public function roleToArray($role) {
	$role = (isset($role->id) && !empty($role->id)) ? $role : [];
	if (!empty($role)) {
	    $role = $this->roleTransformer($role);
	    $role = $role->toArray();
	}
	return $role;
    }

}
