<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
            <p><?php if(is_array($result)) { ?>
                    <div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none') ? 'block' : 'none';">
                        <a style="cursor:pointer;">▼ BBCtoPickerの通知内容の確認</a>
                        <div id="open" style="display:none; clear:both;">
                            <?php echo "<pre>"; print_r($result); echo "</pre>"; ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div>
                        <?php echo $result; ?>
                    </div>
                <?php } ?>
            </p>
        
        <?php echo $this->Form->create(false, array('type' => 'post', 'url' => '/WpConnection')); ?>
            <h2>送信するユーザ</h2>
            <?php echo $this->Form->text('WpConnectionForm.title'); ?>
            <?php
                echo $this->Form->input(
                    'field',
                    array(
                        'options' => array(1, 2, 3, 4, 5),
                        'empty'   => '(Choose one)'
                    )
                );
            ?>
            <h2>Pushする内容</h2>
            <?php echo $this->Form->textarea('WpConnectionForm.content'); ?>
            <?php echo $this->Form->submit('送信'); ?>
        <?php echo $this->Form->end(); ?>
        <br><br><br>
    </body>
</html>