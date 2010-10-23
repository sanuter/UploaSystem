<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Model {
    
    public static function factory( $name ) {
        $class = 'Controller_Model_'.ucfirst($name);
        return new $class();
    }
}
?>
