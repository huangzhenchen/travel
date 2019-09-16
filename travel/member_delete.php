<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id = is_login ( $link );

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('member.php','error','id参数错误！');
}

$query="delete from usercollect where user_id={$_GET['id']} and usercollect={$_GET['SNO']}";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
	skip('index.php','ok','取消收藏成功！');
}else{
	skip('member.php','error','对不起取消收藏失败，请重试！');
}

?>