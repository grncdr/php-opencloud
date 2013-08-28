<?php

namespace OpenCloud\Network;

use OpenCloud\Common\PersistentObject;

class FloatingIp extends PersistentObject {
    protected static
        $json_name = "floatingip",
        $url_resource = "v2.0/floatingips",
        $required_properties = array();

    protected
        $id,
        $floating_network_id,
        $port_id;

    public function __construct(Service $service, $id) {
        parent::__construct($service, $id);
    }

    protected function CreateJson() {
        return new \stdClass();
    }

    public function PortId() {
        return $this->port_id;
    }

    public function Disassociate() {
        $this->Update(array('port_id' => null));
    }

    /**
     * @param $port Port The Port instance to associate this IP to
     */
    public function Associate($portId) {
        $this->Update(array('port_id' => $portId));
    }

    public function UpdateJson($params = array()) {
        return array(
            self::$json_name => array_merge(array(
                'port_id' => $this->port_id
            ), $params)
        );
    }

    public function Name() {
        return 'floater';
    }
}
