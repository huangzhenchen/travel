<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title'] ?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />

<?php 
foreach ($template['css'] as $val){
	echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
}
?>

		<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
		<script src="js/index.js"></script>
</head>
<body>
<div class="header_wrap">
	<div id="header" class="auto">
		<div class="logo">旅游推荐系统</div>
			<ul class="nav">
				<li><a href="index.php" target="_blank">首页</a></li>
				<li><a href="theme.php" target="_blank">主题精选</a></li>
				<li><a href="recommend.php" target="_blank">去哪儿</a></li>
				<li><a href="geoip.php" target="_blank">我在这</a></li>
			</ul>
		<div class="serarch">
			<form action="search.php" method="get" >
				<input class="keyword" type="text" name="keyword" placeholder="搜索城市或景点" />
				<input class="submit" type="submit"  value="" />
			</form>
		</div>
		<div class="login">
			<?php 
				if(isset($member_id) && $member_id){
$str=<<<A
					<a href="member.php?id={$member_id}" target="_blank">您好！{$_COOKIE['user']['name']}</a> <span style="color:#fff;">|</span> <a href="logout.php">退出</a>
A;
					echo $str;		
				}else{
$str=<<<A
					<a href="login.php">登录</a>&nbsp;
					<a href="register.php">注册</a>
A;
					echo $str;
				}
				?>
		</div>
	</div>
</div>
<div style="margin-top:55px;"></div>