<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Router {

    protected $default = array( 'action' => 'index' );

    public static $current;

    public static $_all;

    protected function  __construct( $url ) {

    }

    /**
     * Добавление запроса
     * 
     * @param string ключ
     * @param array массив запроса 
     */
    public static function set( array $param ) {
       foreach($param as $url=>$value) {
           self::$_all[ $url ] = $value;
       }
    }

    /**
     * Выборка путь
     *
     * @param string $key
     * @return array
     */
    public static function get( $key ) {
       return self::$_all[ $key ];
    }

    /**
     * Генерация пути
     * 
     * @param array $param
     * @return string 
     */
    public static function url( $param ){
        if(is_array($param)){
            $url = self::$current;
            foreach($param as $value) {
                $url .= $value.'/';
            }
            return $url = substr( $url, 0, -1);
        } else {
            return self::$current;
        }
    }
}
?>
