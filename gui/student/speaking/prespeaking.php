<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">

	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-shadow btn-countinue text-dark btn-disabled" >CONTINUE</button>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-lg scrollable">
		<div class="text-center m-t-xl">
			<img src="/res/images/tfmk/do.png">
			<p class="h2 text-dark font-400 m-t text-center" >耳机和麦克风测试</p>
			<div class="row">
	 			<p class="h4 md m-t-lg col-lg-4 col-lg-offset-4 text-left" ><a href="javascript:;" class="e-t-v"><i class="fa fa-volume-down fa-lg m-r"></i></a>点击 "喇叭" 进行耳机测试</p>
			</div>
			<div class="row m-t">
				<p class="h4 md m-t-sm text-left col-lg-4 col-lg-offset-4 font-400" ><i class="fa fa-microphone fa-lg text-dark m-r" aria-hidden="true"></i>
					<button class="btn btn-warning dker padder-ex startrecorder">测试录音</button>
					<button class="btn btn-info padder-ex stoprecorder d-n">停止录音</button>
					<button class="btn btn-info padder-ex playrecorder d-n">播放录音</button>
				</p>
			</div>
		</div>
	</section>
	<div class="d-n audiolist">
		<audio id="audition"><source src="/res/audio/static/TFMK-SPEAKING-PRE.mp3" type="audio/mpeg"></audio>
	</div>	
	<section class="d-n">
		<form action="/mock/speakingdirections" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="token" value="<?=$token?>">
		</form>
	</section>

</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
var a, status = false;
var flag = 0;
$(function (){
	a = document.getElementById('audition');

	$('.e-t-v').on('click', function (){
		if(!a.paused){a.pause() ;}else{a.play();}
	});

	$('.startrecorder').on('click', function (){
		if(!a.paused){
			a.pause() ;
		}
		window.webkit.messageHandlers.startrecorder.postMessage(null);	
		$('.btn-countinue').removeClass('btn-disabled');
	});

	$('.stoprecorder').on('click', function (){
		window.webkit.messageHandlers.stoprecorder.postMessage(['0', '0', 'play']);
	});

	$('.playrecorder').on('click', function (){
		window.webkit.messageHandlers.playrecorder.postMessage(null);
	});

	$('.btn-countinue').on('click', function (){
		if($(this).hasClass('btn-disabled')){
			return ;
		}
		window.webkit.messageHandlers.next.postMessage(null);
		$('form').submit();
	});
});

function start (){
	$('.stoprecorder').removeClass('d-n');
	//$('.startrecorder').removeClass('d-n');
	$('.playrecorder').addClass('d-n');	
}
function stop(){
	$('.stoprecorder').addClass('d-n');
	$('.startrecorder').addClass('d-n');
	$('.playrecorder').removeClass('d-n');	
}

</script>
</body>
</html>