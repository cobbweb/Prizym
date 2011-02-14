<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Description of EntityTestCase
 *
 * @author Cobby
 */
class EntityTestCase extends PHPUnit_Framework_TestCase
{
    
    protected $em;

    public function _getEntityMetadataForModule($module) 
    {
        $moduleName = ucfirst(strtolower($module));
        $namespace = "Application\\$moduleName\Domain\Entity";
        $path = SRC_PATH . "/application/modules/$module/src/Domain/Entity";
        $metadata = array();
        
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        
        while($it->valid()){
            if(!$it->isFile()){
                $it->next();
                continue;
            }
            
            if(stripos($it->getFilename(), '.php') !== false){
                $class = $namespace . '\\' . substr($it->getSubPathname(), 0, -4);
                $class = str_replace(DIRECTORY_SEPARATOR, '\\', $class);
                $metadata[] = $this->em->getClassMetadata($class);
            }
            
            $it->next();
        }
        
        return $metadata;
    }
    
    public function dropSchema($options)
    {
	if(isset($options['path']) && file_exists($options['path'])){
	    unlink($options['path']);
	}
    }

    public function getEntities() 
    {
        $it = new DirectoryIterator(APPLICATION_PATH . '/modules');
        $metadata = array();
        
        while($it->valid()){
            if(is_dir($it->getPathname() . '/src/Domain/Entity')){
                $mds = $this->_getEntityMetadataForModule($it->getFilename());
                foreach($mds as $md){
                    $metadata[] = $md;
                }
            }
            $it->next();
        }
        
        return $metadata;
    }
    
    public function setUp()
    {
        global $application;
        $application->bootstrap();
        
        $this->em = $application->getBootstrap()->getResource('doctrine');
	
	$this->dropSchema($this->em->getConnection()->getParams());
        
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $schemaTool->createSchema($this->getEntities());
        
        parent::setUp();
    }
    
    public function tearDown()
    {
	$this->dropSchema($this->em->getConnection()->getParams());
    }
    
}
