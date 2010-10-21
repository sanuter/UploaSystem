<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class Controller_Files extends Controller_Main {

    public function action_index() {
        if( $this->_user->info !== NULL ) {
            $this->_request->response .= View::factory( 'upload_form' );
        }
        $this->_request->response .= View::factory( 'list_files' )->set( 'files', Files::files_list() );
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
                echo 'Error';
                $this->action_index();
            }
            }
        } else {
            $this->_request->redirect( Url::root().'login');
        }
    }
}
?>
