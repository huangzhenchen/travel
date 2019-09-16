<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
$member_id=is_login($link);

$query="select * from scenerypic where SNO={$_GET['id']}";
$result=execute($link, $query);
$data=mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
	if (! $member_id = is_login ( $link )) {
		skip ( 'index.php', 'error', '请登录!' );
	}
	$query="select * from usercollect where user_id={$member_id} and usercollect={$data['SNO']}";
	$result=execute($link, $query);
	if(mysqli_fetch_assoc($result)){
		$query="update usercollect set collect_time=now() where user_id={$member_id} and usercollect={$data['SNO']}";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1){
			echo "<script>alert('已更新收藏时间！');</script>";
		}
		else{
			echo "<script>alert('请不要重复收藏！');</script>";}}
	else{
	$query="insert into usercollect(user_id,usercollect,collect_time) values($member_id,{$data['SNO']},now())";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		echo "<script>alert('收藏成功！');</script>";
	}else{
		echo "<script>alert('收藏失败，请重试！');</script>";
	}
}}

if(isset($_POST['submit2'])){//评价成功或失败提示存在userpoint表中
	if (! $member_id = is_login ( $link )) {
		skip ( 'index.php', 'error', '请登录!' );
	}
	$query="insert into userpoint(user_id,SNO,point) values($member_id,{$data['SNO']},{$_POST['point']})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		echo "<script>alert('评价成功！');</script>";
	}else{
		echo "<script>alert('评价失败，请重试！');</script>";
	}
}

if(isset($_POST['submit2'])){//评分存在或更新城市评分表中
	if (! $member_id = is_login ( $link )) {
		skip ( 'index.php', 'error', '请登录!' );
	}
	$query="select * from scenerypic where SNO={$data['SNO']}";
	$result=execute($link, $query);
	$data1=mysqli_fetch_assoc($result);
	$query="select *from cityname where cityname='{$data1['cityname']}'";//cityname表中记录了城市评分矩阵在哪张表中（test3-杭州市）
	$result=execute($link, $query);
	$biaoming=mysqli_fetch_assoc($result);
	//var_dump($biaoming['biaoming']);
	
	$query="select * from {$biaoming['biaoming']} where user_id=$member_id";
	$result=execute($link, $query);
	if(mysqli_num_rows($result)==1){
		$query2="select * from try where SNO={$data['SNO']}";//try表景点编号转为代号1A
		$result2=execute($link, $query2);
		while ($data2= mysqli_fetch_assoc ( $result2 )){		
			$query1="update {$biaoming['biaoming']} set {$data2['try']}={$_POST['point']} where user_id=$member_id";//$data2['try']景点代号
			execute($link, $query1);
		}
	}else{
			$query4="select * from user where id=$member_id";
			$result4=execute($link, $query4);
			while($data4=mysqli_fetch_assoc($result4)){
				$query2="select * from try where SNO={$data['SNO']}";
				$result2=execute($link, $query2);
				while ($data2= mysqli_fetch_assoc ( $result2 )){
					$query3="insert into {$biaoming['biaoming']}(user_id,name,{$data2['try']} ) values ('{$member_id}','{$data4['name']}','{$_POST['point']}')";
					execute($link, $query3);
				}
			}
	}	
}



$template['title']='景点详情';
$template['css']=array('style/public.css','style/show.css' );
?>

<?php include_once 'inc/header.inc.php';?>
<div id="main" class="auto" >
	<div id="left">
		<div id="scenery_pic" style="text-align:center">
			<img src="<?php echo $data['pic']?>" />
			<div style="clear: both;"></div>
		</div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<div style="width: 100%; height: 40px; line-height: 30px; text-indent: 10px; background: #e6e6e6; color: #666; font-size:30px;font-weight: bold;">
			详细内容</div>
		<div style="clear: both; margin-bottom: 20px"></div>
	</div>
	<div style="clear: both; margin-bottom: 20px"></div>
	<div style="">
		<div style="margin-left:100px;width:200px;">
			<form method="post" style="width:200px;">
				<input class="btn" style="background-color: #ff9933;border: none;color: white; padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 20px;margin: 4px 2px;
			    cursor: pointer;" name="submit"  type="submit"  value="收藏" />	
			</form>
		</div>
		<div style="margin-left:100px;">
		    <form method="post" style="">
		 		<select style="width:236px;height:25px;" name="point">
					<option value="1">1分</option>
					<option value="2">2分</option>
					<option value="3">3分</option>
					<option value="4">4分</option>
					<option value="5">5分</option>
					<option value="6">6分</option>
					<option value="7">7分</option>
					<option value="8">8分</option>
					<option value="9">9分</option>
					<option value="10">10分</option>		
				</select>
				<input class="btn"  name="submit2"  type="submit"  value="提交评价" />	
		 	 </form>
	 	 </div>
 	 </div>
	<div style="clear: both; margin-bottom: 20px"></div>
	<div id="right">
		<div style="margin-left:100px;font-size:20px"> 景点名称：<?php echo $data['Title']?></div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<div style="margin-left:100px;font-size:20px"> 景点简述：<?php echo $data['Desc']?></div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<div style="margin-left:100px;font-size:20px"> 景点地址：<?php echo $data['Addr']?></div>
		<div style="clear: both;"></div>
	</div>
	</div>
	<div style="clear: both;"></div>




<?php include_once 'inc/footer.inc.php';?>