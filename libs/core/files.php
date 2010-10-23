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
    public static function save(array $file, $filename = NULL, $directory = NULL, $chmod = 0644)
    {
        if ( ! isset($file['tmp_name']) OR ! is_uploaded_file($file['tmp_name']))
	{
            return FALSE;
	}

        if (self::$remove_spaces === TRUE)
	{
            $filename = preg_replace('/\s+/', '_', $filename);
	}

	if ($directory === NULL)
	{
            $directory = self::$default_directory;
	}

	$filename = realpath($directory).DIRECTORY_SEPARATOR.$filename;

	if (move_uploaded_file($file['tmp_name'], $filename))
	{
            if ($chmod !== FALSE)
            {
                chmod($filename, $chmod);
            }
	}

	return FALSE;
    }
}
?>
