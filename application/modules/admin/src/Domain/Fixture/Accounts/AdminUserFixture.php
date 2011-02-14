<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Admin\Domain\Fixture\Accounts;

use Application\Admin\Domain\Entity\Accounts\AdminUser,
    Cob\Stdlib\String;

/**
 * Description of AdminUserFixture
 *
 * @author Cobby
 */
class AdminUserFixture extends \Cob\ORM\Fixture\Fixture
{
    
    public function getEntities()
    {
        $cobby = new AdminUser();
        $cobby->setFirstName('Andrew');
        $cobby->setLastName('Cobby');
        $cobby->setEmail('cobby@cobbweb.me');
        $cobby->setPassword('pass2173');
        
        return array($cobby);
    }

    
}

