<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

$template['title']='主题精选';
$template['css']=array('style/public.css','style/theme.css');
?>

<?php include_once 'inc/header.inc.php';?>
<?php include_once 'inc/theme.inc.php';?>
<?php include_once 'inc/footer.inc.php';?>
