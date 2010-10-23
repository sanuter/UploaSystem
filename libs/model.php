<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Model extends Core_Model {

    protected $db;

    protected function  __construct() {
        $this->db = Database::instance();
    }
}
?>
