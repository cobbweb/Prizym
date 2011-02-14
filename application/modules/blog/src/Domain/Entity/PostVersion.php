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

namespace Application\Blog\Domain\Entity;

/**
 * Description of PostVersion
 *
 * @author Cobby
 * @Entity
 * @Table(name="blog_post_versions")
 */
class PostVersion
{

    /**
     * Revision ID
     *
     * @var integer
     * 
     * @Column(type="integer")
     * @Id @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Post title
     *
     * @var string
     * 
     * @Column(type="string", nullable="true")
     */
    private $title;
    
    /**
     * Body of the post
     * 
     * @var string
     * 
     * @Column(type="text", nullable="true")
     */
    private $content;
    
    /**
     * Revision author
     *
     * @var Application\Admin\Domain\Entity\Accounts\AdminUser
     * 
     * @ManyToOne(targetEntity="Application\Admin\Domain\Entity\Accounts\AdminUser")
     */
    private $author;
    
    /**
     * Revision creation date
     *
     * @var DateTime
     * 
     * @Column(type="datetime")
     */
    private $dateAuthored;
    
    /**
     * Post this revision belongs to
     *
     * @var Application\Blog\Domain\Entity\Post
     * 
     * @OneToOne(targetEntity="Application\Blog\Domain\Entity\Post")
     */
    private $post;
    
    public function __construct()
    {
        $this->dateAuthored = new \DateTime();
    }
    
    public function __clone()
    {
	if($this->id){
	    $this->dateAuthored = new \DateTime();
	}
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getDateAuthored()
    {
        return $this->dateAuthored;
    }

    public function setDateAuthored($dateAuthored)
    {
        $this->dateAuthored = $dateAuthored;
    }

}
