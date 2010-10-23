<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_View {

    // массив переменных
    protected $_data = array();
    // файл шаблона
    protected $_file;
    // Instance
    public static $instance;

    /**
     * Конструктор
     *
     * @param string файл шаблона
     * @param array массыв переменных     
     */
    public function  __construct( $file = NULL, $data = NULL ) {
        if( $file !== NULL ) {
            $this->set_template( $file );
        }
        if( $data !== NULL ) {
            $this->_data = array_merge( $this->_data, $data );
        }
    }

    /**
     * Instance
     *
     * @param string файл шаблона
     * @param array массив переменных
     * @return Core_View
     */
    public static function instance( $file = NULL, $data = NULL ) {
            if(self::$instance === NULL ) {
                self::$instance = new self( $file, $data );
            }
            return self::$instance;
    }

    /**
     * Создание экземпляра
     *
     * @param string файл шаблона
     * @param array массив переменных
     * @return Core_View 
     */
    public static function factory( $file = NULL, $data = NULL ) {
        return new self( $file, $data );
    }

    /**
     * Устанавливаем шаблон
     *
     * @param string файл шаблона
     * @return Core_View
     */
    public function set_template( $file ) {
        if($path = UploadSystem::find_file('tmpl', $file)) {
            $this->_file = $path;
            return $this;
        } else {

        }
    }

    /**
     * Определение переменных для шаблона
     * 
     * @param string Индекс или массив
     * @param mixed Значение
     * @return $this 
     */
    public function set($key, $value = NULL) {
	if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->_data[$name] = $value;
            }
	} else {
            $this->_data[$key] = $value;
	}
        return $this;
    }

    /**
     * Формирование переменных для шаблона и вывод потока
     * 
     * @return string 
     */
    public function render() {
        extract( (array) $this->_data, EXTR_SKIP );               
        ob_start();
        try {
            include $this->_file;
        } catch ( Exception $e) {
            ob_end_clean();
            throw $e;
        }
        return ob_get_clean();
    }

    public function __toString() {
        try {
            return $this->render();
	} catch (Exception $e) {
            return '';
	}
    }

}
?>
