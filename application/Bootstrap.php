<?php


use Doctrine\Common\ClassLoader;

class Bootstrap extends \Cob\Application\Bootstrap
{

    public function _initAutoloaders()
    {
        $loader = new ClassLoader("Proxies", APPLICATION_PATH . '/domain');
    }
    
    public function _initRequestObject()
    {
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');

        $front->setRequest(new \Cob\Controller\Request());
    }

}

