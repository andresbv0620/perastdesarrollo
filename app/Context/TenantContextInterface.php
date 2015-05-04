<?php namespace App\Context;


interface TenantContextInterface {
    /**
     * Set the connection name for the actual context
     * this tenant
     * @param $name
     * @return mixed
     */
    public function setConnectionName($name);

    /**
     * Get the name of the current connection in context
     * @return mixed
     */
    public function getConnectionName();

    /**
     * Set the id value filter data in the current context
     * @param $id
     * @return mixed
     */
    public function setTenantId($id);

    /**
     * Get the tenant id value for the current context
     * @return mixed
     */
    public function getTenantId();
}