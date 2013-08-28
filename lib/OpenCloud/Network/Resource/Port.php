<?php

namespace OpenCloud\Network\Resource;


use OpenCloud\Common\Resource\PersistentResource;

class Port extends PersistentResource {
    public $id;

    public $admin_state_up;
    public $device_id;
    public $device_owner;
    public $fixed_ips;
    public $mac_address;
    public $name;
    public $network_id;
    public $security_groups;
    public $status;

    protected static $json_name = "port";
    protected static $url_resource = "ports";
    protected static $required_properties = array("network_id");

}
