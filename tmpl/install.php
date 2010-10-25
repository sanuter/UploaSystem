<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<form action="<?php Url::current()?>" method="post">
<div>
    Настройки системы
    <div>
        <legend>Настройки базы</legend>
        <div>
            <?php foreach($config['base'] as $name=>$value) { ?>
            <legend><?php echo ucfirst($name) ?>: </legend><input type="text" name="<?php echo $name ?>" value="<?php echo $value ?>"/>
            <?php } ?>
        </div>
    </div>
    <div>
        <legend>Директория системы: </legend><input type="text" name="base_url" value="<?php echo $config['base_url'] ?>"/>
    </div>   
</div>
    <input type="hidden" name="check" value="1" />
    <input type="submit" value="Сохранить" />
</form>