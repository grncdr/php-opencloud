<?php

namespace OpenCloud\Network\Resource;

use OpenCloud\Common\Resource\PersistentResource;
use OpenCloud\Network\Service;

class FloatingIp extends PersistentResource
{
    protected static $json_name = "floatingip";
    protected static $url_resource = "v2.0/floatingips";
    protected static $required_properties = array();

    protected $id;
    protected $floating_network_id;
    protected $port_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $floating_network_id
     */
    public function setFloatingNetworkId($floating_network_id)
    {
        $this->floating_network_id = $floating_network_id;
    }

    /**
     * @return mixed
     */
    public function getFloatingNetworkId()
    {
        return $this->floating_network_id;
    }

    /**
     * @param mixed $port_id
     */
    public function setPortId($port_id)
    {
        $this->port_id = $port_id;
    }

    /**
     * @return mixed
     */
    public function getPortId()
    {
        return $this->port_id;
    }

    public function getPort()
    {
        return $this->getService()->port($this->port_id);
    }

    public function disassociate()
    {
        $this->update(array('port_id' => null));
    }

    /**
     * @param $portOrPortId string|Port The Port instance or string port ID to associate this IP with.
     * @return void
     */
    public function associate($portOrPortId)
    {
        $portId = is_string($portOrPortId) ? $portOrPortId : $portOrPortId->id;
        $this->update(array('port_id' => $portId));
    }

    protected function createJson()
    {
        return (object) array(
            'port_id'             => $this->port_id,
            'floating_network_id' => $this->floating_network_id
        );
    }

    /**
     * @param array $params
     * @return object
     */
    public function updateJson($params = array())
    {
        return (object) array(
            self::$json_name => array_merge(
                array(
                    'port_id' => $this->port_id
                ),
                $params
            )
        );
    }
}
