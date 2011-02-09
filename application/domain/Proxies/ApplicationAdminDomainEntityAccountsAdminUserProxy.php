<?php

namespace Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class ApplicationAdminDomainEntityAccountsAdminUserProxy extends \Application\Admin\Domain\Entity\Accounts\AdminUser implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function getFirstName()
    {
        $this->_load();
        return parent::getFirstName();
    }

    public function setFirstName($firstName)
    {
        $this->_load();
        return parent::setFirstName($firstName);
    }

    public function getLastName()
    {
        $this->_load();
        return parent::getLastName();
    }

    public function setLastName($lastName)
    {
        $this->_load();
        return parent::setLastName($lastName);
    }

    public function getEmail()
    {
        $this->_load();
        return parent::getEmail();
    }

    public function setEmail($email)
    {
        $this->_load();
        return parent::setEmail($email);
    }

    public function getPassword()
    {
        $this->_load();
        return parent::getPassword();
    }

    public function setPassword($password)
    {
        $this->_load();
        return parent::setPassword($password);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'firstName', 'lastName', 'email', 'password');
    }
}