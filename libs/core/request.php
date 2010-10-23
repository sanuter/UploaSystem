<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Request {

    // Метод запроса
    public $method = 'GET';
    // Тип протокола
    public static $protocol = 'http';
    // IP пользователя
    public $client_ip = '0.0.0.0';
    // Агент
    public $user_agent;
    // Instance
    public static $instance;
    // Текущий путь
    public static $current;
    // Выполняемый командный файл
    protected $controller;
    // Выполняемое действие
    protected $action;
    
    // Текущий роутер
    protected $_router;
    // Текущий адрес
    protected $_url = 'default';
    // Параметры для действия
    protected $_params = array();
    // Поток вывода
    public $response = '';
    // Заголовки +
    public $headers = array();
    // Код состояния
    public $status = '200';

    /**
     * Конструктор
     * 
     * @param string индекс пути 
     */
    public function  __construct( $url ) {

        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->method = $_SERVER['REQUEST_METHOD'];
	}

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
	}

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $this->client_ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $this->client_ip = $_SERVER['REMOTE_ADDR'];
	}

        if($url === NULL) {
             if( !empty($_SERVER['PATH_INFO']) ) {
                    $url = $_SERVER['PATH_INFO'];
             } else {
                    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
             }
             $url= trim($url, '/');
        }

        $router = Router::$_all;        
        if( array_key_exists( $url, $router ) ) {
            $this->_router = $router[$url];
            $this->_url = $url;
            Request::$current = $url;
        } else {
            $this->_router = $router['default'];
        }

        $this->controller = $this->_router['controller'];
        $this->action     = $this->_router['action'];        
    }

    /**
     * Instance
     * 
     * @param string индекс пути
     * @return Core_Request 
     */
    public static function instance( $url = NULL ) {
        if ( self::$instance === NULL ) {            
            self::$instance = new self( $url );
        }
        self::$instance->headers['Content-Type'] = 'text/html; charset='.UploadSystem::$charset;
        return self::$instance;
    }

    /**
     * Выполнение и возврат запроса
     *
     * @param string запрос
     * @return Request
     */
    public static function factory( $url = NULL ) {
        return new Request($url);
    }

    public function send_headers()
    {       
        if ( ! headers_sent())
	{
            foreach ($this->headers as $name => $value)
            {
		if (is_string($name))
		{
                    $value = "{$name}: {$value}";
		}               
                header($value, TRUE);
            }
	}
        return $this;
    }

    /**
     * Выполнение контроллера исходя из роутера, возврат результата
     * 
     * @return $this
     */
    public function execute( $data = array() ) {

        $pre = 'Controller_';
        $class = new ReflectionClass($pre.ucfirst($this->controller));
        if (!$class->isAbstract()) {
                $controller = $class->newInstance($this);
                $class->getMethod('before')->invoke($controller);
		$action = empty($this->action) ? 'index' : $this->action;                
                $class->getMethod('action_'.$action)->invokeArgs($controller, $data );
                $class->getMethod('after')->invoke($controller);
        }
        return $this;
    }

    /**
     * Выполняем редирект
     * 
     * @param string адрес
     * @param int код состояния 
     */
    public function redirect( $url, $code = 302 ) {
        $this->status = $code;
        $this->headers['Location'] = $url;
        $this->send_headers();
        exit();
    }

    public static function get( $key, $method = 'get') {
        if( $method === 'get' ) {
            return $_GET[$key];
        }
        elseif( $method = 'post' ) {
            return $_POST[$key];
        } else {
            return NULL;
        }
    }

    /**
     * Возврат потока вывода
     *
     * @return string
     */
    public function  __toString() {
        return (string) $this->response;
    }

}
?>
