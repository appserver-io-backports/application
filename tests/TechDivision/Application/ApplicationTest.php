<?php

/**
 * TechDivision\Application\ApplicationTest
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

use TechDivision\Application\Mock\MockManager;
use TechDivision\Application\Mock\MockClassLoader;
use TechDivision\Application\Mock\MockSystemConfiguration;
use TechDivision\Application\Interfaces\ApplicationInterface;
use TechDivision\Storage\GenericStackable;

/**
 * Test implementation for the threaded application implementation.
 *
 * @category  Library
 * @package   TechDivision_Application
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Application
 * @link      http://www.appserver.io
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The application name for testing purposes.
     *
     * @var  string
     */
    const NAME = 'foo';

    /**
     * The base directory for testing purposes.
     *
     * @var  string
     */
    const BASE_DIRECTORY = '/opt/appserver';

    /**
     * The application base directory for testing purposes.
     *
     * @var  string
     */
    const APP_BASE = '/opt/appserver/webapps';

    /**
     * The application temporary directory for testing purposes.
     *
     * @var  string
     */
    const TMP_DIR = '/opt/appserver/var/tmp/foo';

    /**
     * The server name for testing purposes.
     *
     * @var  string
     */
    const SERVER_NAME = 'test.local';

    /**
     * The application instance we want to test.
     *
     * @var \TechDivision\Application\Application
     */
    protected $application;

    /**
     * Initialize the instance to test.
     *
     * @return void
     */
    public function setUp()
    {

        // create a generic stackable for the necessary storages
        $this->managers = new GenericStackable();
        $this->virtualHosts = new GenericStackable();
        $this->classLoaders = new GenericStackable();

        // initialize the application instance
        $this->application = new Application();

        // inject the storages
        $this->application->injectVirtualHosts($this->virtualHosts);
        $this->application->injectManagers($this->managers);
        $this->application->injectClassLoaders($this->classLoaders);
    }

    /**
     * Test if the application has successfully been initialized.
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertInstanceOf('TechDivision\Application\Interfaces\ApplicationInterface', $this->application);
    }

    /**
     * Test if the getter/setter for the application name works.
     *
     * @return void
     */
    public function testInjectGetName()
    {
        $this->application->injectName(ApplicationTest::NAME);
        $this->assertEquals(ApplicationTest::NAME, $this->application->getName());
    }

    /**
     * Test if the getter/setter for the app base works.
     *
     * @return void
     */
    public function testInjectGetAppBase()
    {
        $this->application->injectAppBase(ApplicationTest::APP_BASE);
        $this->assertEquals(ApplicationTest::APP_BASE, $this->application->getAppBase());
    }

    /**
     * Test if the getter/setter for the tmp dir works.
     *
     * @return void
     */
    public function testInjectGeTmpDir()
    {
        $this->application->injectTmpDir(ApplicationTest::TMP_DIR);
        $this->assertEquals(ApplicationTest::TMP_DIR, $this->application->getTmpDir());
    }

    /**
     * Test if the getter for the session dir works.
     *
     * @return void
     */
    public function testGetSessionDir()
    {
        $sessionDir = ApplicationTest::TMP_DIR . DIRECTORY_SEPARATOR . ApplicationInterface::SESSION_DIRECTORY;
        $this->application->injectTmpDir(ApplicationTest::TMP_DIR);
        $this->assertEquals($sessionDir, $this->application->getSessionDir());
    }

    /**
     * Test if the getter for the cache dir works.
     *
     * @return void
     */
    public function testGetCacheDir()
    {
        $cacheDir = ApplicationTest::TMP_DIR . DIRECTORY_SEPARATOR . ApplicationInterface::CACHE_DIRECTORY;
        $this->application->injectTmpDir(ApplicationTest::TMP_DIR);
        $this->assertEquals($cacheDir, $this->application->getCacheDir());
    }

    /**
     * Test if the getter/setter for the initial context works.
     *
     * @return void
     */
    public function testInjectGetInitialContext()
    {

        // define the methods to mock
        $methodsToMock = array('getClassLoader', 'newInstance', 'newService', 'getAttribute', 'getSystemConfiguration');

        // create a mock instance
        $mockInitialContext = $this->getMock('TechDivision\Application\Interfaces\ContextInterface', $methodsToMock);

        // check if the passed instance is equal to the getter one
        $this->application->injectInitialContext($mockInitialContext);
        $this->assertEquals($mockInitialContext, $this->application->getInitialContext());
    }

    /**
     * Test if the getter/setter for the managers works.
     *
     * @return void
     */
    public function testInjectGetManagers()
    {
        $this->assertEquals($this->managers, $this->application->getManagers());
    }

    /**
     * Test if the getter/setter for the virtual hosts works.
     *
     * @return void
     */
    public function testInjectGetVirtualHosts()
    {
        $this->assertEquals($this->virtualHosts, $this->application->getVirtualHosts());
    }

    /**
     * Test if the getter/setter for the class loaders works.
     *
     * @return void
     */
    public function testInjectGetClassLoaders()
    {
        $this->assertEquals($this->classLoaders, $this->application->getClassLoaders());
    }

    /**
     * Test if the newInstance() method will be forwarded to the initial context.
     *
     * @return void
     */
    public function testNewInstance()
    {

        // define the methods to mock
        $methodsToMock = array('getClassLoader', 'newInstance', 'newService', 'getAttribute', 'getSystemConfiguration');

        // create a mock instance
        $mockInitialContext = $this->getMock('TechDivision\Application\Interfaces\ContextInterface', $methodsToMock);
        $mockInitialContext->expects($this->any())
            ->method('newInstance')
            ->will($this->returnValue($newInstance = new \stdClass()));

        // check if the passed instance is equal to the getter one
        $this->application->injectInitialContext($mockInitialContext);
        $this->assertEquals($newInstance, $this->application->newInstance('\stdClass'));
    }

    /**
     * Test if the newService() method will be forwarded to the initial context.
     *
     * @return void
     */
    public function testNewService()
    {

        // define the methods to mock
        $methodsToMock = array('getClassLoader', 'newInstance', 'newService', 'getAttribute', 'getSystemConfiguration');

        // create a mock instance
        $mockInitialContext = $this->getMock('TechDivision\Application\Interfaces\ContextInterface', $methodsToMock);
        $mockInitialContext->expects($this->any())
            ->method('newService')
            ->will($this->returnValue($newService = new \stdClass()));

        // check if the passed instance is equal to the getter one
        $this->application->injectInitialContext($mockInitialContext);
        $this->assertEquals($newService, $this->application->newService('\stdClass'));
    }

    /**
     * Test if the getter/setter for the base directory works.
     *
     * @return void
     */
    public function testInjectGetBaseDirectory()
    {
        $this->application->injectBaseDirectory(ApplicationTest::BASE_DIRECTORY);
        $this->assertEquals(ApplicationTest::BASE_DIRECTORY, $this->application->getBaseDirectory());
    }

    /**
     * Test if the passed directory will be appended correctly.
     *
     * @return void
     */
    public function testGetBaseDirectoryWithDirectoryToAppend()
    {

        // create a directory
        $aDirectory = ApplicationTest::BASE_DIRECTORY . DIRECTORY_SEPARATOR . ApplicationTest::NAME;

        // inject the base directory
        $this->application->injectBaseDirectory(ApplicationTest::BASE_DIRECTORY);
        $this->assertEquals($aDirectory, $this->application->getBaseDirectory(DIRECTORY_SEPARATOR . ApplicationTest::NAME));
    }

    /**
     * Test if the getter for the webapp path works.
     *
     * @return void
     */
    public function testGetWebappPath()
    {

        // prepare the expected webapp path
        $webappPath = ApplicationTest::APP_BASE . DIRECTORY_SEPARATOR . ApplicationTest::NAME;

        // inject the path components
        $this->application->injectName(ApplicationTest::NAME);
        $this->application->injectAppBase(ApplicationTest::APP_BASE);
        $this->assertEquals($webappPath, $this->application->getWebappPath());
    }

    /**
     * Test if the the application is a virtual host.
     *
     * @return void
     */
    public function testIsVhostOf()
    {

        // create an array with the methods to mock
        $methodsToMock = array('getName', 'getAppBase', 'match');

        // create a mock for a virtual host
        $mockVirtualHost = $this->getMock('TechDivision\Application\Interfaces\VirtualHostInterface', $methodsToMock);
        $mockVirtualHost->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(ApplicationTest::SERVER_NAME));

        // add the virtual host mock
        $this->application->addVirtualHost($mockVirtualHost);

        // check if we're a virtual host of
        $this->assertTrue($this->application->isVHostOf(ApplicationTest::SERVER_NAME));
    }

    /**
     * Test if the the application is NOT a virtual host.
     *
     * @return void
     */
    public function testIsVhostOfIsFalse()
    {
        $this->assertFalse($this->application->isVHostOf(ApplicationTest::SERVER_NAME));
    }

    /**
     * Test if the class loader has been added successfully.
     *
     * @return void
     */
    public function testAddClassLoader()
    {
        $this->application->addClassLoader($classLoader = new \stdClass());
        foreach ($this->application->getClassLoaders() as $cls) {
            $this->assertEquals($cls, $classLoader);
        }
    }

    /**
     * Test if the class loader has been added successfully.
     *
     * @return void
     * @expectedException \Exception
     */
    public function testGetAttribute()
    {
        $this->application->getAttribute(ApplicationTest::NAME);
    }

    /**
     * Test if the manager instance has been added successfully.
     *
     * @return void
     */
    public function testAddManager()
    {
        $this->application->addManager($mockManager = new MockManager());
        $this->assertEquals($mockManager, $this->application->getManager(MockManager::IDENTIFIER));
    }

    /**
     * Test if the NULL will be returned for an invalid manager request.
     *
     * @return void
     */
    public function testGetInvalidManager()
    {
        $this->assertNull($this->application->getManager(MockManager::IDENTIFIER));
    }

    /**
     * Test if the added manager has been returned.
     *
     * @return void
     */
    public function testGetManagers()
    {

        // initialize the managers
        $mgr1 = new MockManager('test_01');
        $mgr2 = new MockManager('test_02');

        // add the managers
        $this->application->addManager($mgr1);
        $this->application->addManager($mgr2);
        $this->assertEquals(2, sizeof($this->application->getManagers()));
        foreach ($this->application->getManagers() as $manager) {
            $this->assertInstanceOf('TechDivision\Application\Interfaces\ManagerInterface', $manager);
        }
    }

    /**
     * Test if the class loaders has been registered successfully.
     *
     * @return void
     */
    public function testRegisterClassLoaders()
    {

        // register the mock class loader instance
        $this->application->addClassLoader($mockClassLoader = new MockClassLoader());
        $this->application->registerClassLoaders();

        // check that the mock class loader has been registered
        $this->assertTrue($mockClassLoader->isRegistered());
    }

    /**
     * Test if the managers has been initialized successfully.
     *
     * @return void
     */
    public function testInitializeManagers()
    {

        // register the mock manager instance
        $this->application->addManager($mockManager = new MockManager());
        $this->application->initializeManagers();

        // check that the mock manager has been initialized
        $this->assertTrue($mockManager->isInitialized());
    }

    /**
     * Test if the getter for the user works.
     *
     * @return void
     */
    public function testGetUser()
    {

        // create a mock system configuration
        $mockSystemConfiguration = $this->getMock('TechDivision\Application\Mock\MockSystemConfiguration', array('getUser'));
        $mockSystemConfiguration->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($user = 'www-data'));

        // define the methods to mock
        $methodsToMock = array('getClassLoader', 'newInstance', 'newService', 'getAttribute', 'getSystemConfiguration');

        // create a mock instance
        $mockInitialContext = $this->getMock('TechDivision\Application\Interfaces\ContextInterface', $methodsToMock);
        $mockInitialContext->expects($this->any())
            ->method('getSystemConfiguration')
            ->will($this->returnValue($mockSystemConfiguration));

        // check if the passed instance is equal to the getter one
        $this->application->injectInitialContext($mockInitialContext);
        $this->assertSame($user, $this->application->getUser());
    }

    /**
     * Test if the getter for the group works.
     *
     * @return void
     */
    public function testGetGroup()
    {

        // create a mock system configuration
        $mockSystemConfiguration = $this->getMock('TechDivision\Application\Mock\MockSystemConfiguration', array('getGroup'));
        $mockSystemConfiguration->expects($this->any())
            ->method('getGroup')
            ->will($this->returnValue($group = 'www-data'));

        // define the methods to mock
        $methodsToMock = array('getClassLoader', 'newInstance', 'newService', 'getAttribute', 'getSystemConfiguration');

        // create a mock instance
        $mockInitialContext = $this->getMock('TechDivision\Application\Interfaces\ContextInterface', $methodsToMock);
        $mockInitialContext->expects($this->any())
            ->method('getSystemConfiguration')
            ->will($this->returnValue($mockSystemConfiguration));

        // check if the passed instance is equal to the getter one
        $this->application->injectInitialContext($mockInitialContext);
        $this->assertSame($group, $this->application->getGroup());
    }

    /**
     * Test if the getter for the group works.
     *
     * @return void
     */
    public function testGetUmask()
    {

        // create a mock system configuration
        $mockSystemConfiguration = $this->getMock('TechDivision\Application\Mock\MockSystemConfiguration', array('getUmask'));
        $mockSystemConfiguration->expects($this->any())
            ->method('getUmask')
            ->will($this->returnValue($umask = 0002));

        // define the methods to mock
        $methodsToMock = array('getClassLoader', 'newInstance', 'newService', 'getAttribute', 'getSystemConfiguration');

        // create a mock instance
        $mockInitialContext = $this->getMock('TechDivision\Application\Interfaces\ContextInterface', $methodsToMock);
        $mockInitialContext->expects($this->any())
            ->method('getSystemConfiguration')
            ->will($this->returnValue($mockSystemConfiguration));

        // check if the passed instance is equal to the getter one
        $this->application->injectInitialContext($mockInitialContext);
        $this->assertSame($umask, $this->application->getUmask());
    }
}
