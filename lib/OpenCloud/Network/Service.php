<?php
/**
 * The OpenStack Orchestration (Heat) service
 *
 * @copyright 2012-2013 Rackspace Hosting, Inc.
 *            See COPYING for licensing information
 *
 * @package   phpOpenCloud
 * @version   1.0
 * @author    Stephen Sugden <openstack@stephensugden.com>
 */

namespace OpenCloud\Network;

use OpenCloud\Common\Service\CatalogService;

/**
 * The OpenStack Neutron service.
 */
class Service extends CatalogService
{
    const DEFAULT_TYPE = 'network';
    const DEFAULT_NAME = 'neutron';

    /**
     * @api
     *
     * @param string $id - the floating IP with the ID is retrieved
     * @return \OpenCloud\Network\Resource\FloatingIp
     */
    public function floatingIp($id = null)
    {
        return new Resource\FloatingIp($this, $id);
    }

    public function port($id = null)
    {
        return new Resource\Port($this, $id);
    }
}
