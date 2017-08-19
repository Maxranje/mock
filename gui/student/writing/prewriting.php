<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">
	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence'];?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-default btn-shadow btn-countinue" ><span class="text-dark">CONTINUE</span></button>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-lg scrollable">
		<div class="text-center m-t-xl">
			<img src="/res/images/tfmk/mo.png">
			<p class="h2 text-dark font-400 m-t text-center" >Now put on your headset</p>
			<p class="h4 md m-t-xl text-center font-400" ><a href="javascript:;" class="audition-btn"><i class="fa fa-volume-down fa-lg m-r"></i></a>请点击左侧喇叭测试听力是否正常</p>
			<p class="h4 md m-t-sm text-center ready-info font-400" >请在考试前调整好音量, 以免影响考试</p>
		</div>
	</section>
	<div class="d-n">
		<audio id="audition">
			<source src="/res/audio/static/TFMK-SPEAKING-PRE.mp3" type="audio/mpeg">
		</audio>
	</div>
	<section class="d-n">
		<form action="/mock/writing" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="token" value="<?=$token?>">
		</form>
	</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	var a = document.getElementById('audition');
	$('.audition-btn').on('click', function (){
		if(!a.paused){
			a.pause() ;
		}else{
			a.play();
		}
	});

	$('.btn-countinue').on('click', function (){
		$('form').submit();
	});
});
</script>
</body>
</html>