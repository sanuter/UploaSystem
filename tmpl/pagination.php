<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div>
<?php
if( $all > 0) {

    echo $all.'---'.$onpage;
    $pages = $all%$onpage;
    exit();
    for( $i=0; $i<=$pages; $i) {
        echo '<span><a hreaf="'.Url::current().'?page='.$i.'" alt="Страница '.$i.'">'.$i.'</a></span>';
    }
}
?>
</div>