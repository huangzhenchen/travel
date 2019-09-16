<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connect ();
$member_id = is_login ( $link );
if(!$member_id=is_login($link)){
	skip('index.php', 'error', '请登录!');
}

if (! isset ( $_GET ['id'] ) || ! is_numeric ( $_GET ['id'] )) {
	skip ( 'index.php', 'error', '会员id参数不合法!' );
}
$query = "select * from user where id={$_GET['id']}";
$result = execute ( $link, $query );
if (mysqli_num_rows ( $result ) != 1) {
	skip ( 'index.php', 'error', '你所访问的会员不存在!' );
}

$data = mysqli_fetch_assoc ( $result );
$query = "select count(*) from user where id={$_GET['id']}";
$count_all = num ( $link, $query );

$template ['title'] = '会员中心';
$template ['css'] = array (
		'style/public.css',
		'style/list.css',
		'style/member.css' 
);
?>
<?php include_once 'inc/header.inc.php';?>
<div id="position" class="auto" style="margin-left: 200px">
	<a href="index.php">首页</a> &gt; <?php echo $data['name']?>
	</div>
<div id="main" class="auto" style="margin-left: 200px">
	<div id="left">
		<div
			style="width: 100%; height: 30px; line-height: 30px; text-indent: 10px; background: #e6e6e6; color: #666; font-weight: bold;">
			我喜欢的景点标签</div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<ul >
			<li>
				<div >
					<?php
					$query="select name from user where id={$member_id}";
					$result=execute($link, $query);
					while ($data = mysqli_fetch_assoc ( $result)){
						$query= "select interest from userinterest where user_name='{$data['name']}'";
						$result = execute ( $link, $query );
					while ( $data = mysqli_fetch_assoc ( $result) ) {
						// var_dump($data);exit();
$html = <<<A
					<tr>
						<td>{$data['interest']}</td>
					</tr>
A;
						echo $html;
					}}
			?>
				</div>
			</li>
		</ul>
		<a href='member_update.php'>编辑</a>
		<div style="clear: both; margin-bottom: 20px"></div>
		<?php /*
		<div
			style="width: 100%; height: 30px; line-height: 30px; text-indent: 10px; background: #e6e6e6; color: #666; font-weight: bold;">
			历史搜索记录</div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<ul >
			<li>
				<div>
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
			</li>
		</ul>
		<div style="clear: both; margin-bottom: 20px"></div>
		*/?>
		<div style="width: 100%; height: 30px; line-height: 30px; text-indent: 10px; background: #e6e6e6; color: #666; font-weight: bold;">
			收藏的景点</div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<ul >
			<li>
			<div>
			<table class="list">
			<tbody><tr>
				<th>景点名称</th>	 	 	
				<th>描述</th>
				<th>地址</th>
				<th>访问</th>
				<th>取消收藏</th>
			</tr>
	           <?php
					$query = "SELECT * From usercollect Where user_id={$member_id};";
					$result = execute ( $link, $query );
					while ( $data = mysqli_fetch_assoc ( $result ) ) {
						$query1="select * from scenerypic where SNO={$data['usercollect']}";
						$result1=execute($link, $query1);
						while ($data1= mysqli_fetch_assoc ( $result1 )){
									// var_dump($data);
$html = <<<A
							<tr>
								<td>{$data1['Title']}</td>
								<td>{$data1['Desc']}</td>
								<td>{$data1['Addr']}</td>
								<td><a target="_blank" href="show.php?id={$data1['SNO']}">[查看详情]</a></a></td>
								<td><a  href="member_delete.php?id={$member_id}&SNO={$data1['SNO']}">[取消收藏]</a></a></td>
								
							</tr>
A;
					echo $html;
					}				
						}

				?>	
				</tbody></table>
				</div>
			</li>
		</ul>
	</div>
	
	
	<div id="right">
		<div class="member_big">
			<dl>
				<dt>
					<img width="180" height="180" src="style/photo.jpg" />
				</dt>
				<?php echo $data['name']?>
				<!--<dd>操作：<a target="_blank" href="">修改头像</a> | <a target="_blank" href="">修改密码</a></dd>-->
			</dl>
			<div style="clear: both;"></div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>

<?php include_once 'inc/footer.inc.php';?>