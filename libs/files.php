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
            
            $db = Database::instance();
            $fname = $db->query('SELECT name FROM files WHERE id='.$file.'');
            $fname = realpath(Users::user_param('path')).DIRECTORY_SEPARATOR.$fname['name'];

            if( is_file( $fname ) ) {
                if( unlink($fname) ) {
                    $db->query('DELETE FROM files WHERE id = '.$file.'',4);
                    $db->query('DELETE FROM files_param WHERE files_id = '.$file.'',4);
                    $db->query('DELETE FROM comments_tree WHERE item_id IN (SELECT id FROM comments WHERE files_id = '.$file.')',4);
                    $db->query('DELETE FROM comments WHERE comments.files_id = '.$file.'',4);
                }
            }
        }
    }

    /**
     * Выборка списка файлов
     *
     * @param string Направление сортировки
     * @param string Сортировка по полю
     * @param int    С записи начать
     * @param int    Всего выбрать записей
     * @return array
     */
    public static function files_list( $sort = 'DESC', $order = 'data', $start = 0 ) {
        
        $db    = Database::instance();
        $limit = 5;
              
        $order = 'f.'.$order;

        $add_filter='';

        if( Users::current_user() !== NULL ) {
            $add_filter = ' AND f.id IN (SELECT files_id FROM files_param WHERE users_id = '.Users::current_user().')';
        } else {
            $add_filter = ' AND f.id IN (SELECT files_id FROM files_param WHERE visibly = 1)';
        }

        $files = $db->query('SELECT 
                f.id as id,
                f.name as name,
                f.data as data,
                fp.comment as comment,
                fp.visibly as vid,
                u.email as user
            FROM
                files as f,
                files_param as fp,
                users as u
            WHERE
                f.user_id=u.id AND f.id=fp.files_id'.$add_filter.'
            ORDER BY
                '.$order.' '.$sort.'
            LIMIT '.$start.','.$limit.'
            ');

        return $files;
    }

    /**
     * Всего файлов
     * 
     * @return mixed
     */
    public function files_all_list() {
        
        $db = Database::instance();

        if( Users::current_user() !== NULL ) {
            $sql = 'SELECT COUNT(files_id) as all FROM files_param WHERE users_id = '.Users::current_user().'';
        } else {
            $sql = 'SELECT COUNT(files_id) as all FROM files_param WHERE visibly = 1)';
        }

        return $db->query( $sql );
    }

    /**
     * Скрыть/Отобразить комментарии
     * 
     * @param string id файла
     * @return boolean 
     */
    public static function file_show( $id = NULL ){
        if( $id !== NULL) {
            $db = Database::instance();

            $type = $db->query('SELECT comment FROM files_param WHERE files_id = '.(int)$id);

            if($type['comment'] == 1) {
                $db->query('UPDATE files_param SET comment=0 WHERE files_id = '.(int)$id, 'IN');
            } else {
                $db->query('UPDATE files_param SET comment=1 WHERE files_id = '.(int)$id, 'IN');
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Скрыть/Отобразить файл
     * 
     * @param string id файла
     * @return boolean 
     */
    public static function file_vid( $id = NULL ){
        if( $id !== NULL) {
            $db = Database::instance();

            $type = $db->query('SELECT visibly FROM files_param WHERE files_id = '.(int)$id);

            if($type['vid'] == 1) {
                $db->query('UPDATE files_param SET visibly=0 WHERE files_id = '.(int)$id, 3 );
            } else {
                $db->query('UPDATE files_param SET visibly=1 WHERE files_id = '.(int)$id, 3 );
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

        $db      = Database::instance();
        $request = Request::instance();

        $result = $db->query( 'INSERT INTO files (`name`, `ip`, `agent` )
            VALUES(
                '.$db->escape($filename).',
                '.$db->escape($request->client_ip).',
                '.$db->escape($request->user_agent).'
        );', 2 );

        $db->query( 'INSERT INTO files_param (`files_id`, `user_id`, `comment`, `visibly` )
            VALUES(
                '.$db->escape($result['id']).',
                '.$db->escape(Users::current_user()).',
                '.$db->escape(0).',
                '.$db->escape(0).'
        );', 2 );
    }
}
?>
