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
        $this->_request = Request::instance();
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
    * Подготовка ко входу и вход
    * 
    * @param string имя
    * @param string пароль
    * @return boolean 
    */
   public function login( $username, $password ) {
       
       if( !preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $username) ) {
           Message::add('Неверный формат логина.');
           $this->_request->redirect();
       }

       if( !preg_match("/^[a-zA-Z0-9]{8,}$/", $password) ) {
           Message::add('Пароль менее 8 символов.');
           $this->_request->redirect();
       }      

        $password = md5((string)$password);

        $result = $this->_db->query('SELECT * FROM $__users WHERE email = '.$this->_db->escape($username).' AND password = '.$this->_db->escape($password).'');
         if(is_array($result)) {
            $this->_session->set( 'user', array_merge( $result, array( 'path' => Files::dir_user( $result['email'] ) ) ) );
            return TRUE;
        } else {
            Message::add('Нет пользователя с такими данными.');
            $this->_request->redirect();
        }
   }

   public function logout() {        
        return $this->_session->destroy();
        Message::add('Вы вышли из системы.');
        $this->_request->redirect();
   }
}
?>
