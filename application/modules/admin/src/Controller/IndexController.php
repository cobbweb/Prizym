<?php

namespace Application\Admin\Controller;

/**
 * Description of IndexController
 *
 * @author Cobby
 */
class IndexController extends \Application\Admin\Library\Controller\Action
{
    
    public function indexAction()
    {
	    $this->view->headTitle('Prizym');
    }
    
}

