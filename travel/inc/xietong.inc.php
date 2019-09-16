	<div class="title">基于用户的协同过滤算法的推荐结果</div>
		<table class="list">
			<tbody>
				<tr>
					<th>景点名称</th>
					<th>描述</th>
					<th>地址</th>
					<th>访问</th>
				</tr>
				<?php 
				if($backValue){
					//根据定位判断用户所处城市用哪一张表
					$q="select * from cityname where cityname='{$backValue['cityname']}'";
					$re=execute($link, $q);
					$biaoming=mysqli_fetch_assoc($re);
					//输出用的表名，var_dump($biaoming['biaoming']);
					
					//计算景点个数以及景点字段
					$query1="SHOW COLUMNS FROM {$biaoming['biaoming']} FROM hzc";
					$result1=execute($link, $query1);
					while ($data=mysqli_fetch_assoc($result1)){
						$citydaihao[]=$data['Field'];
					}
					   							//输出字段A,B,C...var_dump($citydaihao); 
					$n=count($citydaihao);	    //计算字段数量
												//计算字段数量，var_dump($n);

					//将表中的数据存入二维数组中
					$query = "SELECT * FROM {$biaoming['biaoming']} ";
					$result = execute($link, $query);					
					$array = array();
					while($row=mysqli_fetch_array($result))
					{
						$array[]=$row;//$array[][]是一个二维数组
					
					}
					$yonghushu=count($array);//记录用户的个数
				
					//判断当前用户的序号
					for($i=0;$i<$yonghushu;$i++){     
						if($array[$i][0]==$member_id){
							$user_id=$array[$i][0];
							$x=$i;
						}}
						//输出当前用户的序号，var_dump($x);	
						
			//利用皮尔森算法开始计算相似度
						$per=array();$per[0]=0;$p_fm11=0;$p_fm12=0;$p_fm1=0;
						for($i=2;$i<$n;$i++){
							if($array[$x][$i]!=null){
								$p_fm11 += $array[$x][$i] * $array[$x][$i];
								$p_fm12 +=$array[$x][$i];}}
						$p_fm1=sqrt(($n-2)*$p_fm11-$p_fm12*$p_fm12);						
						for($i=0;$i<$yonghushu;$i++){
							$p_fz1 = 0;$p_fz2=0;$p_fz22=0;$p_fm21 = 0;$p_fm22=0;$p_fm2=0 ;
							//echo "r(".$array[$x][1].",".$array[$i][1].")=";							
							for($j=2;$j<$n;$j++){
								if($array[$x][$j] != null && $array[$i][$j] != null){//计算分子p_fz1
									$p_fz1 += $array[$x][$j] * $array[$i][$j];}									
									if($array[$i][$j] != null){
										$p_fz22 +=  $array[$i][$j];}//p_fz22,求和y																					
								if($array[$i][$j] != null){//计算分母p_fm21
									$p_fm21 += $array[$i][$j] * $array[$i][$j];}		}
							$p_fz1=($n-2)*$p_fz1;
							$p_fz2=$p_fm12*$p_fz22 ;
							$p_fm2=sqrt(($n-2)*$p_fm21-$p_fz22*$p_fz22);
							$per[$i] = ($p_fz1-$p_fz2)/$p_fm1/$p_fm2;					
							}//echo $per[$i]."<br/>";

						
/*		//利用余弦公式计算相似度				
						$cos = array();
						$cos[0] = 0;
						$fm1 = 0;
						//开始计算cos
						//计算分母1，分母1是第一个公式里面 “*”号左边的内容，分母二是右边的内容
						for($i=2;$i<$n;$i++){
							if($array[$x][$i]!=null){//$array[$x]代表当前用户
								$fm1 += $array[$x][$i] * $array[$x][$i];
							}
						}					
						$fm1 = sqrt($fm1);				
						for($i=0;$i<$yonghushu;$i++){
							$fz = 0;
							$fm2 = 0;
							//echo "Cos(".$array[$x][1].",".$array[$i][1].")=";
					
							for($j=2;$j<$n;$j++){
								//计算分子
								if($array[$x][$j] != null && $array[$i][$j] != null){
									$fz += $array[$x][$j] * $array[$i][$j];
								}
								//计算分母2
								if($array[$i][$j] != null){
									$fm2 += $array[$i][$j] * $array[$i][$j];
								}
							}
							$fm2 = sqrt($fm2);
							$cos[$i] = $fz/$fm1/$fm2;
							//输出相似度，echo $cos[$i]."<br/>";
						}
					*/
				//对相似度计算结果进行排序,用快速排序
						function quicksort($str){
							if(count($str)<=1) return $str;//如果个数不大于一，直接返回
							$key=$str[0];//取一个值，稍后用来比较；
							$left_arr=array();
							$right_arr=array();				
							for($i=1;$i<count($str);$i++){//比$key大的放在右边，小的放在左边；
								if($str[$i]>=$key)
									$left_arr[]=$str[$i];
								else
									$right_arr[]=$str[$i];
							}
							$left_arr=quicksort($left_arr);//进行递归；
							$right_arr=quicksort($right_arr);
							return array_merge($left_arr,array($key),$right_arr);//将左中右的值合并成一个数组；
						}
	
						//排序后的cos值用neighbour记录
						$neighbour = array();//$neighbour只是对cos值进行排序并存储	
						$neighbour = quicksort($per);  
						// var_dump($neighbour);
						//输出排序后的cos值，
						
						//找出当前用户的null值,a记录当前用户该城市中null值的个数；c数组，记录null值的编号
						$a=0;
						for($j=2;$j<$n;$j++){
							if($array[$x][$j]==null and $array[$x][0]==$member_id){
								$a=$a+1;
								$c[]=$j;
							}
						}
						//c数组，记录null值的编号，var_dump($c);
						//记录null值的个数，var_dump($a);
								
						//$neighbour_set 存储最近邻的人和cos值//取出cos前三的用户，并用$neighbour_set记录他们对当前用户A的null值的景点的评分
						$neighbour_set = array();
						for($i=1;$i<4;$i++){            //除了自己的前三个
							for($j=0;$j<$yonghushu;$j++){
								if($neighbour[$i] == $per[$j]){     //$neighbour只是对cos值进行排序
									$neighbour_set[$i][0] = $j;
									$neighbour_set[$i][1] = $per[$j];
									for($k=0;$k<$a;$k++){
										$neighbour_set[$i][$k+2]=$array[$j][$c[$k]];
									}					
								}
							}
						}
						//相似用户以及他们对用户A评分为null的景点的评分，var_dump($neighbour_set);
						//取出出正相关的用户
						for($i=1;$i<4;$i++){
							if($neighbour_set[$i][1]>0){
								$zheng[]=$neighbour_set[$i];
							}
						}
						//var_dump($zheng);
						$zhengnum=count($zheng);
						//var_dump($zhengnum);
					
			//计算预测当前用户A对null处的评分
						//求出预测公式中的分子分母
						for($y=2;$y<$a+2;$y++){  //neighbour中第2个才开始记录评分。
								$p_arr=array();
								$pfz=0;
								$pfm=0;
								for($i=0;$i<$zhengnum;$i++){ //根据筛选出来的相似用户进行评分预测
									$pfz += $zheng[$i][1] * $zheng[$i][$y];
									$pfm += abs($zheng[$i][1]);					
								}
								
								//查询出为null值的对应的字段
								for($b=0;$b<$a;$b++){			
									$query="select  SNO from citybianhao where try='{$citydaihao[$c[$b]]}'";//c数组，记录null值的编号;$citydaihao存有景点代号
									$result=execute($link, $query);
									$data[]=mysqli_fetch_assoc($result);
								}	
								
								$p_arr[$y-2][0] = $data[$y-2];//景点编号SNO
								//输出景点编号，var_dump($p_arr[$y-2][0]);
								$p_arr[$y-2][1] = $pfz/sqrt($pfm);//对应 的预测出的分值
								//输出对应景点的预测分值var_dump($p_arr[$y-2][1]);
								if($p_arr[$y-2][1]>5){
									$query="select * from scenerypic where SNO={$p_arr[$y-2][0]['SNO']} ";
									$result = execute ( $link, $query );
									while ( $data= mysqli_fetch_assoc ( $result) ){
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
							}				
						}

}?>
								</tbody>
						</table>
