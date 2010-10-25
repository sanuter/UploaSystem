<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<script type="text/javascript" src="<?php echo Files::media('login.js') ?>"></script>
<div>
    <form action="<?php echo Url::root();?>login" method="post">
        <div>
            <legend>Логин: </legend>
            <input type="text" name="login" value="" size="20" />
        </div>
        <div>
            <legend>Пароль: </legend>
            <input type="password" name="pass" value="" size="20" />
        </div>
        <div>
            <input type="submit" value="Войти" />
        </div>
    </form>
</div>
