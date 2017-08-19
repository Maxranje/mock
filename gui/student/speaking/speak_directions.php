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
		<div class="">
			<h3 class="ready-title">Speaking Section Directions</h3>
			<div class="wrapper-lg l-h-2x m-t-n">
			<p class="ready-info">In this Speaking practice test. YOU will be able to demonstrate your ability to speak about a variety of topics. You will answer six questions by speaking into a microphone. Answer each of the questions as completely as possible.</p>
			<p class="ready-info">In questions I and 2. you will speak about familiar topics. Your response will be scored on your ability to speak clearly and coherently about the topics.
			In questions 3 and 4. You will first read a short text. The text will go away and you will then listen to a talk on the same topic. You will then be asked a question about what you have read and heard You will need to combine appropriate information from the text and the talk to provide a complete answer to the question Your response will be scored on your ability to speak clearly and coherently and on your ability to accurately convey information about what you have read and heard In questions 5 and 6. you will listen to part of a conversation or a lecture. You will then be asked a question about what you have heard. Your response will be scored on your ability to speak clearly and coherently and on your ability to accurately convey information about what you heard. In questions 3 through 6. you may take notes while you read and while you listen to the conversations and lectures. You may use your
			notes to help prepare your response.
			</p>
			<p class="ready-info">Listen carefully to the directions for each question. The directions will not be written on the screen. For each question, you will be given a short time to prepare your response (15 to 30 seconds, depending on the question). A clock will show how much preparation time is remaining. When the preparation time is up. you will be told to begin your response. A clock will show how much response time is remaining. A message will appear on the screen when the response time has ended.
			In this practice test, you can click on Stop Recording to stop the recording of your response. You can also click on Playback Response to hear your recording. Once you have heard your response, you will have the opportunity to record your response again or confirm that you want to keep your response. In questions 3 through 6. you can click on Replay Talk if you want to listen to the conversations or lectures again. During this practice test, you may click the Pause icon at anytime. This will stop the test until you decide to continue. You may continue the test in a few minutes or at any time during the period that your test is activated.</p>
			<p class="ready-info">In some questions, you will see this icon:<i class="fa fa-"></i>This means that you will hear, but not see. part of the question.
				Some of the questions have special directions. These directions appear in a gray box on the screen.
				Most questions are worth 1 point. If a question is worth more than 1 point, it will have special directions that indicate how many points you can receive.</p>
			<p class="ready-info">Please note that the Stop Recording. Playback Response. Replay Talk, and Pause icons are available only for this practice test. They will NOT be available during the actual test. If you do not use these functions, your experience will be closer to the actual TOEFL test experience. Performance on the Speaking Practice test is not necessarily a predictor of how you might perform during an actual TOEFL administration.</p>
			<p class="h4 text-dark font-bold">Click on Continue to go on</p>
			</div>
		</div>
	</section>

	<div class="d-n audiolist">
		<audio id="audition"><source src="/res/audio/static/TFMK-SPEAKING_DIRECTION.mp3" type="audio/mpeg"></audio>
	</div>
	<section class="d-n">
		<form action="/mock/speaking" method="post">
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
	$('.btn-voice').on('click', function (){
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