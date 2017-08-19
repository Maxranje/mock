<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('inc/top.php');
?>
<style type="text/css">
#bg{position: relative; overflow: hidden;}
#bg, #content{width: 100%;height: 100%;}
.main{position: absolute; top: 50%; left:50%; background: hsla(0,0%,100%, 0.25);  transform: translate(-50%, -70%); width: 50%; cursor: pointer;
	overflow: hidden; padding: 35px; border-radius: .4em; box-shadow: 0 0 0 1px hsla(0,0%,100%,.1) inset, 0 .5em 1em rgba(0, 0, 0, 0.6);	}
.main::before { content: '';  position: absolute;  top: 0;  right: 0;  bottom: 0;  left: 0;  filter: blur(20px);  -webkit-filter: blur(20px); margin: -30px; }
</style>
<div id="bg"><div id="content"></div></div>
<div class="main">
	<section class="wrapper-md animated fadeInUp row " >
		<form class="" method="post" action="/mock/login">
			<h3 class="text-white text-center">请核对基本信息, 确认无误后点击悬浮窗口即可进入考试</h3>
			<div class="col-lg-8 col-sm-offset-4 m-t-md">
				<h3 class="text-white">姓名： <?=$student['student_name']?></h3>
				<h3 class="text-white">学校： <?=$student['student_school']?></h3>
				<h3 class="text-white">电话： <?=$student['student_phone']?></h3>
			</div>

			<input type="hidden" name="token" value="<?=$token?>">
			<input type="hidden" name="action" value="login">
		</form>
	</section> 
</div>
<?php include ('inc/footer.php') ?>
<script src="/res/js/vector/vector.js"></script>
<script type="text/javascript">
$(function(){
	var victor = new Victor("bg", "content");

	$('.main').on('click', function (){
		$('form').submit ();
	});
});
</script>
</body>
</html>