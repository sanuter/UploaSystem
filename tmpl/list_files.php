<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div>
    <table width="50%">
        <tr>
            <th colspan="2">№</th>
            <th>
                <a href="<?php echo Url::current().'?sort=name' ?>">Имя файла</a>
                <a href="<?php echo Url::current().'?sort=name&order=DESC' ?>">1</a>
                <a href="<?php echo Url::current().'?sort=name&order=ASC' ?>">1</a>
            </th>
            <th>
                <a href="<?php echo Url::current().'?sort=data' ?>">Дата добавления</a>
                <a href="<?php echo Url::current().'?sort=data&order=DESC' ?>">1</a>
                <a href="<?php echo Url::current().'?sort=data&order=ASC' ?>">1</a>
            </th>
            <th>Ссылка</th>
        </tr>
    <?php if( isset($files) ) {?>
    <?php foreach( $files as $file ) {?>    
        <tr>
            <td><input type="checkbox" /></td>
            <td><?php echo $file['id'] ?></td>
            <td><?php echo $file['name'] ?></td>
            <td><?php echo $file['data'] ?></td>
            <td><a href="<?php echo Url::root().Files::$default_directory.'/'.md5($file['user']).'/'.$file['name'] ?>">Загрузить</a></td>
        </tr>
        <tr>
            <td colspan="5" align="right">
                <?php if(  isset( $comment[$file['id']]) ) { ?>

                <?php } else { ?>
                <a href="<?php echo Url::current().'?comments='.$file['id'] ?>">Просмотр комментариев</a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    <?php } ?>
    </table>
</div>
