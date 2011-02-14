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
 * Description of PostSlug
 *
 * @author Cobby
 * @Entity
 * @Table(name="blog_post_slugs")
 */
class PostSlug
{
    
    /**
     * Slug ID
     *
     * @var integer
     * 
     * @Column(type="integer")
     * @Id @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Slug string
     *
     * @var string
     * 
     * @Column(type="string")
     */
    private $slug;
    
    /**
     * Blog post
     *
     * @var Application\Blog\Domain\Entity\Post
     * 
     * @OneToOne(targetEntity="Application\Blog\Domain\Entity\Post")
     */
    private $post;
    
    public function __construct(Post $post, $slug)
    {
	$this->post = $post;
	$this->setSlug($slug);
    }
    
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
	// make sure the string is a slug
        $this->slug = \Cob\Stdlib\String::create($slug)->slugize();
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
    }
    
}
