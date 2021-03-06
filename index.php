<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

/* Полный путь до root директории */
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/*Путь к приложению*/
if ( is_dir(DOCROOT.'app'))
	$app = DOCROOT.'app';
/*Путь к библиотекам ядра*/
if ( is_dir(DOCROOT.'libs'))
	$libs = DOCROOT.'libs';
/*Путь к шаблонам*/
if ( is_dir(DOCROOT.'tmpl'))
	$tmpl = DOCROOT.'tmpl';
/*Путь к файлам пользователей*/
if ( is_dir(DOCROOT.'files'))
	$files = DOCROOT.'files';

define('APPLPATH', realpath($app).DIRECTORY_SEPARATOR);
define('LIBSPATH', realpath($libs).DIRECTORY_SEPARATOR);
define('TMPLPATH', realpath($tmpl).DIRECTORY_SEPARATOR);
define('FILESPATH', realpath($files).DIRECTORY_SEPARATOR);

unset($app,$libs,$tmpl,$files);

require LIBSPATH.'core'.DIRECTORY_SEPARATOR.'core.php';
require LIBSPATH.'uploadsystem.php';

/*Добавление в автозагрузку*/
spl_autoload_register(array('UploadSystem', 'auto_load'));
ini_set('unserialize_callback_func', 'spl_autoload_call');

if( is_dir($install = DOCROOT.'install')) {
   define('INSTALLPATH', realpath($install).DIRECTORY_SEPARATOR);
   return include INSTALLPATH.'install.php';
}

UploadSystem::init();

$routers = array(
    'default' => array(
        'controller' => 'files',
        'action'     => 'index'
    ),
    'list' => array(
        'controller' => 'files',
        'action'     => 'index'
    ),
    'user' => array(
        'controller' => 'user',
        'action'     => 'index'
    ),
    'login' => array(
        'controller' => 'user',
        'action'     => 'login'
    ),
    'logout' => array(
        'controller' => 'user',
        'action'     => 'logout'
    ),
    'delfiles' => array(
        'controller' => 'files',
        'action'     => 'delfiles'
    ),
    'uploadfile' => array(
        'controller' => 'files',
        'action'     => 'upload'
    ),
    'download' => array(
        'controller' => 'files',
        'action'     => 'download'
    ),
    'show' => array(
        'controller' => 'files',
        'action'     => 'show'
    ),
    'vid' => array(
        'controller' => 'files',
        'action'     => 'vid'
    ),
    'comments' => array(
        'controller' => 'comments',
        'action'     => 'index'
    ),
    'addcomments' => array(
        'controller' => 'comments',
        'action'     => 'addcomment'
    ),
);

// Роутеры системы
Router::set($routers);

// Вывод потока
echo Request::factory()->execute()->response;

?>
