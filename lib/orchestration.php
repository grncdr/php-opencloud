<?php
/**
 * The OpenStack Orchestration (Heat) service
 *
 * @copyright 2012-2013 Rackspace Hosting, Inc.
 * See COPYING for licensing information
 *
 * @package phpOpenCloud
 * @version 1.0
 * @author Glen Campbell <glen.campbell@rackspace.com>
 */

namespace OpenCloud;

require_once(__DIR__.'/service.php');
require_once(__DIR__.'/stack.php');

/**
 * The Orchestration class represents the OpenStack Heat service.
 *
 * It is constructed from a OpenStack object and requires a service name,
 * region, and URL type to select the proper endpoint from the service
 * catalog. However, constants can be used to define default values for
 * these to make it easier to use:
 *
 */
class Orchestration extends Service {

    /**
     * Called when creating a new Compute service object
     *
     * _NOTE_ that the order of parameters for this is *different* from the
     * parent Service class. This is because the earlier parameters are the
     * ones that most typically change, whereas the later ones are not
     * modified as often.
     *
     * @param \OpenCloud\Identity $conn - a connection object
     * @param string $serviceRegion - identifies the region of this Compute
     *      service
     * @param string $urltype - identifies the URL type ("publicURL",
     *      "privateURL")
     * @param string $serviceName - identifies the name of the service in the
     *      catalog
     */
    public function __construct(OpenStack $conn,
        $serviceName, $serviceRegion, $urltype) {
            $this->debug(_('initializing Orchestration...'));
            parent::__construct(
                $conn,
                'orchestration',
                $serviceName,
                $serviceRegion,
                $urltype
            );
        } // function __construct()

    /**
     * Returns a Stack object associated with this Orchestration service
     *
     * @api
     * @param string $id - the stack with the ID is retrieved
     * @returns Orchestration\Stack object
     */
    public function Stack($id=null) {
        return new Orchestration\Stack($this, $id);
    }

    public function namespaces() {
        return array();
    }

    public function Url($resource='', $args=array()) {
        $baseurl = parent::Url();
        if ($resource != '')
            $baseurl = noslash($baseurl).'/'.$resource;
        if (!empty($args))
            $baseurl .= '?'.$this->MakeQueryString($args);
        return $baseurl;
    }

}
