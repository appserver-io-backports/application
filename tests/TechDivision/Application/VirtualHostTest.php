<?php

/**
 * TechDivision\Application\VirtualHostTest
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

/**
 * Test implementation for the virtual host.
 *
 * @category  Library
 * @package   TechDivision_Application
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Application
 * @link      http://www.appserver.io
 */
class VhostTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test if the VHost has successfully been initialized.
     *
     * @return void
     */
    public function testConstructor()
    {
        $vhost = new VirtualHost($name = 'foo.bar', $appBase = '/foo.bar');
        $this->assertSame($name, $vhost->getName());
        $this->assertSame($appBase, $vhost->getAppBase());
    }
}