<?php
/**
 * Transformers Permission
 * @author: Hoangdv
 */
namespace App\Modules\Core\Permission\Transformers;

use League\Fractal\TransformerAbstract;
use App\Modules\Core\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Permission $permission)
    {
        return \PermissionHelper::permissionToArray($permission);
    }
}