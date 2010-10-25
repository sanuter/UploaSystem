<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div> Страницы: 
<?php
if( $all > $onpage) {

   $pages = abs($all%$onpage);

    if( $pages > 1 ) {
        for( $i=1; $i<=$pages; $i++ ) {
            if( $i == 1) {
                if( $page != 0 ) {
                    echo '<span><a href="'.Url::current().'" alt="Страница '.$i.'">'.$i.'</a></span> ';
                } else {
                    echo '<span>'.$i.'</span> ';
                }
            } else {
                 if($page == (($i-1)*$onpage)){
                    echo '<span>'.$i.'</span> ';
                 } else {
                    echo '<span><a href="'.Url::current().'?page='.(($i-1)*$onpage).'" alt="Страница '.$i.'">'.$i.'</a></span> ';
                 }
            }
        }
    }
}
?>
</div>