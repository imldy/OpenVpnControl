<?php
$file = "../../FAS.lock";

if(file_exists($file))
{
    require ("error.php");
	return;
}
else
{
    echo "";
}
?>
<?php
/*
	检测程序是否已经安装
*/
header("location:admin.php");

