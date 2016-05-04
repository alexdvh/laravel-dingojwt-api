<?php
/**
 * Transformers User
 * @author: Hoangdv
 */
namespace App\Modules\Core\User\Transformers;

use League\Fractal\TransformerAbstract;
use App\Modules\Core\User\Models\User;

class UserTransformer extends TransformerAbstract{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return \UserHelper::userToArray($user);
    }
}