<?php

use Doctrine\Common\ClassLoader;
use Cob\Controller\Action\HelperBroker;
use Prizym\Controller\Action\Helper;

class Bootstrap extends \Cob\Application\Bootstrap
{

    public function _initAutoloaders()
    {
        $loader = new ClassLoader("Proxies", APPLICATION_PATH . '/domain');
        $loader->register();
        
        $loader = new ClassLoader("Prizym", SRC_PATH . '/lib');
        $loader->register();
        
        $loader = new ClassLoader('Doctrine\ORM', SRC_PATH . '/lib/Doctrine/lib');
        $loader->register();
        
        $loader = new ClassLoader('Doctrine\DBAL', SRC_PATH . '/lib/Doctrine/lib/vendor/doctrine-dbal/lib');
        $loader->register();
        
        $loader = new ClassLoader('Doctrine\Common', SRC_PATH . '/lib/Doctrine/lib/vendor/doctrine-common/lib');
        $loader->register();
        
        $loader = new ClassLoader('Symfony', SRC_PATH . '/lib/Doctrine/lib/vendor');
        $loader->register();
    }
    
    public function _initRequestObject()
    {
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');

        $front->setRequest(new \Cob\Controller\Request());
    }

    public function _initViewHelpers()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $view->addHelperPath("Prizym/View/Helper", "Prizym\View\Helper\\");
        $view->getHelper('themePath')->setPath('/themes/');
    }

    public function _initActionHelpers()
    {
        $this->bootstrap('doctrine');
        $em = $this->getResource('doctrine');

        HelperBroker::addHelpers(array(
            new Helper\Service($em),
	    new Helper\Repository($em, $this->getAppNamespace())
        ));
    }

}

