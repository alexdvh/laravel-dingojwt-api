<?php

namespace App\Modules\Core\Role\Helper\Facade;

use Illuminate\Support\Facades\Facade;

class RoleHelper extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'RoleHelper'; }
}
