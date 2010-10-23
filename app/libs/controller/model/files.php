<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_Model_Files extends Model {

    private $_all_tree = array();

    public function files_list( $sort, $order, $start ) {

        $files = Files::files_list( $sort, $order, $start );

        if( count($files) == 1 ) {
            return array( '0' => $files );
        } else {
            return (array)$files;
        }
    }
    
    public function file_show( $id ) {
        return Files::file_show($id);
    }

    public function file_visibly( $id ) {
        return Files::file_vid($id);
    }

    public function load_comments( $id ) {

        $tree = $this->db->query('SELECT
                    c.id as id,
                    c.parent_id as parent,
                    u.email as user,
                    c.data as data,
                    c.notation as comment
                FROM comments as c, comments_tree, users as u, files as f
                WHERE
                    c.user_id = u.id
                    AND
                    c.files_id = '.$this->_comment_id.'
                    AND
                    f.id = c.files_id
                    AND
                    f.comment = 1
                ');

         if( $tree === FALSE ) return $this->_all_tree;

            foreach( $tree as $item ) {
                if( empty( $this->_all_tree[$item['parent']] ))
                        $this->_all_tree[$item['parent']] = array();
                $this->_all_tree[$item['parent']][] = $item;
            }

        return $this->build_list( $this->_all_tree );
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

    private function buid_comments( $html, &$data ) {
      if( empty($data) ) return $html;
      $html .= "<ul>";
      for( $i = 0; $i<count( $data ); $i++ ) {
        $html .= "<li><div>".$data[$i]['user'].' '.$data[$i]['data'].'</div>';
        $html .= "<div>".$data[$i]['comment'].'</div>';
        $html .= $this->buid_comments( $subhtml = '', $data[$i]['v_tree'] );
        $html .= "</li>";
      }
      return $html .= "</ul>";
    }
}
?>
