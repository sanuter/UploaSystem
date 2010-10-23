<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
<<<<<<< HEAD
class Controller_Files extends Controller_Main {   
=======
class Controller_Files extends Controller_Main {

    private $_all_tree = array();
    private $_comment_id;
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d

    public function action_index() {
        if( $this->_user->info !== NULL ) {
            $this->_request->response .= View::factory( 'upload_form' );
        }

        if(Request::get('order') !== NULL) {
            if( Request::get('order') === 'DESC' ) {
                $sort = 'ASC';
            } else {
                $sort = 'DESC';
            }
        }

        if(Request::get('sort') !== NULL) {
            $order = Request::get('sort');
        } else {
            $order = 'data';
        }
<<<<<<< HEAD

        if(Request::get('page') !== NULL) {
            $page = Request::get('page');
        } else {
            $page = 0;
        }


        if( Request::get('comments') !== NULL ) {
            $this->_all_tree = Model::factory('files')->load_comments( Request::get('comments') );

            if( !empty( $this->_all_tree ) ) {
                $comments = $this->buid_comments( $comments, $this->_all_tree );
            }
        }  

        if( $files = Model::factory('files')->files_list( $sort, $order, $page ) ){
            $this->_request->response .= View::factory( 'list_files' )
                    ->set( 'files', $files )
                    ->set( 'page', $page );
                    //->set( 'comments', array( $this->_comment_id => $comments ) );
            $this->_request->response .= View::factory('pagination')
                    ->set('all', Model::factory('files')->all())
                    ->set('onpage', '5');
=======
        
        $this->_all_tree = $this->load_comments();
       
        if( !empty( $this->_all_tree ) ) {
            $comments = $this->buid_comments( $comments, $this->_all_tree );            
        }

        $files = Files::files_list( $sort, $order );

        if( $files !== FALSE ){
            $this->_request->response .= View::factory( 'list_files' )
                    ->set( 'files', $files )
                    ->set( 'comments', array( $this->_comment_id => $comments ) );
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
        } else {
            $this->_request->response .= View::factory( 'files_no' );
        }

        if( $this->_user->info !== NULL ) {
            $this->_request->response .= View::factory( 'logout' );
        } else {
            $this->_request->response .= View::factory( 'login_link' );
        }
    }

    public function action_upload() {
        if( $this->_user->info !== NULL ) {
            if(is_array($_FILES['uploadfile'])) {
                $file = $_FILES['uploadfile'];
            if(Files::valid($file)) {
                if($file['error'] === 0) {
                    Files::save($file, $file['name'], $this->_user->info->path );
                    $this->_request->redirect( Url::root().'list');
                }
            } else {
<<<<<<< HEAD
                $this->_request->redirect( Url::root().'list');
=======
                echo 'Error';
                $this->action_index();
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
            }
            }
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }

    public function action_delfiles() {
<<<<<<< HEAD
        if( $this->_user->info !== NULL && Request::get('del','post') !== NULL ) {
            Model::factory('files')->files_delete(Request::get('del','post'));
=======
        if( $this->_user->info !== NULL  && Request::get('del','post') !== NULL ) {
            $files = Request::get('del','post');
            foreach( $files as $file) {
                Files::file_del($file);               
            }
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
            $this->_request->redirect( Url::root().'list');
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }

    public function action_show() {
<<<<<<< HEAD
        if( $this->_user->info !== NULL && Request::get('file') !== NULL ) {
            Model::factory('files')->file_show(Request::get('file'));
=======
        if( $this->_user->info !== NULL  && Request::get('file') !== NULL ) {
            Files::file_show(Request::get('file'));
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
            $this->_request->redirect( Url::root().'list');
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }

    public function action_vid() {
<<<<<<< HEAD
        if( $this->_user->info !== NULL && Request::get('file') !== NULL ) {
            Model::factory('files')->file_visibly(Request::get('file'));
=======
        if( $this->_user->info !== NULL  && Request::get('file') !== NULL ) {
            Files::file_vid(Request::get('file'));
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
            $this->_request->redirect( Url::root().'list');
        } else {
            $this->_request->redirect( Url::root().'login');
        }
<<<<<<< HEAD
    }    
=======
    }

    private function load_comments() {
        if( Request::get('comments','post') !== NULL ) {

            $this->_comment_id = Request::get('comments','post');
            $db = Database::instance();

            $tree = $db->query('SELECT c.id as id, c.parent_id as parent, u.email as user, c.data as data, c.notation as comment
                FROM comments as c, users as u, files as f
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

            return $this->build_list( $this->_all_tree);

        } else {
            return $this->_all_tree;
        }
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
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
}
?>
