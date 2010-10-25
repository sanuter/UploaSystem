<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_User extends Controller_Main {

    public function action_login() {        
        if( $this->_user->info === NULL ) {
            if($this->_user->login( Request::get( 'login', 'post' ), Request::get( 'pass', 'post' ) )) { 
                $this->_request->redirect( Url::root().'list');
            } else {
                $this->_request->response .= View::factory( 'login' );
            }
        } else {            
            $this->_request->redirect( Url::root().'list');
        }
    }

    public function action_logout() {       
        $this->_user->logout();
        $this->_request->redirect( Url::root().'list');
    }
}
?>
