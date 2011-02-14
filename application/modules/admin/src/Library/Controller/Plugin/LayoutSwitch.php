<?php

namespace Application\Admin\Library\Controller\Plugin;

use Cob\Controller\Request;

/**
 * Description of LayoutSwitch
 *
 * @author Cobby
 */
class LayoutSwitch extends \Cob\Controller\Plugin\PluginAbstract
{
    
    private $layout;
    
    public function __construct(\Zend_Layout $layout)
    {
        $this->layout = $layout;
    }
    
    public function routeShutdown(Request $request)
    {
        if($request->getModuleName() === 'admin'){
            $this->layout->setLayoutPath(SRC_PATH . '/public/themes/admin');
            $this->layout->setLayout('backend');
            $this->layout->getView()->getHelper('themePath')->setPath('/themes/admin');
        }
    }
    
}
