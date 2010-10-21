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

    public function before() {
        $this->_request->response = View::factory( 'head' );
    }

    public function after() {
        $this->_request->response .= View::factory( 'footer' );
    }
}
?>
