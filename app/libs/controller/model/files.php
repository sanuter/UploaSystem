<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_Model_Files extends Model {    

    public function files_list( $sort, $order, $start ) {

        $files = Files::files_list( $sort, $order, $start );

        if( !isset($files[0]) ) {
            if( $files === FALSE) {
                return FALSE;
            } else {
                return array( '0' => $files );
            }
        } else {
            return (array)$files;
        }
    }

    public function file_info( $id ) {
        $db    = Database::instance();
        return $db->query('SELECT
                                f.name as name,
                                f.data as data,
                                u.email as user
                           FROM
                                $__files as f,
                                $__files_param as fp,
                                $__users as u
                           WHERE
                                f.id = '.$id.' AND fp.files_id = f.id AND u.id = fp.users_id'
                          );
    }

    public function files_delete( $files ) {
        if( is_array($files) ){
            foreach( $files as $file ) {
                Files::file_del($file);
            }
        } 
    }
    
    public function file_show( $id ) {
        return Files::file_show($id);
    }

    public function file_visibly( $id ) {
        return Files::file_vid($id);
    }

    public function all() {
        $result = Files::files_all_list();
        return (int)$result['items'];
    }    
}
?>
