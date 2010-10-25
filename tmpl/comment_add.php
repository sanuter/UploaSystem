<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div>
<form action="<?php echo Url::root().'addcomments/' ?>" method="post">
    <div>
    <textarea cols="30" rows="2" name="notation"></textarea>
    </div>
    <input type="hidden" name="file" value="<?php echo $file ?>" />
    <input type="hidden" name="parent" value="<?php echo $parent ?>" />
    <div>
        <input type="submit" value="Добавить" />
    </div>
</form>
</div>
