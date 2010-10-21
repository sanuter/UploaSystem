<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Files extends Core_Files {   

        /**
     * Проверка и создание директории пользователя
     * 
     * @param string имя пользователя
     * @return string Путь к директории пользователя 
     */
    public static function dir_user( $name = NULL) {

        $dir = self::$default_directory;

        if( $name !== NULL ) {
            $dir = DOCROOT.$dir.DIRECTORY_SEPARATOR.md5($name).DIRECTORY_SEPARATOR;
            if( !is_dir($dir) ) {
                mkdir($dir);
            }
        }

        return $dir;
    }

    public static function files_list() {
        $db = Database::instance();
        //$user = Users::instance();
        //$request = Request::instance();

       
       
        if(Request::get('order') !== NULL) {
            if( Request::get('order') === 'DESC' ) {
                $db->sort = 'ASC';
            } else {
                $db->sort = 'DESC';
            }
        }
        
        $order = 'f.data';

        if(Request::get('sort') !== NULL) {
            $order = 'f.'.Request::get('sort');
        }

        $files = $db->query('SELECT f.id as id, f.name as name, f.data as data, f.comment as comment, u.email as user
            FROM files as f, users as u
            WHERE
            f.user_id=u.id
            ORDER BY
            '.$order.' '.$db->sort.'
            LIMIT '.$db->start.','.$db->limit.'
            ');
        return $files;
    }

    /**
     * Сохранение файла и фиксация данных
     * 
     * @param array $_FILES
     * @param string имя файла
     * @param string директория
     * @param intrger chmod маска    
     */
    public static function  save(array $file, $filename = NULL, $directory = NULL, $chmod = 0644) {
        parent::save($file, $filename, $directory, $chmod);

        $db = Database::instance();
        $user = Users::instance();
        $request = Request::instance();

        $db->query( 'INSERT INTO  `files` (`user_id`, `name`, `ip`, `agent`, `comment`)
            VALUES(
                '.$db->escape($user->info->id).',
                '.$db->escape($filename).',
                '.$db->escape($request->client_ip).',
                '.$db->escape($request->user_agent).',
                '.$db->escape(0).'
        );', 'IN' );
    }
}
?>
