<?php
/**
 * Defines an OpenStack Heat Stack
 *
 * @copyright 2012-2013 Rackspace Hosting, Inc.
 * See COPYING for licensing information
 *
 * @package phpOpenCloud
 * @version 1.0
 * @author Glen Campbell <glen.campbell@rackspace.com>
 */

namespace OpenCloud\Orchestration;

require_once(__DIR__.'/persistentobject.php');
require_once(__DIR__.'/metadata.php');
require_once(__DIR__.'/volumeattachment.php');

/**
 * The Stack class represents a CloudFormation template and Params.
 *
 * A Stack is always associated with a (Orchestration) Service.
 *
 * @api
 * @author Stephen Sugden <openstack@stephensugden.com>
 */
class Stack extends \OpenCloud\PersistentObject {
    protected static
        $json_name = "stack",
        $url_resource = "stacks",
        $required_properties = array('template', 'stack_name');

    protected
        $id,
        $stack_name,
        $parameters,
        $template,
        $disable_rollback,
        $description,
        $stack_status_reason,
        $outputs,
        $creation_time,
        $links,
        $capabilities,
        $notification_topics,
        $timeout_mins,
        $stack_status,
        $updated_time,
        $template_description;

    public function __construct(\OpenCloud\Orchestration $service, $info) {
        parent::__construct($service, $info);
    }

    protected function CreateJson() {
        $pk = $this->PrimaryKeyField();
        if (isset($this->{$pk})) {
            throw new \OpenCloud\CreateError("Stack is already created: {$this->$pk}");
        }

        $obj = new \stdClass();
        $obj->disable_rollback = false;
        $obj->timeout_mins = 60;

        foreach (self::$required_properties as $property) {
            if (is_null($this->{$property})) {
                $message = "Cannot create Stack with null $property";
                throw new \OpenCloud\CreateError($message);
            }
            else {
                $obj->$property = $this->$property;
            }
        }
        if (!is_null($this->parameters)) {
            $obj->parameters = $this->parameters;
        }
        return $obj;
    }

    public function Name() {
        return $this->stack_name;
    }

    public function WaitFor($terminal='CREATE_COMPLETE', $timeout=RAXSDK_SERVER_MAXTIMEOUT, $callback=NULL) {
        parent::WaitFor($terminal, $timeout, $callback, 'stack_status');
    }
}
