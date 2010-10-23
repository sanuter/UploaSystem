<?php
/**
 * @author Aliaksandr Treitsiak
 * @copyright  Copyright (C) 2004 - 2010. Home Company
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<div>
<<<<<<< HEAD
    <form action="<?php echo Url::root().'delfiles' ?>" method="post">
=======
    <form action="<?php echo Url::current().'delfiles' ?>" method="post">
>>>>>>> 1687d027e0db9f97a36ac0b82c79290a574b2a8d
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
   <?php $num = 1; ?>
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
        </tr>
        <tr>
            <td colspan="6">
                <?php if( $file['comment'] == 1 ) { ?>
                <div>
                <?php if(  isset( $comments[$file['id']] ) ) {
                            if( $comments[$file['id']] === NULL ) {
                                ?>
                                    <form action="<?php echo Url::root() ?>" method="post">
                                        <legend>Добавить комментарий</legend>
                                        <input type="textarea" name="addcomment" cols="40" rows="3" />
                                        <input type="submit" value="Добавить комментарий" />
                                    </form>
                                <?php
                            } else {
                                echo $comments[$file['id']]; ?>
                                <form action="<?php echo Url::root() ?>" method="post">
                                        <legend>Добавить комментарий</legend><br/>
                                        <textarea name="addcomment" cols="40" rows="3"></textarea>
                                        <input type="hidden" name="comments" value="<?php echo $file['id'] ?>" />
                                        <input type="submit" value="Добавить комментарий" />
                                </form>
                                <?php
                            }
                      } else { ?>
                <form action="<?php echo Url::root() ?>" method="post">
                <input type="hidden" name="comments" value="<?php echo $file['id'] ?>" />
                <input type="submit" value="Просмотр комментариев" />
                </form>    
                <?php } ?>
                </div>
                <?php }  ?>
            </td>
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