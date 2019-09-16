<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
$member_id=is_login($link);

if(!$member_id=is_login($link)){
	skip('index.php', 'error', '请登录!');
}




$template['title']='去哪儿';
$template['css']=array('style/public.css','style/theme.css');
?>
<?php include_once 'inc/header.inc.php';?>


<div id="main">
 
	<div class="title">历史搜索记录</div>
		<div style="clear: both; margin-bottom: 20px"></div>
				<div style="width: 678px">
	           <?php
					$query = "SELECT * From searchistory Where user_id={$member_id};";
					$result = execute ( $link, $query );
					while ( $data = mysqli_fetch_assoc ( $result ) ) {
						// var_dump($data);
$html = <<<A
					<tr>
						<td>{$data['searchword']}</td>
					</tr>
A;
					echo $html;
					}
				?>	
</div>


	<div style="clear: both; margin-bottom: 20px"></div>
	<div class="title">推荐结果</div>
		<table class="list">
			<tbody><tr>
				<th>景点名称</th>	 	 	
				<th>描述</th>
				<th>地址</th>
				<th>访问</th>
			</tr>
	           <?php 

//根据搜索的景点关键词推荐景点
	           $query5="SELECT searchword From searchistory Where user_id={$member_id}";
	           $result5 = execute ( $link, $query5 );
	           while ( $data5 = mysqli_fetch_assoc ( $result5 ) ){
	           	$searchword=$data5['searchword'];
	
	           	$query6="select * from scenerypic where title like '%{$searchword}%' ";
	           	$result6 = execute ( $link, $query6 );
	           	while ( $data6 = mysqli_fetch_assoc ( $result6 ) ){
$html=<<<A
							<tr>
								<td>{$data6['Title']}</td>
								<td>{$data6['Desc']}</td>
								<td>{$data6['Addr']}</td>
								<td><a target="_blank" href="show.php?id={$data6['SNO']}">[查看详情]</a></a></td>
							</tr>
A;
	           		echo $html;
	           	}
	           }
	           
//根据搜索的城市推荐同一聚类中的景点
	           $query3="SELECT searchword From searchistory Where user_id={$member_id}";
	           $result3 = execute ( $link, $query3 );
	           while ( $data3 = mysqli_fetch_assoc ( $result3 ) ){
	           		$searchword=$data3['searchword'];
var_dump($data3);
	           		$query4="select cluster from kmeans where city like '%{$searchword}%'";
	           		$result4 = execute ( $link, $query4 );
	           		while ( $data4 = mysqli_fetch_assoc ( $result4 ) ){
	           			$cluster=$data4['cluster'];
	        var_dump($data4);

	           			$query="select city from kmeans where cluster = {$cluster}";
	           			$result=$result = execute ( $link, $query );
	           			while ( $data = mysqli_fetch_assoc ( $result ) ){
	           				$city=$data['city'];


	           				$query2="select * from scenerypic where addr like '%{$city}%' ";
	           				$result2 = execute ( $link, $query2 );
	           				while ( $data2 = mysqli_fetch_assoc ( $result2 ) ){

$html=<<<A
							<tr>
								<td>{$data2['Title']}</td>
								<td>{$data2['Desc']}</td>
								<td>{$data2['Addr']}</td>
								<td><a target="_blank" href="show.php?id={$data2['SNO']}">[查看详情]</a></a></td>
							</tr>
A;
	           					echo $html;
	           				}
	           			}
	           		}       		
	           }
	 	?>	
		</tbody></table>
</div>
<?php include_once 'inc/footer.inc.php';?>