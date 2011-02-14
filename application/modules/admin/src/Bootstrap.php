<?php

namespace Application\Admin;

use Application\Admin\Library\Controller\Plugin,
    Prizym\Authentication\Authentication;

class Bootstrap extends \Cob\Application\Module\Bootstrap
{
    
    public function _initPlugins()
    {
        $this->bootstrap('frontController');
	$application = $this->getApplication();
        $application->bootstrap('layout');
        $application->bootstrap('doctrine');
	$application->bootstrap('view');
        
        $front  = $this->getResource('frontController');
        $layout = $application->getResource('layout');
        $em     = $application->getResource('doctrine');
	$view   = $application->getResource('view');

        $front->registerPlugin(new Plugin\LayoutSwitch($layout));
        $front->registerPlugin(new Plugin\Authentication(Authentication::getInstance(), $em));
	$front->registerPlugin(new Plugin\ViewSetup($view));
	
    }
    
}
