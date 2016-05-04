<?php

namespace App\Modules\Core\Permission\Helper;

use App\Modules\Core\Permission\Models\Permission;
use App\Modules\Core\Helper\Abstractor;
use DB;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Session;

class UserHelper extends Abstractor {

    use Helpers;

    /**
     * Find an Permission from id|unique_code
     * @param int|string $permissionId : id of Permission or unique_code
     * @return Permission
     */
    public function findPermission($permissionId) {
	$permission = Permission::find($permissionId);
	return $permission;
    }

    /**
     * Conver Permission to Array
     * @param object $permission
     * @return Permission
     */
    public function permissionToArray($permission) {
	$permission = (isset($permission->id) && !empty($permission->id)) ? $permission : [];
	if (!empty($permission)) {
	    $permission = $this->permissionTransformer($permission);
	    $permission = $permission->toArray();
	}
	return $permission;
    }

}
