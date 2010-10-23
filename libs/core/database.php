<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Database {
    
    protected static $instance;
    /*
     * @var Соединеие
     */
    protected $_connection;
    /*
     * @var Конфигурация
     */
    protected $_config;
    /*
     * @var Последний запрос
     */
    public $last_sql;
    /*
     * @var Выборка с записи
     */
    public $start = '0';
    /*
     * @var Всего записей в выборке
     */
    public $limit = '5';
    /*
     * @var Сортировка по умочанию
     */
    public $sort = 'DESC';

    const SELECT = 1;
    const INSERT = 2;
    const UPDATE = 3;
    const DELETE = 4;

    private function  __construct() {
        $this->_config = UploadSystem::$config['base'];
        Database::$instance = $this;
    }
    
    /**
     * Database instance
     *
     * @return Datebase
     */
    public static function instance() {
           if( self::$instance === NULL ) {
               self::$instance = new self();
           }
           return self::$instance;
    }

    /**
     * Подключения к базе данных
     *
     * @return void
     */
    private function connect() {
           $this->_connection = mysql_connect($this->_config['hostname'], $this->_config['username'], $this->_config['password'], TRUE);
           $this->_select_db($this->_config['database']);
    }

    /**
     * Выбираем базу
     *
     * @param string имя базы
     */
    private function _select_db( $database ) {
        if ( ! mysql_select_db($database, $this->_connection))
	{

	}
    }

    /**
     * Выполнение запроса к базе и возврат результата
     * 
     * @param string Запрос к базе
     * @return mixed 
     */
    public function query( $sql, $type = 1 ) {

        $this->_connection or $this->connect();

        $this->last_sql = $sql;

        if (($result = mysql_query($sql, $this->_connection)) === FALSE)
	{
            return mysql_errno($this->_connection);
	}

        if( $type == 1) {
            return $this->as_array( $result );
        } elseif($type == 2) {
            return  array(
                        'id'    => mysql_insert_id($this->_connection),
                        'count' => mysql_affected_rows($this->_connection)
                    );
        } else {
            return mysql_affected_rows($this->_connection);
        }
    }

    /**
     * Возвращаем результат как массив
     *
     * @param mixed результат выполнения запроса
     * @return array
     */
    public function as_array( $row ) {
        $result = array();
        if( mysql_affected_rows($this->_connection) > 1 ) {            
            while( $item = mysql_fetch_assoc($row) ) {
                $result[] = $item;
            }
        } else {
            $result = mysql_fetch_assoc($row);
        }
        return $result;
    }

    /**
     * Обработка значений для подстановки в запрос
     *
     * @param string Значение для обработки
     * @return string Обработанное значение
     */
    public function escape($value)
    {
        $this->_connection or $this->connect();
        if (($value = mysql_real_escape_string((string) $value, $this->_connection)) === FALSE)
        {

	}
	return "'$value'";
    }

    /**
     * Завершение соединения с базой
     *
     * @return boolean
     */
    private function disconnect() {

    }

    public function  __destruct() {
        
    }
}
?>
