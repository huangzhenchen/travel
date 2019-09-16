<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
$member_id=is_login($link);


if(!isset($_GET['keyword'])){//若搜索词不存在，则设定为空，即把所有内容列出来
	$_GET['keyword']='';
}
$_GET['keyword']=trim($_GET['keyword']);//去除输入的搜索词左右两边的空白字符
$_GET['keyword']=escape($link,$_GET['keyword']);//转义，避免搜索词中出现的词在代码运行过程中出错
$query="select count(*) from scenerypic where title like '%{$_GET['keyword']}%' or Addr like '%{$_GET['keyword']}%'";//计算条件匹配的景点数
$count_all=num($link,$query);//计算条件匹配的景点数


$template['title']='搜索页';
$template['css']=array('style/public.css','style/theme.css');
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
	<div class="title">搜索结果——共有<?php echo $count_all?>条匹配的信息</div>
		<table class="list">
			<tbody><tr>
				<th>景点名称</th>	 	 	
				<th>描述</th>
				<th>地址</th>
				<th>访问</th>
			</tr>
			<?php 
			$query="Select * From scenerypic Where
			scenerypic.title like '%{$_GET['keyword']}%' or
			scenerypic.addr like '%{$_GET['keyword']}%'";
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


<?php 
$query="insert into searchistory(user_id,searchword) values('{$member_id}','{$_GET['keyword']}')";
execute($link, $query);
?>
<?php include 'inc/footer.inc.php'?>