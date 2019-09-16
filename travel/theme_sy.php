<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

$template['title']='山岳';
$template['css']=array('style/public.css','style/theme.css');
?>

<?php include_once 'inc/header.inc.php';?>
<?php include_once 'inc/theme.inc.php';?>
<div id="main">
	<div class="title">山岳</div>
		<table class="list">
			<tbody><tr>
				<th>景点名称</th>	 	 	
				<th>描述</th>
				<th>地址</th>
				<th>访问</th>
			</tr>

			<?php
			$query="Select *From scenerypic Where sno IN (SELECT sno From scenerytable Where tno=17);";
			$result=execute($link, $query);
			while ($data=mysqli_fetch_assoc($result)){
				//var_dump($data);exit();
$html=<<<A
			<tr>
				<td>{$data['Title']}</td>
				<td>{$data['Desc']}</td>
				<td>{$data['Addr']}</td>
				<td><a target="_blank" href="show.php?id={$data['SNO']}">[查看详情]</a></a></td>
			</tr>
A;
			echo $html;
			} 
			?>
		</tbody></table>
</div>
<?php include_once 'inc/footer.inc.php';?>