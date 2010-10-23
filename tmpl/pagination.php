<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div> Страницы: 
<?php
if( $all > 0) {

    $pages = abs($all%$onpage);

    if( $pages > 1 ) {
        for( $i=1; $i<=$pages; $i++ ) {
            if( $i == 1) {
                echo '<span><a href="'.Url::current().'" alt="Страница '.$i.'">'.$i.'</a></span> ';
            } else {
                echo '<span><a href="'.Url::current().'?page='.(($i-1)*$onpage).'" alt="Страница '.$i.'">'.$i.'</a></span> ';
            }
        }
    }
}
?>
</div>