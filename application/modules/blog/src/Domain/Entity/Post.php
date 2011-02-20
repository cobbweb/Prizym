<?php

namespace Application\Blog\Domain\Entity;

use Application\Admin\Domain\Entity\Accounts\AdminUser;

/**
 * Post
 *
 * Blog post
 * 
 * @author Andrew Cobby <cobby@cobbweb.me>
 *
 * @Entity(repositoryClass="Application\Blog\Domain\Repository\PostsRepository")
 * @Table(name="blog_posts")
 */
class Post
{
    
    /**
     * Post ID
     *
     * @var integer
     * 
     * @Column(type="integer")
     * @Id @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Active slug
     *
     * @var Application\Blog\Domain\Entity\PostVersion 
     * 
     * @OneToOne(targetEntity="Application\Blog\Domain\Entity\PostSlug", cascade={"persist"})
     */
    private $slug;
    
    /**
     * Version
     * 
     * @var Application\Blog\Domain\Entity\PostVersion
     * 
     * @OneToOne(targetEntity="Application\Blog\Domain\Entity\PostVersion", cascade={"persist"})
     */
    private $activeVersion;
    
    /**
     * First version
     * 
     * @var Application\Blog\Domain\Entity\PostVersion
     * 
     * @OneToOne(targetEntity="Application\Blog\Domain\Entity\PostVersion", cascade={"persist"})
     */
    private $firstVersion;
    
    private $currentUser;
    
    private $isDirty;
    
    public function getId()
    {
        return $this->id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = new PostSlug($this, $slug);
    }
    
    public function setCurrentUser(AdminUser $user)
    {
	$this->currentUser = $user;
    }

    public function getActiveVersion()
    {
	if(!$this->activeVersion){
	    $this->activeVersion = new PostVersion();
	}
        return $this->activeVersion;
    }

    public function setActiveVersion($activeVersion)
    {
        $this->activeVersion = $activeVersion;
    }

    public function getFirstVersion()
    {
        return $this->firstVersion;
    }

    public function setFirstVersion($firstVersion)
    {
        $this->firstVersion = $firstVersion;
    }
    
    public function setTitle($title)
    {
	$this->_setProperty('title', $title);
    }
    
    public function getTitle()
    {
	return $this->getActiveVersion()->getTitle();
    }
    
    public function setContent($content)
    {
	$this->_setProperty('content', $content);
    }
    
    private function _setProperty($name, $value)
    {
	if(!$this->currentUser){
	    throw new \DomainException("Cannot create a new revision without the current user set");
	}
	
	$newVersion = clone $this->getActiveVersion();
	$reflProp = new \ReflectionProperty(get_class($newVersion), $name);
	$reflProp->setAccessible(true);
	
	if($reflProp->getValue($this->getActiveVersion()) === $value){
	    return false;
	}
	
	$reflProp->setValue($newVersion, $value);
	
	$this->isDirty = true;
	$this->setActiveVersion($newVersion);
	
	if(!$this->firstVersion){
	    $this->setFirstVersion($this->getActiveVersion());
	}
    }
    
}