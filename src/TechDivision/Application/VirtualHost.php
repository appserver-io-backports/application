<?php

/**
 * TechDivision\Application\VirtualHost
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Library
 * @package   TechDivision_Application
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Application
 * @link      http://www.appserver.io
 */

namespace TechDivision\Application;

use TechDivision\Storage\GenericStackable;
use TechDivision\Application\Interfaces\ApplicationInterface;
use TechDivision\Application\Interfaces\VirtualHostInterface;

/**
 * A basic virtual host class containing virtual host meta information like
 * domain name and base directory.
 *
 * @category  Library
 * @package   TechDivision_Application
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Application
 * @link      http://www.appserver.io
 */
class VirtualHost extends GenericStackable implements VirtualHostInterface
{

    /**
     * Initializes the vhost with the necessary information.
     *
     * @param string $name    The vhosts domain name
     * @param string $appBase The vhosts base directory
     */
    public function __construct($name, $appBase)
    {
        $this->name = $name;
        $this->appBase = $appBase;
    }

    /**
     * Returns the vhosts domain name.
     *
     * @return string The vhosts domain name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the vhosts base directory.
     *
     * @return string The vhosts base directory
     */
    public function getAppBase()
    {
        return $this->appBase;
    }

    /**
     * Returns TRUE if the application matches this virtual host configuration.
     *
     * @param \TechDivision\ApplicationServer\Interfaces\ApplicationInterface $application The application to match
     *
     * @return boolean TRUE if the application matches this virtual host, else FALSE
     */
    public function match(ApplicationInterface $application)
    {
        return trim($this->getAppBase(), '/') === $application->getName();
    }
}
