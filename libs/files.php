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

    /**
     * Проверка и удаление файла
     * 
     * @param integer Id файла 
     */
    public static function file_del( $file = NULL ) {
        if( $file !== NULL) {
            $user = Users::instance()->info;
            $db = Database::instance();

            $fname = $db->query('SELECT name FROM files
                WHERE id='.$file.'');            

            $fname = realpath($user->path).DIRECTORY_SEPARATOR.$fname[0]['name'];

            if( is_file( $fname ) ) {
                if( unlink($fname) ) {
                    $db->query('DELETE FROM files WHERE files.id = '.$file.'','IN');
                    $db->query('DELETE FROM comments WHERE comments.files_id = '.$file.'','IN');
                }
            }
        }
    }

    /**
     * Выборка списка файлов
     *
     * @param string Направление сортировки
     * @param string Сортировка по полю
     * @return array
     */
    public static function files_list( $sort = 'DESC', $order = 'data' ) {
        $db = Database::instance();
        $user = Users::instance();
        //$request = Request::instance();       
       
        $db->sort = $sort;
        
        $order = 'f.'.$order;

        $add_filter='';

        if( $user->info !== NULL ) {
            $add_filter = ' AND f.user_id = '.$user->info->id.' ';
        } else {
            $add_filter = ' AND f.vid = 1 ';
        }

        $files = $db->query('SELECT f.id as id, f.name as name, f.data as data, f.comment as comment, f.vid as vid, u.email as user
            FROM files as f, users as u
            WHERE
            f.user_id=u.id '.$add_filter.'
            ORDER BY
            '.$order.' '.$db->sort.'
            LIMIT '.$db->start.','.$db->limit.'
            ');

        /* TODO return resut */
        if( $files[0] === FALSE ) {
            return FALSE;
        } else {
            return $files;
        }
    }

    public static function file_show( $id = NULL ){
        if( $id !== NULL) {
            $db = Database::instance();

            $type = $db->query('SELECT comment FROM files WHERE id = '.(int)$id);

            if($type[0]['comment'] == 1) {
                $db->query('UPDATE files SET comment=0 WHERE id = '.(int)$id, 'IN');
            } else {
                $db->query('UPDATE files SET comment=1 WHERE id = '.(int)$id, 'IN');
            }

            return TRUE;

        } else {
            return FALSE;
        }
    }

    public static function file_vid( $id = NULL ){
        if( $id !== NULL) {
            $db = Database::instance();

            $type = $db->query('SELECT vid FROM files WHERE id = '.(int)$id);

            if($type[0]['vid'] == 1) {
                $db->query('UPDATE files SET vid=0 WHERE id = '.(int)$id, 'IN');
            } else {
                $db->query('UPDATE files SET vid=1 WHERE id = '.(int)$id, 'IN');
            }

            return TRUE;

        } else {
            return FALSE;
        }
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
