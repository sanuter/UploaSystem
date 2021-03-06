<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_Files extends Controller_Main {

    public function  before() {
        parent::before($title = 'UploadSystem: Файлы');
        if( $this->_user->info !== NULL ) {
            $this->_request->response .= View::factory('menu_user')->set( 'name' , $this->_user->info->email );
        } else {
            $this->_request->response .= View::factory('menu_guest');
        }
    }

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
        } else {
           $sort = 'DESC';
        }

        if(Request::get('sort') !== NULL) {
            $order = Request::get('sort');
        } else {
            $order = 'data';
        }

        if(Request::get('page') !== NULL) {
            $page = Request::get('page');
        } else {
            $page = 0;
        }

        if( $files = Model::factory('files')->files_list( $sort, $order, $page ) ){
            $this->_request->response .= View::factory( 'list_files' )
                    ->set( 'files', $files )
                    ->set( 'page', $page );
            $this->_request->response .= View::factory( 'pagination' )
                    ->set( 'all', Model::factory('files')->all())
                    ->set( 'current_page', $page )
                    ->set( 'onpage', UploadSystem::$config['files']['onpage']);
        } else {
            if( $this->_user->info !== NULL ) {
                $this->_request->response .= View::factory( 'files_no' );
            } else {
                $this->_request->response .= View::factory( 'guest_no' );
            }
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
                $this->_request->redirect( Url::root().'list');
            }
            }
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }

    public function action_download() {
        if(Request::get('file') !== NULL) {
            $info = Model::factory('files')->file_info(Request::get('file'));   
            header('Content-type: application/*');
            header('Content-Length: ' . filesize(FILESPATH.md5($info['user']).DIRECTORY_SEPARATOR.$info['name']));
            header('Content-Disposition: attachment; filename="'.$info['name'].'"');
            readfile(Url::root().Files::$default_directory.'/'.md5($info['user']).'/'.$info['name']);
        }
    }

    public function action_delfiles() {
        if( $this->_user->info !== NULL && Request::get('del','post') !== NULL ) {
            Model::factory('files')->files_delete(Request::get('del','post'));
            $this->_request->redirect( Url::root().'list');
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }

    public function action_show() {
        if( $this->_user->info !== NULL && Request::get('file') !== NULL ) {
            Model::factory('files')->file_show(Request::get('file'));
            $this->_request->redirect( Url::root().'list');
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }

    public function action_vid() {
        if( $this->_user->info !== NULL && Request::get('file') !== NULL ) {
            Model::factory('files')->file_visibly(Request::get('file'));
            $this->_request->redirect( Url::root().'list');
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }
}
?>
