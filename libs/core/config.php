<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Config {

    // Instance
    protected static $instance;

    final private function  __clone() {
        
    }

    /**
     * Конфигурация instance
     *
     * @return Config
     */
    public static function instance() {
        if (self::$instance === NULL)
	{
		self::$instance = new self;
	}
	return self::$instance;
    }

    /**
     * Загрузка конфигурации
     *
     * @param string Путь к файлу
     * @return array Конфигурация
     */
    public function load( $file ) {
        if($config = UploadSystem::find_file('', $file)) {
            return self::$instance = require $config;
        }
        return self::$instance;
    }
}
?>
