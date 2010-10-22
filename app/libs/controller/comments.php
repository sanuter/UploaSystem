<?php

/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

class Controller_Comments extends Controller {

    public function action_comments( $data = NULL ) {
        if( $data !== NULL) {
            $this->_request->response .= View::factory( 'comments' )
                    ->set( 'comments', $this->buid_comments( $comments , $data ) );
        }
    }

    private function buid_comments( $html, &$data ) {
      if(empty($$data)) return;
      $html .= "<ul>";
      for( $i=0; $i<count($data); $i++ ) {
        $html .= "<li>".$data[$i]['user'];
            $this->buid_comments( $data[$i]['v_tree'] );
        $html .= "</li>";
      }
      $html .= "</ul>";
    }
}
?>
