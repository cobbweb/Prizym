<?php

namespace Application\Admin;

use Application\Admin\Library\Controller\Plugin,
    Codeblog\Authentication\Authentication;

class Bootstrap extends \Cob\Application\Module\Bootstrap
{
    
    public function _initPlugins()
    {
        $this->bootstrap('frontController');
        $this->getApplication()->bootstrap('layout');
        $this->getApplication()->bootstrap('doctrine');
        
        $front  = $this->getResource('frontController');
        $layout = $this->getApplication()->getResource('layout');
        $em     = $this->getApplication()->getResource('doctrine');

        $front->registerPlugin(new Plugin\LayoutSwitch($layout));
        $front->registerPlugin(new Plugin\Authentication(Authentication::getInstance(), $em));
    }
    
}
