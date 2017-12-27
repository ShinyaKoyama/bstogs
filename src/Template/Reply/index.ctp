<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p><?php if(is_array($result)) { ?>
                <div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none') ? 'block' : 'none';">
                    <a style="cursor:pointer;">▼ BBCtoPicker 受信記録</a>
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
    </body>
</html>