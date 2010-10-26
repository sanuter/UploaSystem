<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div class="login">
    <form action="<?php echo Url::root();?>login" method="post">
        <div>
            <span class="head">Логин: </span>
            <input type="text" name="login" value="" size="20" />
        </div>
        <div>
            <span class="head">Пароль: </span>
            <input type="password" name="pass" value="" size="20" />
        </div>
        <div>
            <input type="submit" value="Войти" />
        </div>
    </form>
</div>
