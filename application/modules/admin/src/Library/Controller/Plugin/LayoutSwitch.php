<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
            $this->layout->setLayout('admin/backend');
        }
    }
    
}
