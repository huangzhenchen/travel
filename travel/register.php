<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(is_login($link)){
	skip('index.php','error','你已经登录，请不要重复注册！');
}
if(isset($_POST['submit'])){
	include 'inc/check_register.inc.php';//填写注册信息时的条件
	$table=$_POST['table'];//将多选框中的值赋值给数组变量table
	$tableval=implode(',', $table);//把数组table组合为一个字符串,以便存入数据库中
	$query="insert into user(name,password) values('{$_POST['name']}',md5('{$_POST['pw']}'))";//将用户名和经过MD5加密的密码存入user表中
	execute($link, $query);//执行SQL语句
	$query1="insert into userinterest(user_name,interest ) values ('{$_POST['name']}','{$tableval}')";//将用户名和用户喜好标签存入userinterest表中，以便后续用户修改喜好标签
	execute($link, $query1);//执行SQL语句
	if(mysqli_affected_rows($link)){//如果影响的行数为1
		setcookie('user[name]',$_POST['name']);
		setcookie('user[pw]',md5($_POST['pw']));//保证登录状态
		skip('index.php','ok','注册成功！');//注册成功则跳转至首页
	}else{
		skip('register.php','eror','注册失败！');//注册失败则跳转至注册页
	}
}
$template['title']='注册页面';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include_once 'inc/header.inc.php';?>
		<div id="register" style="width:960px;margin:0 auto;">
			<h2>欢迎注册成为 旅游信息推送系统会员</h2>
			<form method="post">
				<label>用户名：<input type="text" name="name"/><span>*用户名不能为空，并且长度不得超过32个字符</span></label>
				<label>密码：<input type="password" name="pw"/><span>*密码不得少于6位</span></label>
				<label>确认密码：<input type="password" name="confirm_pw"/><span>*请输入与上面一致的密码</span></label>
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
						泉潭<input name="table[]" value="泉潭" style="width:30px" type="checkbox" class="choosetable">
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
				<label>验证码：<input name="vcode" name="vocode" type="text"  /><span>*请输入下方验证码</span></label>
				<img class="vcode" src="show_code.php" />
				<div style="clear:both;"></div>
				<input class="btn" name="submit" type="submit" value="确定注册" />
			</form>
		</div>
<?php include_once 'inc/footer.inc.php';?>
