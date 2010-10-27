<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>

<div class="files_upload">
    <form action="<?php echo Url::root(); ?>uploadfile" method="post" enctype="multipart/form-data">
        <div>
            <span>Выбирете файл для загрузки:</span>
            <input type="file" name="uploadfile" />
        </div>
        <div>
            <input class="send" type="submit" value="Загрузить" />
        </div>
    </form>
</div>