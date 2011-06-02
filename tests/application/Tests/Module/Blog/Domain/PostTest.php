<?php

/*
 * Copyright (C) 2011 by Andrew Cobby <cobby@cobbweb.me>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Tests\Module\Blog\Domain\Entity;

use Application\Blog\Domain\Entity\Post,
    Application\Admin\Domain\Entity\Accounts\AdminUser,
    Cob\Stdlib\String;

/**
 * Blog Post Unit Test
 *
 * @author Cobby
 */
class PostTest extends \EntityTestCase
{
    
    protected $users;
    
    public function setUp()
    {
	parent::setUp();
	
	$this->_setupUsers();
    }
    
    protected function _setupUsers()
    {
	$eu = new \Cob\ORM\EntityUtil($this->em);
	$this->users['cobby'] = $eu->createEntity(new AdminUser(), array(
	    'firstName' => 'Andrew',
	    'lastName'	=> 'Cobby',
	    'password'	=> String::create('pass')->password(),
	    'email'	=> 'cobby@cobbweb.me'
	));
    }
    
    /**
     * @expectedException DomainException
     */
    public function testCannotSetPropertyWithoutCurrentUser()
    {
	$post = new Post();
	$post->setTitle('Test 1');
    }

    public function testBasicVersioning()
    {
        $post = new Post();
	$post->setCurrentUser($this->users['cobby']);
	$post->setTitle('Test 1');
	
	$this->em->persist($post);
	$this->em->flush();
	
	$posts = $this->em->getRepository('Application\Blog\Domain\Entity\Post')->findAll();
	$this->assertEquals('Test 1', $posts[0]->getTitle());
    }
    
    public function testVersioning()
    {
	$post = new Post();
	$post->setCurrentUser($this->users['cobby']);
	$post->setTitle('Test 1');
	
	$this->em->persist($post);
	$this->em->flush();
	
	$post->setTitle('Test 2');
	
	$this->em->persist($post);
	$this->em->flush();
	
	$versions = $this->em->getRepository('Application\Blog\Domain\Entity\PostVersion')->findAll();
	
	$this->assertEquals(2, count($versions));
	$this->assertEquals('Test 1', $versions[0]->getTitle());
	$this->assertEquals('Test 2', $versions[1]->getTitle());
    }
    
    public function testFirstVersionIsKept()
    {
	$post = new Post();
	$post->setCurrentUser($this->users['cobby']);
	$post->setTitle('Test 1');
	
	$this->em->persist($post);
	$this->em->flush();
	
	$post->setTitle('Test 2');
	
	$this->em->persist($post);
	$this->em->flush();
	
	$this->assertEquals('Test 1', $post->getFirstVersion()->getTitle());
    }
    
}
