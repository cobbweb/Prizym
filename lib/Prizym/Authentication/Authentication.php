<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prizym\Authentication;

/**
 * Description of Authentication
 *
 * @author Cobby
 */
class Authentication extends \Zend_Auth
{
    
    protected static $_instance;


    public static function getInstance()
    {
        if(null == self::$_instance){
            self::$_instance = new static();
        }
        
        return self::$_instance;
    }
    
}

