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