<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">
	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-default btn-shadow btn-countinue" ><span class="text-dark">CONTINUE</span></button>
			<button class="btn btn-default btn-shadow btn-voice" ><span class="text-dark"><i class="fa fa-volume-down fa-lg m-r-sm"></i>VOICE</span></button>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-lg scrollable">
		<p class="text-dark ready-title">Listening Directions</p>
		<div class="wrapper-lg m-t-n">
			<p class="ready-info">In this part you will listen to 1 conversation and 2 lectures.</p>
			<p class="ready-info">You must answer each question. After you answer, click on Next. Then click on OK to confirm your answer and go on to the next question. After you click on OK. you cannot return to previous questions. If you are using the Untimed Mode, you may return to previous questions.</p>
			<p class="ready-info">You will now begin this part of the Listening section. In an actual test, you will have 10 minutes to answer the questions.</p>
			<p class="text-dark h4 font-bold">Click on Continue to go on.</p>
		</div>
	</section>
	<div class="d-n">
		<audio id="audition">
			<source src="/res/audio/static/TFMK-LISTENING-DIRECTION-PART.mp3" type="audio/mpeg">
		</audio>
	</div>
	<section class="d-n">
		<form action="/mock/listening" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="starttime" value="<?=$time?>">
			<input type="text" name="endtime" value="<?=$time?>">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="isover" value="n">
		</form>
	</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	var a = document.getElementById('audition');
	$('.btn-countinue').on('click', function (){
		$('form').submit();
	});
	$('.btn-voice').on('click', function (){
		if(!a.paused){
			a.pause() ;
		}else{
			a.play();
		}
	});	
});
</script>
</body>
</html>
