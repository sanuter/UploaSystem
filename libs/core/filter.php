<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Core_Filter {

    public static function xss_filter( $value ) {
        $value = htmlentities($value, ENT_QUOTES);

        if(get_magic_quotes_gpc ()) {
            $value = stripslashes ($value);
        }

        $value = strip_tags($value);
        $value=str_replace ("\n"," ", $value);
        $value=str_replace ("\r","", $value);

        return $value;
    }
}
?>
