<?php
$cur = dirname(__FILE__) . '/';
if($_POST['delete']) del_file( $cur );
function del_file($dir)
{
    $hand = opendir($dir);
    while($f = readdir($hand))
    {
        if($f=='.'||$f=='..') continue;
        if(is_dir($dir.$f))
        {
            echo '进入目录：'.$dir.$f.'<br>';  
            del_file($dir.$f .'/');
        }
        else
        {
            echo $dir . $f .'<br>';
            @unlink($dir . $f );
            echo $dir . $f .' -- <br>';
        }
    }
    rmdir($dir);
    echo $dir .' --<br>'; 
}
?>
<form method="post"><input type="submit" name="delete" value="del" /></form>