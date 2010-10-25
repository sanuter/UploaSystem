<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

$config = include INSTALLPATH.DIRECTORY_SEPARATOR.'config.php';;

if( Request::get('check','post') === NULL ) {
    echo View::factory('install')
            ->set( 'config', $config );
} else {

    foreach( $config['base'] as $key=>$value ) {
        if( Request::get($key,'post') !== NULL ) {
            $config['base'][$key] = Request::get($key,'post');
        }
    }

    if( Request::get('base_url','post') !== NULL ) {
        $config['base_url'] = Request::get('base_url','post');
    }

    $sql = Files::read(INSTALLPATH.DIRECTORY_SEPARATOR.'bases.sql');
    $sql = str_replace('$_', $config['base']['prefix'], $sql);

    var_dump($sql);

    $db = Database::instance($config);
    $db->query($sql);


}
?>