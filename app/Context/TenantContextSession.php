<?php namespace App\Context;


class TenantContextSession implements TenantContextInterface{


    /**
     * Set the connection name for the actual context
     * this tenant
     * @param $name
     * @return mixed
     */
    public function setConnectionName($name)
    {
        \Session::put('tenant_connection', $name);
    }

    /**
     * Get the name of the current connection in context
     * @return mixed
     */
    public function getConnectionName()
    {
        return \Session::get('tenant_connection');
    }

    /**
     * Set the id value filter data in the current context
     * @param $id
     * @return mixed
     */
    public function setTenantId($id)
    {
        \Session::put('tenant_id', $id);
    }

    /**
     * Get the tenant id value for the current context
     * @return mixed
     */
    public function getTenantId()
    {
        return \Session::get('tenant_id');
    }
}