
//                    <!-- 计数幻灯片 -->
var count=1;
//                    <!--获取总数-->
function scroll_news(){
//                        图片切换
    var firstNode = $('#slider li'); //获取li对象
    firstNode.eq(0).fadeOut("slow", function(){ //获取li的第一个,执行fadeOut,并且call - function.
        //计数
        if(count==5){
            count=1;
        }else {
            count++;
        }
         $("#instruction").html(count)
//                            图片切换
        $(this).clone().appendTo($(this).parent()).show(); //把每次的li的第一个 克隆，然后添加到父节点 对象。
        $(this).remove();//最后  把每次的li的第一个 去掉。
    });//这些都是在fadeOut里面的callback函数理执行的。
}
setInterval('scroll_news()',3000);//每隔0.5秒，执行scroll_news()
