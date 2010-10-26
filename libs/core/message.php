<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class Core_Message {

    /**
     * Добавляем сообщение
     *  
     * @param string Сообщение 
     */
    public static function add( $text = NULL ) {
        if( $text !== NULL ) {
            Session::instance()->set( '_message', $text );
        }
    }

    /**
     * Возвращаем сообщение
     * 
     * @return string 
     */
    public static function get() {
        if( $message = Session::instance()->get( '_message' ) ) {
            self::clear();
            return $message;
        } else {
            return NULL;
        }
    }

    /**
     *  Очищаем вывод сообщений
     */
    private static function clear() {
        Session::instance()->del( '_message' );
    }
}
?>
