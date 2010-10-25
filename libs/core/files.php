<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class Core_Files {

    /**
    * @var  boolean  Убирать ли пробелы в именах файлов
    */
    public static $remove_spaces = TRUE;

    /**
    * @var  string  директория хранения файлов по умолчанию
    */
    public static $default_directory = 'files';    

    /**
     * Проверка данных о файле
     *
     * @param array $_FILES
     * @return boolean
     */
    public static function valid($file)
    {
        return (isset($file['error'])
                AND isset($file['name'])
		AND isset($file['type'])
		AND isset($file['tmp_name'])
		AND isset($file['size']));
    }    

    /**
     * Сохрание файлов 
     * 
     * @param array $_FILES
     * @param string имя файла
     * @param string директория
     * @param intrger chmod маска
     * @return false  при ошибке
     */
    public static function save(array $file, $filename = NULL, $directory = NULL, $chmod = 0644) {
        
    }

    /**
     * Чтение файла в память 
     * 
     * @param string путь к файлу
     * @return string 
     */
    public static function read( $filename ) {

		$file = fopen($filename, 'r');
		$block_size = 1024 * 8;
                $memfile = null;

		while ( ! feof($file)) {
                    $memfile .= fread($file, $block_size);
		}

		fclose($file);
		return $memfile;
	}
}
?>
