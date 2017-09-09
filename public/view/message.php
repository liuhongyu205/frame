<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>哈哈哈哈~~~~hahhaha</title>
    <link rel="stylesheet" href="./static/bs3/css/bootstrap.css">
</head>
<body style="background: #eeeeee">

<div class="jumbotron" style="text-align: center;margin-top: 200px">
	<div class="container">
<!--        设置信息，回访来意操作-->
		<h1><?php echo $message;?></h1>
<!--        设置三秒内的跳转属性-->
		<p><a href="javascript:<?php echo $this->url ?>"><span id="time">3</span>三秒内不跳转，请点击我！！！！</a></p>
		<p>
<!--            手动链接跳转至百度-->
			<a href="http://www.baidu.com" class="btn btn-primary btn-lg">Click ME</a>
		</p>
	</div>
</div>
<script>
//            设置定时炸弹setTimeout
            setTimeout(function(){
              <?php echo $this->url ?>
//                时间设置为三秒
            },3000)
//                设置计时器，单位为一秒
            setInterval(function(){
                var time=document.getElementById('time');
//                时间被减1后重新赋给time.innerHtml
                time.innerHTML=time.innerHTML-1;

            },1000)
</script>
</body>
</html>
