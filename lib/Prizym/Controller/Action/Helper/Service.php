<?php

namespace Prizym\Controller\Action\Helper;

use Doctrine\ORM\EntityManager;
 
class Service extends \Cob\Controller\Action\Helper\HelperAbstract
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function direct($serviceClass)
    {
        return new $serviceClass($this->em);
    }

}