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
            $fname = $db->query('SELECT name FROM $__files WHERE id='.$file.'');
            $fname = realpath(Users::instance()->info->path).DIRECTORY_SEPARATOR.$fname['name'];

            if( is_file( $fname ) ) {
                if( unlink($fname) ) {
                    $db->query('DELETE FROM $__files WHERE id = '.$file.'',4);
                    $db->query('DELETE FROM $__files_param WHERE files_id = '.$file.'',4);
                    $db->query('DELETE FROM $__comments_tree WHERE item_id IN (SELECT id FROM $__comments WHERE files_id = '.$file.')',4);
                    $db->query('DELETE FROM $__comments WHERE files_id = '.$file.'',4);
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
        $limit = UploadSystem::$config['files']['onpage'];
               
        $order = 'f.'.$order;

        $add_filter='';

        if( Users::current_user() !== NULL ) {
            $add_filter = ' AND f.id IN (SELECT files_id FROM $__files_param WHERE users_id = '.Users::current_user().')';
        } else {
            $add_filter = ' AND f.id IN (SELECT files_id FROM $__files_param WHERE visibly = 1)';
        }

        $files = $db->query('SELECT 
                f.id as id,
                f.name as name,
                f.data as data,
                fp.comment as comment,
                fp.visibly as vid,
                u.email as user
            FROM
                $__files as f,
                $__files_param as fp,
                $__users as u
            WHERE
                fp.users_id=u.id AND f.id=fp.files_id '.$add_filter.'
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
    public static function files_all_list() {
        
        $db = Database::instance();

        if( Users::current_user() !== NULL ) {
            $sql = 'SELECT COUNT(files_id) as items FROM $__files_param WHERE users_id = '.Users::current_user().'';
        } else {
            $sql = 'SELECT COUNT(files_id) as items FROM $__files_param WHERE visibly = 1';
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
            
            $type = $db->query('SELECT comment FROM $__files_param WHERE files_id = '.(int)$id);

            if($type['comment'] == 1) {
                $db->query('UPDATE $__files_param SET comment=0 WHERE files_id = '.(int)$id, 'IN');
            } else {
                $db->query('UPDATE $__files_param SET comment=1 WHERE files_id = '.(int)$id, 'IN');
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

            $type = $db->query('SELECT visibly FROM $__files_param WHERE files_id = '.(int)$id);

            if($type['visibly'] == 1) {
                $db->query('UPDATE $__files_param SET visibly=0 WHERE files_id = '.(int)$id, 3 );
            } else {
                $db->query('UPDATE $__files_param SET visibly=1 WHERE files_id = '.(int)$id, 3 );
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

        if (parent::$remove_spaces === TRUE) {
            $filename = preg_replace('/\s+/', '_', $filename);
	}
        
        if ($directory === NULL) {
            $directory = parent::$default_directory;
	}  
        
        if ( ! isset($file['tmp_name']) OR ! is_uploaded_file($file['tmp_name'])) {
            return FALSE;
	}

        if (parent::$remove_spaces === TRUE) {
            $filename = preg_replace('/\s+/', '_', $filename);
	}

	if ($directory === NULL) {
            $directory = self::$default_directory;
	}

        if(is_file(realpath($directory).DIRECTORY_SEPARATOR.$filename)) {
            $i=0;
            do {
                $i++;
                $number = sprintf("%03d", $i );
                $temp = $number.'_'.$filename;
            } while(is_file(realpath($directory).DIRECTORY_SEPARATOR.$temp));
            $filedb = $filename = $temp;
        } else {
            $filedb = $filename;
        }

	$filename = realpath($directory).DIRECTORY_SEPARATOR.$filename;

	if (move_uploaded_file($file['tmp_name'], $filename))
	{
            if ($chmod !== FALSE)
            {
                chmod($filename, $chmod);
            }

            $db      = Database::instance();
            $request = Request::instance();

            $result = $db->query( 'INSERT INTO $__files (`name`, `ip`, `agent` )
                VALUES(
                    '.$db->escape($filedb).',
                    '.$db->escape($request->client_ip).',
                    '.$db->escape($request->user_agent).'
            );', 2 );

            $db->query( 'INSERT INTO $__files_param (`files_id`, `users_id`, `comment`, `visibly` )
                VALUES(
                    '.$db->escape($result['id']).',
                    '.$db->escape(Users::current_user()).',
                    '.$db->escape(0).',
                    '.$db->escape(0).'
            );', 2 );
            }

	return FALSE;
    }

    public static function media( $file ) {
        $temp = pathinfo($file);
        $type = $temp['extension'];
        unset($temp);
        if( $type == 'js' ) {
            return Url::template().'media/js/'.$file;
        } elseif( $type == 'css') {
            return Url::template().'media/css/'.$file;
        } elseif( in_array( strtolower($type), array('png','jpg','gif') )) {
            return Url::template().'media/images/'.$file;
        } else {
            return NULL;
        }

    }
}
?>
