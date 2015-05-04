<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 30/04/2015
 * Time: 11:00 PM
 */

namespace App;

use App\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;

trait TenantableTrait {

    /**
     * Boot the tenantable trait for the model
     *
     * @return void
     */
    public static function bootTenantableTrait()
    {
        static::addGlobalScope(new TenantScope);
    }

}