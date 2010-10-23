<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class Users extends Core_Users {

   /*
   * @var Данные текущего пользователя
   */
   public $info;
   /*
   * @var  string  Текущий пользователь
   */
   protected static $_current_user;

   protected function  __construct() {
       parent::__construct();
        $this->_db = Database::instance();
        $this->_session = Session::instance();
        if( $this->_session->get('user') !== NULL ) {
            $this->info = (object)$this->_session->get('user');
        }
   }
   
   /**
     * User instance
     *
     * @return User
     */
    public static function instance() {
       if( self::$instance === NULL ) {
            self::$instance = new self();
       }
       return self::$instance;
    }

   /**
    * Текущий пользователь
    *
    * @return int id
    */
    public static function current_user() {
       $user = self::instance();
       if( $user->info !== NULL) {
           return $user->info->id;
       } else {
           return NULL;
       }
   }

   /**
    * Поиск и возврат параметра пользователя
    * 
    * @param string ключ параметра
    * @return string параметр пользователя 
    */
   public static function user_param( $key ) {
       if( $user = self::instance() !== NULL ) {
            if( isset( $user->info->{$key}) ) {
                return $user->info->{$key};
            } else {
                return NULL;
            }
       }
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
        if($result) {       
            $this->_session->set( 'user', array_merge( $result, array( 'path' => Files::dir_user( $result['email'] ) ) ) );
            return TRUE;
        } else {
            return FALSE;
        }
   }

   public function logout() {
        return $this->_session->destroy();
   }
}
?>
