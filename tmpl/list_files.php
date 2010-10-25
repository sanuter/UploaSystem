<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div>
    <form action="<?php echo Url::root().'delfiles' ?>" method="post">
    <table width="70%">
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
    <?php if( $files !== FALSE ) {?>
   <?php $num = ($page !== 0)? $page+1 : 1; ?>
    <?php foreach( $files as $file ) {?>    
        <tr>
            <td>
                <?php if( Users::instance()->info->id !== NULL ) { ?>
                <input type="checkbox" name="del[]" value="<?php echo $file['id'] ?>" /
                <?php } ?>
            </td>
            <td><?php echo $num ?>.</td>
            <td><?php echo $file['name'] ?></td>
            <td><?php echo $file['data'] ?></td>
            <td><a href="<?php echo Url::root().Files::$default_directory.'/'.md5($file['user']).'/'.$file['name'] ?>">Загрузить</a></td>
            <?php if( Users::instance()->info->id !== NULL ) { ?>
            <?php if ($file['comment'] == 1 ) { ?>
            <td><a href="<?php echo Url::root().'show/?file='.$file['id'] ?>">Скрыть комментарии</a></td>           
            <?php } else { ?>
            <td><a href="<?php echo Url::root().'show/?file='.$file['id'] ?>">Показать комментарии</a></td>           
            <?php } ?>
            <?php if ($file['vid'] == 1 ) { ?>
            <td><a href="<?php echo Url::root().'vid/?file='.$file['id'] ?>">Скрыть файл</a></td>
            <?php } else { ?>
            <td><a href="<?php echo Url::root().'vid/?file='.$file['id'] ?>">Показать файл</a></td>
            <?php } ?>
            <?php } ?>
            <?php if (Users::current_user() !== NULL || $file['comment'] == 1) { ?>
            <td><a href="<?php echo Url::root().'comments/?file='.$file['id'] ?>">Комментарии</a></td>
            <?php } ?>
        </tr>        
    <?php $num++; ?>
    <?php } ?>
    <?php } ?>
    </table>
    <?php if( Users::instance()->info->id !== NULL ) { ?>
        <input type="submit" value="Удалить" />
    <?php } ?>
    </form>
</div>