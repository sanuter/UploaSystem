<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

$config = include INSTALLPATH.DIRECTORY_SEPARATOR.'config.php';
UploadSystem::$config = $config;
UploadSystem::$base_url = $config['base_url'];

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

    $step = array(
        'connect' => 0,
        'base'    => 0,
        'config'  => 0
    );
    
    $sql = Files::read(INSTALLPATH.DIRECTORY_SEPARATOR.'bases.sql');
    $sql = str_replace('$__', $config['base']['prefix'], $sql);

    $db = Database::instance($config['base']);
    if($db->test()) {
        $step['connect'] = 1;
        $prev_sql = 0;
        while($next_sql = strpos($sql,";",$prev_sql+1)) {
            if(is_array($db->query(substr($sql,$prev_sql+1,$next_sql-$prev_sql),2))) {
                $step['base'] = 1;
            } else {
                $step['base'] = 0;
            }
            $prev_sql = $next_sql;
        }      
    }

    $conf = fopen(DOCROOT.'config.php','w');
    if(fwrite($conf,'<?php return '.var_export($config, TRUE).' ?>')) {
        $step['config'] = 1;
    }
    fclose($conf);

    echo View::factory('install_result')
            ->set( 'step', $step );

}
?>