<?php

namespace Prizym\Controller\Action\Helper;

use Doctrine\ORM\EntityManager;
 
class Repository extends \Cob\Controller\Action\Helper\HelperAbstract
{

    private $em;
    private $appNamespace;

    public function __construct(EntityManager $em, $appNamespace)
    {
        $this->em = $em;
	$this->appNamespace = $appNamespace;
    }

    public function direct($entity, $namespace=null)
    {
	if(null === $namespace){
	    $namespace = $this->appNamespace;
	}
	
        return $this->em->getRepository($namespace . '\\' . $entity);
    }

}