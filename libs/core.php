<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Libs_Core {

    /* Инициализация */
    protected static $_init;

    /* Конфигурация */
    public static $config;

    /* Пути системы */
    protected static $_paths = array(DOCROOT, LIBSPATH, TMPLPATH, FILESPATH);

    /**
     * Инициализация системы
     *
     * @return boolean
     */
    public static function init() {
        if( UploadSystem::$_init ) {
            return;
        }
        UploadSystem::$config = Config::load('config');
        UploadSystem::$_init = TRUE;
    }

    /**
     * Загрузка библиотек
     *
     * @param string $class
     * @return boolean
     */
    public static function auto_load($class) {
        $file = str_replace('_', '/', strtolower($class));
        if ($path = UploadSystem::find_file('libs', $file))
	{
                require $path;
		return TRUE;
	}
        return FALSE;
    }

    /**
     * Поиск файлов
     * 
     * @param string Директория
     * @param string Файл
     * @param string Расширение файла
     * @return string 
     */
    public static function find_file($dir, $file, $ext = NULL) {
        $ext = ($ext === NULL) ? '.php' : '.'.$ext;
        
        if(empty($dir)) {
            $path = $file.$ext;
        } else {
            $path = $dir.DIRECTORY_SEPARATOR.$file.$ext;
        }

        $found = FALSE;

	foreach (UploadSystem::$_paths as $dir)
	{
		if (is_file($dir.$path))
		{
			$found = $dir.$path;
			break;
		}
	}
        return $found;
    }

    /**
     * Пути системы
     *
     * @return array
     */
    public static function get_paths() {
        return UploadSystem::$_paths;
    }
}
?>
