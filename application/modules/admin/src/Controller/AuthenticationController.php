<?php

namespace Application\Admin\Controller;

/**
 * Description of AuthenticationController
 *
 * @author Cobby
 */
class AuthenticationController extends \Application\Admin\Library\Controller\Action
{
    
    public function loginAction()
    {
        $this->view->layout()->setLayout('login');
        $this->view->headTitle('Login');

        $request = $this->getRequest();

        if($request->isPost()){
            $auth = $this->_helper->service('Application\Admin\Domain\Service\Accounts\AuthenticationService');
            $post = $request->getPost();

            $auth->setUsername($post['username']);
            $auth->setPassword($post['password']);

            if($auth->isValid() && $auth->login()){
                $this->_redirect("/admin/index");
            }else{
                $this->view->errors = $auth->getMessages();
            }
        }
    }
    
}

