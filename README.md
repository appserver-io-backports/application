# TechDivision_Application

[![Latest Stable Version](https://poser.pugx.org/techdivision/application/v/stable.png)](https://packagist.org/packages/techdivision/application) [![Total Downloads](https://poser.pugx.org/techdivision/application/downloads.png)](https://packagist.org/packages/techdivision/application) [![Latest Unstable Version](https://poser.pugx.org/techdivision/application/v/unstable.png)](https://packagist.org/packages/techdivision/application) [![License](https://poser.pugx.org/techdivision/application/license.png)](https://packagist.org/packages/techdivision/application) [![Build Status](https://travis-ci.org/techdivision/TechDivision_Application.png)](https://travis-ci.org/techdivision/TechDivision_Application)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/techdivision/TechDivision_Application/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/techdivision/TechDivision_Application/?branch=master)[![Code Coverage](https://scrutinizer-ci.com/g/techdivision/TechDivision_Application/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/techdivision/TechDivision_Application/?branch=master)

## Introduction

This package provides generic application implementation designed to work in an application
server like appserver.io. The application is based on a thread what allows each application
to have it's own context and therefore it own autoloaders.

## Installation

You don't have to install this package, as it'll be delivered with the latest appserver.io 
release. If you want to install it with your application only, you do this by add

```sh
{
    "require": {
        "techdivision/application": "dev-master"
    },
}
```

to your ```composer.json``` and invoke ```composer update``` in your project.

## Usage

As described in the introduction the application is designed inside a runtime environment like
an application server as appserver.io is. The following example gives you a short introdction 
how you can initialize a new application instance and attach it to a container:

```php

// initialize the application instance
$application = new GenericApplication();

// initialize the generic instances and information
$application->injectInitialContext($this->getInitialContext());
$application->injectContainerNode($container->getContainerNode());
$application->injectAppBase($container->getAppBase());
$application->injectBaseDirectory($container->getBaseDirectory());
$application->injectName($folder->getBasename());

// add the default class loader
$application->addClassLoader($this->getInitialContext()->getClassLoader());

// if we found a WEB-INF directory, we've to initialize the web container specific managers
if ($webInf->isDir()) {
    $application->addManager($this->getAuthenticationManager());
    $application->addManager($this->getSessionManager());
    $application->addManager($this->getServletContext($folder));
    $application->addManager($this->getHandlerManager($folder));
}

// if we found a META-INF directory, we've to initialize the persistence container specific managers
if ($metaInf->isDir()) {
    $application->addManager($this->getBeanManager($folder));
    $application->addManager($this->getQueueManager($folder));
}

// add the application to the available applications
$container->addApplication($application);

```