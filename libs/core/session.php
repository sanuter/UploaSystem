<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class Core_Session {

    // instance
    protected static $instance;

    // Cookie имя
    protected $_name = 'uploadsystem';

    // Cookie время жизни
    protected $_lifetime = 0;

    // Данные сесси
    protected $_data = array();

    // Уничтожить сессию?
    protected $_destroyed = FALSE;

    protected function  __construct( array $config = NULL, $id = NULL ) {
        if(isset($config['name'])) {
            $this->_name = $config['name'];
        }
        if(isset($config['lifetime'])) {
            $this->_lifetime = $config['lifetime'];
        }
        if(isset($config['name'])) {
            $this->_name = $config['name'];
        }
        $this->_read( $id );
    }

    public static function instance( $id = NULL) {
        if( self::$instance === NULL ) {
            self::$instance = $session = new self( UploadSystem::$config['session'], $id );
            register_shutdown_function(array($session, 'write'));
        }
        return self::$instance;
    }

    /**
     * Чтение сессии
     *
     * @param string session_id
     * @return void
     */
    public function read( $id = NULL){
        return $this->_data;
    }

    /**
     * Запись сесси и время последнего доступа
     * 
     * @return boolean 
     */
    public function write() {
        if(headers_list () OR $this->_destroyed) {
            return FALSE;
        }
        $this->_lifetime  = time();
        return $this->_write();
    }

    /**
     * Чтение из сесси переменной
     * 
     * @param string ключ
     * @return mixed 
     */
    public function get( $key ) {
        return (isset($this->_data[ $key ])) ? $this->_data[ $key ] : NULL ;
    }

    /**
     * Запись переменной в сессию
     *
     * @param string ключ
     * @param mixed значение
     * @return Core_Session
     */
    public function set( $key, $value ) {
        $this->_data[ $key ] = $value;
        return $this;
    }

    /**
     * Удаление переменной из сесси
     * 
     * @param string ключ
     * @return Core_Session 
     */
    public function del( $key ) {
        $args = func_get_args();
        foreach($args as $key ) {
            unset($this->_data[ $key ]);
        }        
        return $this;
    }

    /**
     *  Новая сессия
     *
     * @return string
     */
    public function regenerate()  {
        return $this->_regenerate();
    }

    /**
     * Уничтожение текущей сессии
     * 
     * @return boolean
     */
    public function destroy() {
        if( $this->_destroyed === FALSE ) {
            if( $this->_destroyed = $this->_destroy() ) {
                $this->_data = array();
            }
        }
        return $this->_destroyed;
    }


    protected function _read($id = NULL) {        
        session_set_cookie_params($this->_lifetime);
        session_name($this->_name);
        if ($id)
	{
            session_id($id);
	}

        session_start();
       
	$this->_data = & $_SESSION;
        return NULL;
    }

    protected function _regenerate() {
        session_regenerate_id();
        return session_id();
    }

    protected function _write() {
        session_write_close();
        return TRUE;
    }

    protected function _destroy() {
        session_destroy();
        return session_id();
    }


}
?>
