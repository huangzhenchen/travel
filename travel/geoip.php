<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';


$link = connect ();
$member_id = is_login ( $link );

if (! $member_id = is_login ( $link )) {
	skip ( 'index.php', 'error', '请登录!' );
}
$backValue = $_GET;

$template ['title'] = '我在这';
$template ['css'] = array ('style/public.css','style/theme.css' );
?>
<?php include_once 'inc/header.inc.php';?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

<script type="text/javascript"src="http://api.map.baidu.com/api?v=2.0&ak=E4805d16520de693a3fe707cdc962045"></script>
<title>基于位置推荐</title>
</head>
<body>
	<form class="ab" action="geoip.php" method="post">
		<button class="btn">点击此处开始推荐</button>
	</form>
	<div style="width: 90%; height: 480px; border: 1px solid gray; margin: 30px auto"id="allmap"></div>

	<div id="main">
	<?php include_once 'inc/xietong.inc.php';?>	
		<div class="title">根据用户的喜好标签推荐结果</div>
		<table class="list">
			<tbody>
				<tr>
					<th>景点名称</th>
					<th>描述</th>
					<th>地址</th>
					<th>访问</th>
				</tr>
	           <?php
	           //根据IP定位进行推荐
	           if ($backValue) {
	           	$query="select name from user where id={$member_id}";
	           	$result=execute($link, $query);
	           	while ($data = mysqli_fetch_assoc ( $result)){
	           	$query1 = "select interest from userinterest where user_name='{$data['name']}'";
	           	$result1 = execute ( $link, $query1 );
	           	while ( $data1 = mysqli_fetch_assoc ( $result1) ) {
	           		$interest=$data1['interest'];
	           		$interestarry=explode(',', $interest);         
	           		@$query2="select * from scenerytable
	           		where(interest like '{$interestarry['0']}') or
	           		(interest like '{$interestarry['1']}') or
	           		(interest like '{$interestarry['2']}') or
	           		(interest like '{$interestarry['3']}') or
	           		(interest like '{$interestarry['4']}') or
	           		(interest like '{$interestarry['5']}') or
	           		(interest like '{$interestarry['6']}') or
	           		(interest like '{$interestarry['7']}') or
	           		(interest like '{$interestarry['8']}')";
	           			$result2= execute ( $link, $query2);
	           			while ( $data2= mysqli_fetch_assoc ( $result2 ) ){
	           			$query3 = "select * from scenerypic
	           			where SNO={$data2['SNO']} and (addr like '%{$backValue['cityname']}%')";
	           			$result3 = execute ( $link, $query3 );
	           			while ( $data3 = mysqli_fetch_assoc ( $result3 ) ){
$html=<<<A
							<tr>
								<td>{$data3['Title']}</td>
								<td>{$data3['Desc']}</td>
								<td>{$data3['Addr']}</td>
								<td><a target="_blank" href="show.php?id={$data3['SNO']}">[查看详情]</a></a></td>
							</tr>
A;
						echo $html;
	           			}
	           			
	           	}
	           
	           	}
	           	}}
	           	

				?>	           
</tbody>
		</table>
		
		

	
		
	
	
<div class="title">该城市所有景点</div>
		<table class="list">
			<tbody>
				<tr>
					<th>景点名称</th>
					<th>描述</th>
					<th>地址</th>
					<th>访问</th>
				</tr>
				<?php 
				if ($backValue) {
				$query = "select * from scenerypic where addr like '%{$backValue['cityname']}%'";
				$result = execute ( $link, $query );
				while ( $data3 = mysqli_fetch_assoc ( $result) ){
					$html=<<<A
							<tr>
								<td>{$data3['Title']}</td>
								<td>{$data3['Desc']}</td>
								<td>{$data3['Addr']}</td>
								<td><a target="_blank" href="show.php?id={$data3['SNO']}">[查看详情]</a></a></td>
							</tr>
A;
echo $html;
				}}
				?>
				</tbody>
		</table>
		</div>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(116.331398,39.897445);
	map.centerAndZoom(point,12);
	function myFun(result){
		var cityName = result.name;
		map.setCenter(cityName);
		console.log(cityName);
		var name=cityName;
		$(".btn").click(function(){
			$.ajax({
	            url: "http://127.0.0.1/travel/geoip.php",  
	            type: "POST",
	            data:{cityname:name},
	            complete:function()
	            {
	                location.href = "geoip.php?cityname="+name;
	            }
	        })
		})
	}
	var myCity = new BMap.LocalCity();
	myCity.get(myFun);
	console.log(name);
</script>

<?php include_once 'inc/footer.inc.php';?>
