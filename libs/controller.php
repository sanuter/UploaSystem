<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
abstract class Controller extends Core_Controller {
    
    protected $_request;
    protected $_user;
    protected $_session;

    public function  __construct($request = NULL) {
        parent::__construct($request);
        $this->_user = Users::instance();
        $this->_session = Session::instance();
    }

}
?>
