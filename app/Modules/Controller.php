<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dru
 * Date: 3/24/2016
 * Time: 10:55 PM
 */

namespace App\Modules;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

}