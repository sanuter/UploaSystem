<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<br/>
<div>
    <form action="<?php echo Url::root().'delfiles' ?>" method="post">
    <table class="files_list" cellspacing="1" cellpadding="1">
        <tr>
            <th>№</th>
            <th>
                <a class="title" href="<?php echo Url::current().'?sort=name' ?>">Имя файла</a>
                <a class="desc" href="<?php echo Url::current().'?sort=name&order=DESC' ?>" title="По убыванию"></a>
                <a class="asc" href="<?php echo Url::current().'?sort=name&order=ASC' ?>" title="По возростанию"></a>
            </th>
            <th>
                <a class="title" href="<?php echo Url::current().'?sort=data' ?>">Дата добавления</a>
                <a class="desc" href="<?php echo Url::current().'?sort=data&order=DESC' ?>" title="По убыванию"></a>
                <a class="asc" href="<?php echo Url::current().'?sort=data&order=ASC' ?>" title="По возростанию"></a>
            </th>
            <th>Ссылка для загрузки</th>
            <?php if( Users::instance()->info->id !== NULL ) { ?>
            <th>Доступ к комментариям</th>
            <th>Доступ к файлу</th>            
            <?php } ?>
            <th>Просмотреть комментарии</th>
        </tr>
    <?php if( $files !== FALSE ) {?>
   <?php $num = ($page !== 0)? $page+1 : 1; ?>
    <?php foreach( $files as $file ) {?>    
        <tr>
            <td>
                <?php if( Users::instance()->info->id !== NULL ) { ?>
                <input type="checkbox" name="del[]" value="<?php echo $file['id'] ?>" />
                <?php } ?>
                <?php echo $num ?>.
            </td>
            <td><?php echo $file['name'] ?></td>
            <td><?php echo $file['data'] ?></td>
            <td><a class="download" href="<?php echo Url::root().'download/?file='.$file['id'] ?>" title="Загрузить"></a></td>
            <?php if( Users::instance()->info->id !== NULL ) { ?>
            <?php if ($file['comment'] == 1 ) { ?>
            <td><a class="comment_no" href="<?php echo Url::root().'show/?file='.$file['id'] ?>" title="Скрыть комментарии"></a></td>
            <?php } else { ?>
            <td><a class="commnet_yes" href="<?php echo Url::root().'show/?file='.$file['id'] ?>" title="Показать комментарии"></a></td>
            <?php } ?>
            <?php if ($file['vid'] == 1 ) { ?>
            <td><a class="file_hidden" href="<?php echo Url::root().'vid/?file='.$file['id'] ?>" title="Скрыть файл"></a></td>
            <?php } else { ?>
            <td><a class="file_visibly" href="<?php echo Url::root().'vid/?file='.$file['id'] ?>" title="Показать файл"></a></td>
            <?php } ?>
            <?php } ?>
            <?php if (Users::current_user() !== NULL || $file['comment'] == 1) { ?>
            <td><a class="commnet" href="<?php echo Url::root().'comments/?file='.$file['id'] ?>" title="Комментарии"></a></td>
            <?php } ?>
        </tr>        
    <?php $num++; ?>
    <?php } ?>
    <?php } ?>
    </table>
    <br/>
    <?php if( Users::instance()->info->id !== NULL ) { ?>
        <input class="send" type="submit" value="Удалить" />
    <?php } ?>
    </form>
</div>