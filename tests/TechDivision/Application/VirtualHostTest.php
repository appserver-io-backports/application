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
class VirtualHostTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The virtual host name for testing purposes.
     *
     * @var  string
     */
    const NAME = 'foo.bar';

    /**
     * The application base directory name for testing purposes.
     *
     * @var  string
     */
    const APP_BASE = '/foo.bar';

    /**
     * The virtual host instance we want to test.
     *
     * @var \TechDivision\Application\VirtualHost
     */
    protected $virtualHost;

    /**
     * Initialize the instance to test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->virtualHost = new VirtualHost(VirtualHostTest::NAME, VirtualHostTest::APP_BASE);
    }

    /**
     * Test if the virtual host has successfully been initialized.
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertSame(VirtualHostTest::NAME, $this->virtualHost->getName());
        $this->assertSame(VirtualHostTest::APP_BASE, $this->virtualHost->getAppBase());
    }

    /**
     * Test if the match method matches the passed application.
     *
     * @return void
     */
    public function testMatch()
    {

        // initialize the array with the methods to mock
        $methodsToMock = array('connect', 'getAttribute', 'getBaseDirectory', 'getAppBase', 'getWebappPath', 'getName');

        // create a mock object for the application
        $applicationMock = $this->getMock('TechDivision\Application\Interfaces\ApplicationInterface', $methodsToMock);
        $applicationMock->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(VirtualHostTest::NAME));

        // check that the virtual host matches the application
        $this->assertTrue($this->virtualHost->match($applicationMock));
    }
}
