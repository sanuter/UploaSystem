<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

abstract class Core_Users {

   protected static $instance;

   protected $_db;

   protected $_session;
   
   protected function  __construct() {        
   }

   /**
    * Instance Users
    *
    * @return Users
    */
   public static function instance()
   {
        if ( self::$instance === NULL ) {
            self::$instance = new self;
	}
	return self::$instance;
    }

   /**
    * Подготовка ко входу и вход
    * 
    * @param string имя
    * @param string пароль
    * @return boolean 
    */
   abstract public function login( $username, $password ) {}

    abstract public function logout() {}

   protected function  __destruct() {
        
    }

}
?>
