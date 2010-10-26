<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

$message = array(
    'connect'  => 'Соединение с базой данных',
    'base'     => 'Создание таблиц',
    'config'   => 'Создание конфигурации'
);

?>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo Files::media('install.css') ?>" />
<div class="install_head">
    Рузультат выполнения устаноки.
</div>
<div class="install_body">
    <?php
    foreach( $step as $key=>$item ){
        if($item) {
            echo '<div class="install_success"> '.$message[$key].' - Выполнено. </div>';
        } else {
            echo '<div class="install_failed"> '.$message[$key].' - Ошибка. </div>';
        }
    }
    ?>
</div>
<div class="install_message">
    Для дальнейщей работы удалите или переименуйте каталог install.
</div>
