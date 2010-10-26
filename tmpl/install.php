<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo Files::media('install.css') ?>" />
<form action="<?php Url::current()?>" method="post">
<div class="install_body">
    <div class="install_head">Настройки системы</div>
        <legend>Настройки базы</legend>
        <div class="install_body">
            <?php foreach($config['base'] as $name=>$value) { ?>
            <div class="install_input">
                <span><?php echo ucfirst($name) ?>: </span><input type="text" name="<?php echo $name ?>" value="<?php echo $value ?>"/>
            </div>
            <?php } ?>
        </div>
    <div class="install_input">
        <legend>Директория системы: </legend><input type="text" name="base_url" value="<?php echo $config['base_url'] ?>"/>
    </div>   
</div>
    <input type="hidden" name="check" value="1" />
    <input type="submit" value="Сохранить" />
</form>