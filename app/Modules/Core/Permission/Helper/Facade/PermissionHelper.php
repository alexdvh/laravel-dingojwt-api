<?php

namespace App\Modules\Core\Permission\Helper\Facade;

use Illuminate\Support\Facades\Facade;

class PermissionHelper extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'PermissionHelper'; }
}
