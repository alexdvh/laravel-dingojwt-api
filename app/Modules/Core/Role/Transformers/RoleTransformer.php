<?php
/**
 * Transformers Role
 *
 * @author: Hoang Dru
 */
namespace App\Modules\Core\Role\Transformers;

use League\Fractal\TransformerAbstract;
use App\Modules\Core\Role\Models\Role;

class RoleTransformer extends TransformerAbstract{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Role $role)
    {
        return \RoleHelper::roleToArray($role);
    }
}