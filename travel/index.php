<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

$template['title']='首页';
$template['css']=array('style/public.css','style/index.css');
?>

<?php include_once 'inc/header.inc.php';?>
		<div style="margin-top:55px;"></div>
		<div id="slider" class="scroll-container">
			<li><img src="img/banner.jpg"></li>
			<li><img src="img/banner_1.jpg"></li>
			<li><img src="img/banner_2.jpg"></li>
			<li><img src="img/banner_3.jpg"></li>
			<li><img src="img/banner_4.jpg"></li>
		</div>
		<div id="instruction" class="instruction">1</div>

		<div style="margin-top:20px;"></div>


<?php include_once 'inc/footer.inc.php';?>
