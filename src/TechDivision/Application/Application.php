<?php

/**
 * TechDivision\Application\Application
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
use TechDivision\Application\Interfaces\ManagerInterface;
use TechDivision\Application\Interfaces\ContextInterface;
use TechDivision\Application\Interfaces\ApplicationInterface;
use TechDivision\Application\Interfaces\VirtualHostInterface;

/**
 * The application instance holds all information about the deployed application
 * and provides a reference to the servlet manager and the initial context.
 *
 * @category  Library
 * @package   TechDivision_Application
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Application
 * @link      http://www.appserver.io
 */
class Application extends \Thread implements ApplicationInterface
{

    /**
     * The applications base directory.
     *
     * @var string
     */
    protected $appBase;

    /**
     * The web containers base directory.
     *
     * @var string
     */
    protected $baseDirectory;

    /**
     * The unique application name.
     *
     * @var string
     */
    protected $name;

    /**
     * The initial context instance.
     *
     * @var \TechDivision\Application\Interfaces\ContextInterface
     */
    protected $initialContext;

    /**
     * Storage for the available VHost configurations.
     *
     * @var \TechDivision\Storage\GenericStackable
     */
    protected $virtualHosts;

    /**
     * Storage for the available managers.
     *
     * @var \TechDivision\Storage\GenericStackable
     */
    protected $managers;

    /**
     * Storage for the available class loaders.
     *
     * @var \TechDivision\Storage\GenericStackable
     */
    protected $classLoaders;

    /**
     * Initializes the application context.
     */
    public function __construct()
    {
        $this->managers = new GenericStackable();
        $this->virtualHosts = new GenericStackable();
        $this->classLoaders = new GenericStackable();
    }

    /**
     * Returns a attribute from the application context.
     *
     * @param string $name the name of the attribute to return
     *
     * @throws \Exception
     * @return void
     */
    public function getAttribute($name)
    {
        throw new \Exception(__METHOD__ . ' not implemented yet');
    }

    /**
     * The initial context instance.
     *
     * @param \TechDivision\Application\Interfaces\ContextInterface $initialContext The initial context instance
     *
     * @return void
     */
    public function injectInitialContext(ContextInterface $initialContext)
    {
        $this->initialContext = $initialContext;
    }

    /**
     * Injects the application name.
     *
     * @param string $name The application name
     *
     * @return void
     */
    public function injectName($name)
    {
        $this->name = $name;
    }

    /**
     * Injects the applications base directory.
     *
     * @param string $appBase The applications base directory
     *
     * @return void
     */
    public function injectAppBase($appBase)
    {
        $this->appBase = $appBase;
    }

    /**
     * Injects the containers base directory.
     *
     * @param string $baseDirectory The web containers base directory
     *
     * @return void
     */
    public function injectBaseDirectory($baseDirectory)
    {
        $this->baseDirectory = $baseDirectory;
    }

    /**
     * Returns the application name (that has to be the class namespace, e.g. TechDivision\Example)
     *
     * @return string The application name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the absolute path to the servers document root directory
     *
     * @param string $directoryToAppend The directory to append to the base directory
     *
     * @return string The base directory with appended dir if given
     */
    public function getBaseDirectory($directoryToAppend = null)
    {
        $baseDirectory = $this->baseDirectory;
        if ($directoryToAppend != null) {
            $baseDirectory .= $directoryToAppend;
        }
        return $baseDirectory;
    }

    /**
     * Returns the absolute path to the web application base directory.
     *
     * @return string The path to the webapps folder
     */
    public function getWebappPath()
    {
        return $this->getAppBase() . DIRECTORY_SEPARATOR . $this->getName();
    }

    /**
     * Returns the absolute path to the applications base directory.
     *
     * @return string The app base directory
     */
    public function getAppBase()
    {
        return $this->appBase;
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $className The fully qualified class name to return the instance for
     * @param array  $args      Arguments to pass to the constructor of the instance
     *
     * @return object The instance itself
     * @see \TechDivision\Application\Interfaces\ContextInterface::newInstance()
     */
    public function newInstance($className, array $args = array())
    {
        return $this->getInitialContext()->newInstance($className, $args);
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $className The API service class name to return the instance for
     *
     * @return object The service instance
     * @see \TechDivision\Application\Interfaces\ContextInterface::newService()
     */
    public function newService($className)
    {
        return $this->getInitialContext()->newService($className);
    }

    /**
     * Returns the initial context instance.
     *
     * @return \TechDivision\Application\Interfaces\ContextInterface The initial Context
     */
    public function getInitialContext()
    {
        return $this->initialContext;
    }

    /**
     * Returns the applications available virtual host configurations.
     *
     * @return \TechDivision\Storage\GenericStackable The available virtual host configurations
     */
    public function getVirtualHosts()
    {
        return $this->virtualHosts;
    }

    /**
     * Return the class loaders.
     *
     * @return \TechDivision\Storage\GenericStackable The class loader instances
     */
    public function getClassLoaders()
    {
        return $this->classLoaders;
    }

    /**
     * Returns the manager instances.
     *
     * @return \TechDivision\Storage\GenericStackable The manager instances
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * Return the requested manager instance.
     *
     * @param string $identifier The unique identifier of the requested manager
     *
     * @return \TechDivision\Application\Interfaces\ManagerInterface The manager instance
     */
    public function getManager($identifier)
    {
        if (isset($this->managers[$identifier])) {
            return $this->managers[$identifier];
        }
    }

    /**
     * Checks if the application is a virtual host for the passed server name.
     *
     * @param string $serverName The server name to check the application being a virtual host of
     *
     * @return boolean TRUE if the application is a virtual host, else FALSE
     */
    public function isVHostOf($serverName)
    {

        // check if the application is a virtual host for the passed server name
        foreach ($this->getVirtualHosts() as $virtualHost) {

            // compare the virtual host name itself
            if (strcmp($virtualHost->getName(), $serverName) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Bounds the application to the passed virtual host.
     *
     * @param \TechDivision\Application\Interfaces\VirtualHostInterface $virtualHost The virtual host to add
     *
     * @return void
     */
    public function addVirtualHost(VirtualHostInterface $virtualHost)
    {
        $this->virtualHosts[] = $virtualHost;
    }

    /**
     * Injects an additional class loader.
     *
     * @param object $classLoader A class loader to put on the class loader stack
     *
     * @return void
     */
    public function addClassLoader($classLoader)
    {
        $this->classLoaders[] = $classLoader;
    }

    /**
     * Injects manager instance.
     *
     * @param \TechDivision\Application\Interfaces\ManagerInterface $manager A manager instance
     *
     * @return void
     */
    public function addManager(ManagerInterface $manager)
    {
        $this->managers[$manager->getIdentifier()] = $manager;
    }

    /**
     * Has been automatically invoked by the container after the application
     * instance has been created.
     *
     * @return void
     * @see \Thread::run()
     * @codeCoverageIgnore
     */
    public function connect()
    {
        $this->start();
    }

    /**
     * Registers all class loaders injected to the applications in the opposite
     * order as they have been injected.
     *
     * @return void
     */
    public function registerClassLoaders()
    {
        foreach ($this->getClassLoaders() as $classLoader) {
            $classLoader->register(true, true);
        }
    }

    /**
     * Registers all managers in the application.
     *
     * @return void
     */
    public function initializeManagers()
    {
        foreach ($this->getManagers() as $manager) {
            $manager->initialize();
        }
    }

    /**
     * This is the threads main() method that initializes the application with the autoloader and
     * instanciates all the necessary manager instances.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function run()
    {

        // register the class loaders
        $this->registerClassLoaders();

        // initialize the managers
        $this->initializeManagers();

        // we do nothing here
        while (true) {
            $this->wait();
        }
    }
}
