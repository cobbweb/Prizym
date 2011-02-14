<?php

namespace Application\Admin\Domain\Service\Accounts;

use Doctrine\ORM\EntityManager,
    Cob\Stdlib\String,
    Zend_Validate_EmailAddress as EmailAddress,
    Prizym\Authentication\Authentication;
 
class AuthenticationService implements \Zend_Auth_Adapter_Interface
{

    private $em;

    private $username;

    private $password;

    protected $_messages = array();

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = new String($password);
    }

    public function isValid()
    {
        $emailValidator = new EmailAddress();

        if(empty($this->username) || empty($this->password)){
            $this->_messages[] = "Please enter your username and password";
            return false;
        }

        if(!$emailValidator->isValid($this->username)){
            $this->_messages[] = "Please enter a valid email address";
            return false;
        }

        return true;
    }

    public function getMessages()
    {
        return $this->_messages;
    }

    public function authenticate()
    {
        // find user
        $repository = $this->em->getRepository("Application\Admin\Domain\Entity\Accounts\AdminUser");
        $user = $repository->findOneBy(array(
            'email'     => $this->username,
            'password'  => $this->password->password()
        ));

        if($user){
            // user exists
            $user->touch();
            $this->em->persist($user);

            return new \Zend_Auth_Result(\Zend_Auth_Result::SUCCESS, $user);
        }

        // login failed
        return new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, $this->username, array('Invalid username/password combination.'));
    }

    public function login()
    {
        $auth = Authentication::getInstance();

        $result = $auth->authenticate($this);

        if(!$result->isValid()){
            foreach($result->getMessages() as $message){
                $this->_messages[] = $message;
            }

            return false;
        }
        
        return true;
    }

}