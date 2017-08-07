<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
            <p><?php if(is_array($result)) { ?>
                    <div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none') ? 'block' : 'none';">
                        <a style="cursor:pointer;">▼ 投稿内容の詳細確認</a>
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
            <h2>投稿記事のタイトル</h2>
            <?php echo $this->Form->text('WpConnectionForm.title'); ?>
            <h2>投稿記事の内容</h2>
            <?php echo $this->Form->textarea('WpConnectionForm.content'); ?>
            <h2>記事の公開</h2>
            <?php
                $options = array('publish' => '公開', 'private' => '非公開');
                $attibutes = array('legend' => false);
                echo $this->Form->radio('WpConnectionForm.status', $options, $attibutes);
            ?>
            <?php echo $this->Form->submit('送信'); ?>
        <?php echo $this->Form->end(); ?>
        <br><br><br>
    </body>
</html>