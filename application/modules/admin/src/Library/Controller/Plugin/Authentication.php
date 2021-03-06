<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Admin\Library\Controller\Plugin;

use Cob\Controller\Request,
    Prizym\Authentication\Authentication as Auth,
    Doctrine\ORM\EntityManager;

/**
 * Description of Authentication
 *
 * @author Cobby
 */
class Authentication extends \Cob\Controller\Plugin\PluginAbstract
{
    
    protected $auth;
    protected $em;

    public function __construct(Auth $auth, EntityManager $em)
    {
        $this->auth = $auth;
        $this->em   = $em;
    }
    
    public function routeShutdown(Request $request)
    {
        if($request->getModuleName() !== 'admin'){
            return true;
        }
        
        if($request->getControllerName() !== 'authentication' && $request->getActionName() !== 'login' && !$this->auth->hasIdentity()){
            $request->setControllerName('authentication')
                    ->setActionName('login');
        }else if($this->auth->hasIdentity()){
            $this->em->merge($this->auth->getIdentity());
        }
    }
    
}

