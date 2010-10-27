<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div class="file_comment">
<form action="<?php echo Url::root().'addcomments/' ?>" method="post">
    <div>
        <textarea  class="comment" cols="30" rows="2" name="notation"></textarea>
    </div>
    <input type="hidden" name="file" value="<?php echo $file ?>" />
    <input type="hidden" name="parent" value="<?php echo $parent ?>" />  
    <div>
        <input class="send" type="submit" value="Ответить" />
    </div>
</form>
</div>
