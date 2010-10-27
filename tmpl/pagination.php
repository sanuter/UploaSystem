<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<br/>
<?php

if( $all > $onpage) {

   $pages = ceil($all/$onpage);

    if( $pages > 0 ) {
        echo '<div class="pagination"> Страницы: ';
        for( $i=1; $i<=$pages; $i++ ) {
            if( $i == 1) {
                if( $current_page != 0 ) {
                    echo '<span><a href="'.Url::current().'" alt="Страница '.$i.'">'.$i.'</a></span> ';
                } else {
                    echo '<span>'.$i.'</span> ';
                }
            } else {
                 if($current_page == (($i-1)*$onpage)){
                    echo '<span>'.$i.'</span> ';
                 } else {
                    echo '<span><a href="'.Url::current().'?page='.(($i-1)*$onpage).'" alt="Страница '.$i.'">'.$i.'</a></span> ';
                 }
            }
        }
       echo '</div>';
    }
}
?>