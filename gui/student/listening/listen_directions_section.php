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
			<button class="btn btn-default btn-shadow btn-voice" ><span class="text-dark"><i class="fa fa-volume-down m-r-sm fa-lg"></i>VOICE</span></button>
		</div>
		<div class="clearfix"></div>
	</header>
	<section  class="wrapper-lg scrollable">
		<div class="">
			<p class="text-dark text-center ready-title">Listening Section Directions</p>
			<div class="wrapper-lg l-h-2x m-t-n">
			<p class="ready-info">This test measures your ability to understand conversations and lectures in English.</p>
			<p class="ready-info">The Listening section is divided into 2 separately timed parts. In each part you will listen to 1 conversation and 2 lectures. You will hear each conversation or lecture only one time. After each conversation or lecture, you will answer some questions about it. The questions typically as about the main idea and supporting details. Some questions ask about a speaker's purpose or attitude. Answer the questions based on what is stated or implied by the speakers.</p>
			<p class="ready-info">You may take notes while you listen. You may use your notes to help you answer the questions. Your notes will not be scored. If you need to change the volume while you listen, click on the Volume icon at the top of the screen.</p>
			<p class="ready-info">In some questions, you will see this icon:<i class="fa fa-headphones" aria-hidden="true"></i> This means that you will hear, but not see. part of the question.
			Some of the questions have special directions. These directions appear in a gray box on the screen.
			Most questions are worth 1 point. If a question is worth more than 1 point, it will have special directions that indicate how many points you can receive.</p>
			<p class="ready-info">You must answer each question. After you answer, click on Next. Then click on OK to confirm your answer and go on to the next question. After you click on OK. you cannot return to previous questions.</p>
			<p class="ready-info">If you are using the Untimed Mode, you may return to previous questions and you may listen to each conversation and lecture again. Remember that prior exposure to the conversations, lectures, and questions could lead to an increase in your section scores and may not reflect a score you would get when seeing them for the first time.</p>
			<p class="ready-info">During this practice test, you may click the Pause icon at any time. This will stop the test until you decide to continue. You may continue the test in a few minutes or at any time during the period that your test is activated.
			In an actual test, and if you are using Timed Mode, a clock at the top of the screen will show you how much time is remaining. The clock will not count down while you are listening. The clock will count down only while you are answering the questions.</p>
			<p class="h4"></p>
			</div>
		</div>
	</section>
	<div class="d-n">
		<audio id="audition">
			<source src="/res/audio/static/TFMK-LISTENING-DIRECTION-SECTION.mp3" type="audio/mpeg">
		</audio>
	</div>
	<section class="d-n">
		<form action="/mock/listening" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="isover" value="n">
		</form>
	</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	var a= document.getElementById('audition');

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