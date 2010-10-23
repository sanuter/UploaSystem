<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Core {

    // Инициализация
    protected static $_init;

    // Конфигурация
    public static $config;

    // Основной путь для системы
    public static $base_url;

    // Версия системы
    public static $version = '1.0.0';

    // Кодировка по умолчанию
    public static $charset = 'utf-8';

    // Пути системы
    protected static $_paths = array(DOCROOT, FILESPATH, APPLPATH, TMPLPATH, LIBSPATH);

    /**
     * Инициализация системы
     *
     * @return boolean
     */
    public static function init() {
        if( self::$_init ) {
            return;
        }
        self::$config = Config::load('config');
        self::$base_url = self::$config['base_url'];
        self::$_init = TRUE;
    }

    /**
     * Загрузка библиотек
     *
     * @param string $class
     * @return boolean
     */
    public static function auto_load($class) {
        $file = str_replace('_', '/', strtolower($class));

        if ($path = self::find_file('libs', $file))
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
        
        if( empty($dir) ) {
            $path = $file.$ext;
        } else {
            $path = $dir.DIRECTORY_SEPARATOR.$file.$ext;
        }

        $found = FALSE;

	foreach (self::$_paths as $dir)
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
        return self::$_paths;
    }
}
?>
