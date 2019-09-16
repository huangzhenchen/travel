<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connect ();
$member_id = is_login ( $link );
if(!$member_id=is_login($link)){
	skip('index.php', 'error', '请登录!');
}
if(isset($_POST['submit'])){
$table=$_POST['table'];//将多选框中的值赋值给数组变量table
$c=count($table);
if($c==9){
$tableval=implode(',', $table);//把数组table组合为一个字符串,以便存入数据库中
$query="select * from user where id={$member_id}";
$result=execute($link, $query);
while($data=mysqli_fetch_assoc($result)){
	$query1="update userinterest set interest='{$tableval}' where user_name='{$data['name']}'";
	@execute($link, $query1);
	if(mysqli_affected_rows($link)){
		skip('index.php','ok','修改成功！');
	}
	
}}else {skip('index.php','error','请选择标签');}
}
$template ['title'] = '会员信息修改';
$template ['css'] = array (
		'style/public.css',
		'style/list.css',
		'style/member.css'
);

?>
<?php include_once 'inc/header.inc.php';?>
<div id="position" class="auto" style="margin-left: 200px">
	<a href="index.php">首页</a> 
	</div>
<div id="main" class="auto" style="margin-left: 200px">
	<div id="left">
		<div
			style="width: 100%; height: 30px; line-height: 30px; text-indent: 10px; background: #e6e6e6; color: #666; font-weight: bold;">
			原本我喜欢的景点标签</div>
		<div style="clear: both; margin-bottom: 20px"></div>
		<ul style="width: 638px">
			<li>
				<div style="width: 678px">
			<?php
			$query = "SELECT interest From user Where id={$member_id};";
			$result = execute ( $link, $query );
			while ( $data = mysqli_fetch_assoc ( $result ) ) {
				// var_dump($data);exit();
				$html = <<<A
			<tr>
				<td>{$data['interest']}</td>
			</tr>
A;
				echo $html;
			}
			?>
				</div>
			</li>
		</ul>
		<div style="clear: both; margin-bottom: 20px"></div>
		<div id="main" class="auto" ">
		<div id="left">
			<form method="post">
				<label style=" left;margin-left: 50px;">请勾选您感兴趣的标签：<span>*可多选</span><br />
					<div style="font-size: 15px;margin-right: 35px;">
						演出<input name="table[]" value="演出" style="width:30px" type="checkbox" class="choosetable">
						运动健身<input name="table[]" value="运动健身" style="width:30px" type="checkbox" class="choosetable">
						科技馆<input name="table[]" value="科技馆" style="width:30px" type="checkbox" class="choosetable">
						展览<input name="table[]" value="展览" style="width:30px" type="checkbox" class="choosetable">
						3D体验馆<input name="table[]" value="3D体验馆" style="width:30px" type="checkbox" class="choosetable">
						历史遗迹<input name="table[]" value="历史遗迹" style="width:30px" type="checkbox" class="choosetable">
						温泉<input name="table[]" value="温泉" style="width:30px" type="checkbox" class="choosetable"><br />
						密室逃脱<input name="table[]" value="密室逃脱" style="width:30px" type="checkbox" class="choosetable">
						博物馆<input name="table[]" value="博物馆" style="width:30px" type="checkbox" class="choosetable">
						城市观光<input name="table[]" value="城市观光" style="width:30px" type="checkbox" class="choosetable">
						游乐场<input name="table[]" value="游乐场" style="width:30px" type="checkbox" class="choosetable">
						儿童乐园<input name="table[]" value="儿童乐园" style="width:30px" type="checkbox" class="choosetable">
						4D/5D电影<input name="table[]" value="4D/5D电影" style="width:30px" type="checkbox" class="choosetable"><br />
						海洋馆<input name="table[]" value="海洋馆" style="width:30px" type="checkbox" class="choosetable">
						户外拓展<input name="table[]" value="户外拓展" style="width:30px" type="checkbox" class="choosetable">
						动力伞<input name="table[]" value="动力伞" style="width:30px" type="checkbox" class="choosetable">
						山岳<input name="table[]" value="山岳" style="width:30px" type="checkbox" class="choosetable">
						公园<input name="table[]" value="公园" style="width:30px" type="checkbox" class="choosetable">
						河流湖泊<input name="table[]" value="河流湖泊" style="width:30px" type="checkbox" class="choosetable">
						森林<input name="table[]" value="森林" style="width:30px" type="checkbox" class="choosetable"><br />
						湿地<input name="table[]" value="湿地" style="width:30px" type="checkbox" class="choosetable">
						赏花<input name="table[]" value="赏花" style="width:30px" type="checkbox" class="choosetable">
						漂流<input name="table[]" value="漂流" style="width:30px" type="checkbox" class="choosetable">
						生态农庄<input name="table[]" value="生态农庄" style="width:30px" type="checkbox" class="choosetable">
						名人故居<input name="table[]" value="名人故居" style="width:30px" type="checkbox" class="choosetable">
						宗教寺庙<input name="table[]" value="宗教寺庙" style="width:30px" type="checkbox" class="choosetable">
						水世界<input name="table[]" value="水世界" style="width:30px" type="checkbox" class="choosetable"><br />
						游船<input name="table[]" value="游船" style="width:30px" type="checkbox" class="choosetable">
						古村落<input name="table[]" value="古村落" style="width:30px" type="checkbox" class="choosetable">
						瀑布<input name="table[]" value="瀑布"style="width:30px" type="checkbox" class="choosetable">
						飞行<input name="table[]" value="飞行"style="width:30px" type="checkbox" class="choosetable">
						度假村<input name="table[]" value="度假村"style="width:30px" type="checkbox" class="choosetable">
						冲浪<input name="table[]" value="冲浪"style="width:30px" type="checkbox" class="choosetable">
						动物园<input name="table[]" value="动物园"style="width:30px" type="checkbox" class="choosetable">
						园林<input name="table[]" value="园林"style="width:30px" type="checkbox" class="choosetable"><br />
						影视基地<input name="table[]" value="影视基地"style="width:30px" type="checkbox" class="choosetable">
						纪念馆<input name="table[]" value="纪念馆"style="width:30px" type="checkbox" class="choosetable">
						溶洞<input name="table[]" value="溶洞"style="width:30px" type="checkbox" class="choosetable">
						植物园<input name="table[]" value="植物园"style="width:30px" type="checkbox" class="choosetable">
						草原<input name="table[]" value="草原" style="width:30px" type="checkbox" class="choosetable">
						岛屿<input name="table[]" value="岛屿" style="width:30px" type="checkbox" class="choosetable">
						鬼屋<input name="table[]" value="鬼屋" style="width:30px" type="checkbox" class="choosetable">
						泉潭<input name="table[]" value="泉潭" style="width:30px" type="checkbox" class="choosetable"><br />
						古镇<input name="table[]" value="古镇" style="width:30px" type="checkbox" class="choosetable">
						蔬果采摘<input name="table[]" value="蔬果采摘" style="width:30px" type="checkbox" class="choosetable">
						DIY手工<input name="table[]" value="DIY手工" style="width:30px" type="checkbox" class="choosetable">
						海滨<input name="table[]" value="海滨" style="width:30px" type="checkbox" class="choosetable">
						蜡像馆<input name="table[]" value="蜡像馆" style="width:30px" type="checkbox" class="choosetable">
						洗浴/汗蒸<input name="table[]" value="洗浴/汗蒸" style="width:30px" type="checkbox" class="choosetable">
						滑雪<input name="table[]" value="滑雪" style="width:30px" type="checkbox" class="choosetable"><br />
						峡谷<input name="table[]" value="峡谷" style="width:30px" type="checkbox" class="choosetable">
						观光车<input name="table[]" value="观光车" style="width:30px" type="checkbox" class="choosetable">
						陶艺<input name="table[]" value="陶艺" style="width:30px" type="checkbox" class="choosetable">
						索道<input name="table[]" value="索道" style="width:30px" type="checkbox" class="choosetable">
						主题节/集市<input name="table[]" value="主题节/集市" style="width:30px" type="checkbox" class="choosetable">
						沙漠<input name="table[]" value="沙漠" style="width:30px" type="checkbox" class="choosetable">
						探险猎奇<input name="table[]" value="探险猎奇" style="width:30px" type="checkbox" class="choosetable"><br />
						体育场馆<input name="table[]" value="体育场馆" style="width:30px" type="checkbox" class="choosetable">
						攀岩<input name="table[]" value="攀岩" style="width:30px" type="checkbox" class="choosetable">
						休闲度假<input name="table[]" value="休闲度假" style="width:30px" type="checkbox" class="choosetable">
						赛马<input name="table[]" value="赛马" style="width:30px" type="checkbox" class="choosetable">
						滑草场<input name="table[]" value="滑草场" style="width:30px" type="checkbox" class="choosetable">
						话剧舞台剧<input name="table[]" value="话剧舞台剧" style="width:30px" type="checkbox" class="choosetable">
						垂钓<input name="table[]" value="垂钓" style="width:30px" type="checkbox" class="choosetable"><br />
						骑行<input name="table[]" value="骑行" style="width:30px" type="checkbox" class="choosetable">
						茶馆<input name="table[]" value="茶馆" style="width:30px" type="checkbox" class="choosetable">
						热气球<input name="table[]" value="热气球" style="width:30px" type="checkbox" class="choosetable">
						滑水<input name="table[]" value="滑水" style="width:30px" type="checkbox" class="choosetable">
						蹦极<input name="table[]" value="蹦极" style="width:30px" type="checkbox" class="choosetable">
					</div>
				</label>
				<div style="clear:both;"></div>

				<input class="btn" name="submit" type="submit" value="确定修改" />
			</form>
		</div>
		<div id="right">
		<div class="member_big">
			<dl>
				<dt>
					<img width="180" height="180" src="style/photo.jpg" />
				</dt>
				<dd class="name"><?php echo $data['name']?></dd>
				<!--<dd>操作：<a target="_blank" href="">修改头像</a> | <a target="_blank" href="">修改密码</a></dd>-->
			</dl>
			<div style="clear: both;"></div>
		</div>
	</div>
		<div style="clear: both;"></div>
</div>
<?php include_once 'inc/footer.inc.php';?>