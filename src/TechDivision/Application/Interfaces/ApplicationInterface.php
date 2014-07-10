<?php

/**
 * TechDivision\Application\Interfaces\ApplicationInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Library
 * @package    TechDivision_Application
 * @subpackage Interfaces
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Application
 * @link       http://www.appserver.io
 */

namespace TechDivision\Application\Interfaces;

use TechDivision\Context\Context;

/**
 * Interface ApplicationInterface
 *
 * @category   Library
 * @package    TechDivision_Application
 * @subpackage Interfaces
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Application
 * @link       http://www.appserver.io
 */
interface ApplicationInterface extends Context
{

    /**
     * Has been automatically invoked by the container after the application
     * instance has been created.
     *
     * @return \TechDivision\ApplicationServer\Interfaces\ApplicationInterface The connected application
     */
    public function connect();

    /**
     * Returns the application name (that has to be the class namespace,
     * e. g. TechDivision\Example).
     *
     * @return string The application name
     */
    public function getName();

    /**
     * Return's the applications servers base directory, which is
     * /opt/appserver by default.
     *
     * @param string $directoryToAppend Directory to append before returning the base directory
     *
     * @return string The application server's base directory
     */
    public function getBaseDirectory($directoryToAppend = null);

    /**
     * Returns the path to the appserver webapp base directory.
     *
     * @return string The path to the appserver webapp base directory
     */
    public function getAppBase();

    /**
     * Return's the path to the web application.
     *
     * @return string The path to the web application
     */
    public function getWebappPath();
}
