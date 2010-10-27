<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_Main extends Controller {    

    public function  __construct($request = NULL) {
        parent::__construct($request);        
    }

    public function before( $title = 'UploadSystem' ) {
        $this->_request->response = View::factory( 'head' )
                ->set( 'title', $title );        
        $this->_request->response .= View::factory('message')
                ->set( 'message', Message::get() );
    }

    public function after() {
        $this->_request->response .= View::factory( 'footer' );
    }
}
?>
