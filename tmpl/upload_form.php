<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>

<div>
    <form action="<?php echo Url::root(); ?>uploadfile" method="post" enctype="multipart/form-data">
        <div>
            <legend>Выбирете файл для загрузки:</legend>
            <input type="file" name="uploadfile" />
        </div>
        <div>
            <input type="submit" value="Загрузить" />
        </div>
    </form>
</div>