<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_Model_Comments extends Model {

    private $_all_tree = array();

    public function load_comments( $id ) {

        $tree = $this->db->query('SELECT
                    t.item_id as id,
                    t.parent_id as parent,
                    u.email as user,
                    u.id as user_id,
                    c.data as data,
                    c.notation as comment
                FROM $__comments as c, $__comments_tree as t, $__users as u
                WHERE
                    c.user_id = u.id
                    AND
                    c.files_id = '.$id.'                    
                    AND
                    c.id = t.item_id                    
                ');

         if( $tree === FALSE ) return $this->_all_tree;

            if( !isset($tree[0]) ){
                 if( empty( $this->_all_tree[$tree['parent']] ))
                            $this->_all_tree[$tree['parent']] = array();
                            $this->_all_tree[$tree['parent']][] = $tree;
            } else {
                foreach( $tree as $item ) {
                    if( empty( $this->_all_tree[$item['parent']] ))
                            $this->_all_tree[$item['parent']] = array();
                    $this->_all_tree[$item['parent']][] = $item;
                }
            }

        return $this->build_list( $this->_all_tree );
    }

    public static function add_comment( $file, $user, $notation, $parent ) {
        $db = Database::instance();
        $result = $db->query( 'INSERT INTO $__comments (`user_id`, `files_id`, `notation` )
            VALUES(
                '.$db->escape($user).',
                '.$db->escape($file).',
                '.$db->escape($notation).'
        );', 2 );

        $db->query( 'INSERT INTO $__comments_tree (`item_id`, `parent_id` )
            VALUES(
                '.$db->escape($result['id']).',
                '.$db->escape($parent).'
        );', 2 );
    }

    private function build_list( &$list, $item=0 ) {
        if( empty($list[$item]) ) return array();
        $tree=array();
        for( $i = 0; $i<count( $list[$item] ); $i++ ) {
            $vt = $list[$item][$i];
            $vt['v_tree'] = $this->build_list( $list, $list[$item][$i]['id'] );
            $tree[] = $vt;
        }
        return $tree;
    }

}
?>
