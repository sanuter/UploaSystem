<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class Controller_Comments extends Controller_Main {

    private $_last_parent;
    private $_last_user;
    private $_current_file;
    private $_user_id;

    public function  before() {
        parent::before($title = 'UploadSystem: Комментарии');
        $this->_user_id = (Users::current_user() !== NULL)? Users::current_user() : '1';
        if( $this->_user->info !== NULL ) {
            $this->_request->response .= View::factory('menu_user')->set( 'name' , $this->_user->info->email );
        } else {
            $this->_request->response .= View::factory('menu_guest');
        }
    }

    public function action_index() {
        if(Request::get('file') !== NULL) {
            $this->_current_file = (int) Request::get('file');
        } else {
            $this->_current_file = 0;
        }

        if( $this->_current_file > 0) {
            $comments = Model::factory('comments')->load_comments( $this->_current_file );
            if( !empty($comments)) {
                $html_comment = $this->buid_comments( $html='', $comments );
            } else {
                $html_comment = View::factory('comments_no');
                if($this->_user_id == 1) {
                    $html_comment .= View::factory('comment_add')
                                        ->set( 'parent', '0' )
                                        ->set( 'file', $this->_current_file )
                                        ->set( 'user', $this->_user_id );
                }
            }
            $file_info = Model::factory('files')->file_info( $this->_current_file );
            $this->_request->response .= View::factory( 'comments' )
                ->set( 'comments', $html_comment )
                ->set( 'file', $this->_current_file )
                ->set( 'info', $file_info)
                ->set( 'parent', 0 );
        }
    }

    public function action_addcomment() {

        if( Request::get('file','post') === NULL || Request::get('parent','post',0) === NULL ) {
            Message::add('Ошибка комментария');
            $this->_request->redirect('list');
        }

        if(Request::get('file','post') !== NULL && Request::get('parent','post',0) !== NULL && Request::get('notation','post') !== NULL) {
            Model::factory('comments')->add_comment(
                    Request::get('file','post'),
                    $this->_user_id,
                    Request::get('notation','post'),
                    Request::get('parent','post')
                    );
            $this->_request->redirect( Url::root().'comments/?file='.Request::get('file','post'));
        }
    }    

   private function buid_comments( $html, &$data ) {
   if( empty($data) ) {
       if( $this->_last_user != $this->_user_id) {
            $html .= View::factory('comment_answer')
                ->set( 'parent', $this->_last_parent )
                ->set( 'file', $this->_current_file );
       } else {

       }
       return $html;
   } 

   $html .= "<ul>";
   for( $i = 0; $i<count( $data ); $i++ ) {
        $this->_last_parent = $data[$i]['id'];
        $this->_last_user   = $data[$i]['user_id'];
        $html .= "<li><div>".$data[$i]['user'].' '.$data[$i]['data'].'</div>';
        $html .= "<div>".$data[$i]['comment'].'</div>';        
        $html .= $this->buid_comments( $subhtml = '', $data[$i]['v_tree'] );
        $html .= "</li>";
   }
   return $html .= "</ul>";
   }


}
?>
