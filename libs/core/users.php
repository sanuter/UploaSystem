<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

<<<<<<< HEAD
abstract class Core_Users {
=======
class Core_Users {
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d

   protected static $instance;

   protected $_db;

   protected $_session;
<<<<<<< HEAD
   
   protected function  __construct() {        
=======
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
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
   }

   /**
    * Instance Users
    *
    * @return Users
    */
<<<<<<< HEAD
   public static function instance() {
=======
   public static function instance()
   {
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
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
<<<<<<< HEAD
    */
   public function login( $username, $password ) {}

   /**
    *  Подготовка к выходу
    */
   public function logout() {}

 
=======
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

>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
}
?>
