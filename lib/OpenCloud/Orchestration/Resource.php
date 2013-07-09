<?php
/**
 * Defines an OpenStack Heat Stack
 *
 * @copyright 2012-2013 Rackspace Hosting, Inc.
 * See COPYING for licensing information
 *
 * @package phpOpenCloud
 * @version 1.0
 * @author Stephen Sugden <openstack@stephensugden.com>
 */

namespace OpenCloud\Orchestration;

use OpenCloud\Common\PersistentObject;

/**
 * @codeCoverageIgnore
 */
class Resource extends PersistentObject 
{
    
    protected $links;
    protected $logical_resource_id;
    protected $physical_resource_id;
    protected $resource_status;
    protected $resource_status_reason;
    protected $resource_type;
    protected $resource_metadata;
    protected $updated_time;
    
    protected static $url_resource = 'resources';
    protected static $json_name = 'resource';

    public function create($info = null) 
    {
        $this->noCreate();
    }

    public function id() 
    {
        return $this->physical_resource_id;
    }

    protected function primaryKeyField() 
    {
        return 'physical_resource_id';
    }

    public function name() 
    {
        return $this->logical_resource_id;
    }

    public function type() 
    {
        return $this->resource_type;
    }

    public function status() 
    {
        return $this->resource_status;
    }

    /**
     * @return object decoded metadata
     */
    public function metadata() {
        if (!is_null($this->resource_metadata)) {
            return $this->resource_metadata;
        }
        $url = $this->url() . '/metadata';
        $response = $this->service()->request($url, 'GET', array('Accept' => 'application/json'));

        if ($json = $response->httpBody()) {
            return $this->resource_metadata = @json_decode($json)->metadata;
        } else {
            return array();
        }
    }

    public function get() 
    {
        switch ($this->resource_type) {
        case 'AWS::EC2::Instance':
            $objSvc = 'Compute';
            $method = 'Server';
            $name = 'nova';
            break;
        default:
            throw new \Exception("Unknown resource type {$this->resource_type}");
        }
        
        $service    = $this->parent()->service();
        $connection = $service->connection();
 
        return $connection->$objSvc($name, $service->region())->$method($this->id());
    }
}
