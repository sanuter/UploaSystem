<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Url {

    /**
     * Текущий адрес
     *
     * @return string
     */
    public static function current() {
        return self::root().Request::$current;
    }

    /**
     * Основной адрес
     * 
     * @param string схема адреса
     * @return string 
     */
    public static function root( $protocol = TRUE ) {

        if( $protocol === TRUE ) {
            $protocol = Request::$protocol;
        }        
        $base_url = UploadSystem::$base_url;
        if (parse_url($base_url, PHP_URL_HOST))
	{
            $base_url = parse_url($base_url, PHP_URL_PATH);
	}
        $base_url = $protocol.'://'.$_SERVER['HTTP_HOST'].$base_url;
	
        return $base_url;
        
    }

    /**
     * Формируем строку запроса
     *
     * @param array массив параметров
     * @return string
     */
    public static function query( array $params ) {
        if($params === NULL) {
            $params = $_GET;
        } else {
            $params = array_merge( $_GET, $params );
        }

        if(empty($params)) {
            return '';
        }
        $query = http_build_query($params, '', '&');
        return ($query === '') ? '' : '?'.$query;
    }
}
?>
