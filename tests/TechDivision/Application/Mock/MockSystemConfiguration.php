<?php

/**
 * TechDivision\Application\Mock\MockSystemConfiguration
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
 * @subpackage Mock
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Application
 * @link       http://www.appserver.io
 */

namespace TechDivision\Application\Mock;

/**
 * Test implementation for a system configuration.
 *
 * @category   Library
 * @package    TechDivision_Application
 * @subpackage Mock
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Application
 * @link       http://www.appserver.io
 */
class MockSystemConfiguration
{

    /**
     * Returns a username.
     *
     * @return string The username
     */
    public function getUser()
    {
    }

    /**
     * Returns a groupname.
     *
     * @return string The groupname
     */
    public function getGroup()
    {
    }

    /**
     * Returns a umaks.
     *
     * @return integer The umask
     */
    public function getUmask()
    {
    }
}
