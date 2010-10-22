<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Users {

   protected static $instance;

   protected $_db;

   protected $_session;
   // Данные текущего пользователя
   public $info;
   /**
   * @var  string  Текущий пользователь
   */
   protected static $_current_user;

   protected function  __construct() {
        $this->_db = Database::instance();
        $this->_session = Session::instance();
        if( $this->_session->get('user') !== NULL ) {
            $this->info = (object)$this->_session->get('user');
        }
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
   public function login( $username, $password ) {
       
        if( empty($username) || empty($password) ) {
            return FALSE;
        }

        if(is_string($password)) $password = md5($password);

        $result = $this->_db->query('SELECT * FROM users WHERE email = '.$this->_db->escape($username).' AND password = '.$this->_db->escape($password).'');
        $info = $result[0];
        if($info) {
            $this->_session->set( 'guest', (int) '1' );           
            $this->_session->set( 'user', array_merge( $info, array( 'path' => Files::dir_user( $info['email'] ) ) ) );
            return TRUE;
        } else {
            return FALSE;
        }
   }

   public function logout() {
        return $this->_session->destroy();
   }

   public function  __destruct() {
        
    }

}
?>
