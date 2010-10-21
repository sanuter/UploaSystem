<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

abstract class Core_Controller {   

    public function __construct( $request = NULL )
    {
        $this->_request = $request;
    }
}
?>
