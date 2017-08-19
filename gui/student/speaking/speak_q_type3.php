<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">

	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-default btn-shadow btn-countinue" data-progress="pre"><span class="text-dark ">CONTINUE</span></button>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-xl scrollable pre-panel">
		<div class="text-center m-t-xl">
			<img src="/res/images/tfmk/speaking.jpg" class="m-t-xl" style="border-bottom:1px solid #e2e2e2; padding-bottom:40px;">
			<p class="h4 md m-t-xl text-center font-400" >
				<a href="javascript:;" class="btn-voice"> <i class="fa fa-volume-down fa-lg m-r-sm"> </i>
				点击喇叭，播放Question题型介绍，您可以点击右上角的Continue跳过</a>
			</p>
		</div>
	</section>
	<?php
	$question = json_decode($exam['question_json'], true);
	?>

	<!-- listen topic -->
	<section  class="wrapper-lg scrollable listen-panel d-n">
		<div class="m-t-lg wrapper-lg">
			<p class="text-center"> <img src="/res/images/tfmk/<?=$question['pic']?>"> </p>
			<div class="m-t-lg row">
				<div class="progress progress-sm progress-striped listen-progress active col-lg-6 col-lg-offset-3 no-padder b-a m-b-sm">
					<div class="progress-bar progress-bar-success listen-progress-bar" data-toggle="tooltip" style="width: 0%"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3 no-padder clear">
					<p class="pull-left starttime">00:00</p><p class="pull-right endtime">00:00</p>
				</div>
			</div>
		</div>
	</section>

	<!-- speaking pre tip -->
	<section  class="wrapper-xl scrollable main-panel d-n" data-value="">
		<div class="text-center row m-t-xl">
			<div class="col-lg-6 col-lg-offset-3 text-left">
				<p class="h4 md text-dark l-h-2x font-400"><?=$question['content']?></p>
				<div class="line m-t-lg"></div>
				<div class="wrapper inner-tip">
					<div class="m-t text-center"><i class="fa fa-headphones fa-4x" aria-hidden="true"></i></div>
					<div class="m-t text-center ex-speaking-tip1">Preparation Time: <span class="r1">20</span> Seconds</div>
					<div class="m-t text-center ex-speaking-tip1">Response Time: <span class="r2">60</span> Seconds</div>
				</div>
			</div>
		</div>
	</section>

	<!-- speaking progress -->
	<section  class="wrapper-xl scrollable answer-panel d-n">
		<div class="text-center row m-t-xl">
			<div class="col-lg-6 col-lg-offset-3 text-left">
				<p class="h4 md text-dark l-h-2x font-400"><?=$question['content']?></p>
				<div class="line m-t-lg"></div>
				<div class="m-t-lg wrapper inner-content">
					<div class="m-t text-center ex-tip2 font-400 recorder_title">Prepare you response</div>
					<div class="text-center ex-tip2 recorder" style="background: #fff"></div>
					<div class="text-center">
						<div class="progress progress-sm recorder-progress" style="height: 60px; background: #ddd; border-radius: 0;">
	                        <div class="progress-bar progress-bar-info recorder-progress-bar" data-toggle="tooltip" style="width: 0%"></div>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="d-n audiolist">
		<!-- 介绍用语音 -->
		<audio id="pre-audio">
			<source src="/res/audio/static/<?=$question['preaudio']?>" type="audio/mpeg">
		</audio>

		<!-- listen -->
		<audio id="listen-audio">
			<source src="/res/audio/tfmk/<?=$question['listenaudio']?>" type="audio/mpeg">
		</audio>

		<!-- question -->
		<audio id="question-audio">
			<source src="/res/audio/tfmk/<?=$question['questionaudio']?>" type="audio/mpeg">
		</audio>

		<!-- 提示语音 -->
		<audio id="tip1-audio">
			<source src="/res/audio/static/TFMK-SPEAKING-PREPARE.mp3" type="audio/mpeg">
		</audio>

		<audio id="tip2-audio">
			<source src="/res/audio/static/TFMK-SPEAKING-SPEAK.mp3" type="audio/mpeg">
		</audio>
	</div>	

	<section class="d-n">
		<form action="/mock/speaking" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="qid" value="<?=$exam['qid']?>">
		</form>
	</section> 

</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
var pre, listen, question, tip1, tip2;
$(function (){
	pre = document.getElementById('pre-audio');
	listen = document.getElementById('listen-audio');
	question = document.getElementById('question-audio');
	tip1 = document.getElementById('tip1-audio');
	tip2 = document.getElementById('tip2-audio');

	$('.btn-voice').on('click',function (){
		pre.play();
	});
	$('.btn-countinue').on('click', function (){
		let progress = $(this).data('progress');
		if(progress == "pre"){
			listen.play();
			listen.pause();
			tip1.play();
			tip1.pause();
			tip2.play();
			tip2.pause();			
			pre.pause();
			pre.onended();
		}
	});

	pre.onended = function (){
		$('.pre-panel').addClass('d-n');
		$('.listen-panel').removeClass('d-n');
		$('.btn-countinue').css('display', 'none');
		
		$('.endtime').html(sec2Time(Math.floor(listen.duration)));
		var i = parseInt($('.listen-progress').width())/parseInt(listen.duration);
		listen.play();
		si = setInterval(function (){
			processspeed(listen, i);
		}, 1000);
	}

	listen.onended = function (){
		clearInterval(si);
		$('.listen-progress').removeClass('active'); 
		$('.listen-panel').addClass('d-n');
		$('.main-panel').removeClass('d-n');
		p = 0;
		question.play();
	}

	question.onended = function (){
		$('.main-panel').addClass('d-n');
		$('.recorder').html(sec2Time(20));
		$('.recorder_title').html('Prepare you response');
		$('.answer-panel').removeClass('d-n');
		setTimeout(function (){
			tip1.play();
		}, 100);		
	}

	tip1.onended = function (){
		limit_time = 20;
		systime = 20;
		p = 0;
		var i = parseInt($('.recorder-progress').width())/(limit_time-1);
		$('.recorder_title').html('Prepare you response');
		$('.recorder').html(sec2Time (systime));
		var ti = setInterval(function(){
			systime--;
			p = p + i;
			$('.recorder').html(sec2Time (systime));
			$('.recorder-progress-bar').width(p);
			if (systime <= 0){
				clearInterval(ti);
				p = 0;
				$('.recorder-progress-bar').width(p);
				$('.recorder_title').html('Recorder');
				$('.recorder').html(sec2Time (60));		
				tip2.play();
			}
		}, 1000);		
	}

	tip2.onended = function (){
		window.webkit.messageHandlers.startrecorder.postMessage(null);	
	}

});

function start(){
	limit_time = 60;
	systime = 60;
	var sessionid= 0;
	<?php echo "sessionid = '".session_id()."';"; ?>	
	var i = parseInt($('.recorder-progress').width())/(limit_time-1);
	var ti = setInterval(function(){
		systime--;
		p = p + i;
		$('.recorder').html(sec2Time (systime));
		$('.recorder-progress-bar').width(p);
		if (systime <= 0){
			clearInterval(ti);
			window.webkit.messageHandlers.stoprecorder.postMessage([$('input[name=sn]').val(), $('input[name=qid]').val(), 'upload', sessionid]);
		}
	}, 1000);	
}

function stop(){
	$('form').submit();
}


var limit_time ;
var si, p = 0;
function processspeed(listen, i){
	p = p + i;
	$('.listen-progress-bar').width(p);
	$('.starttime').html(sec2Time( listen.currentTime));
}

// function endrecorderevent (blob){
// 	try{
// 		uploadToPHPServer(blob);
// 	}catch(err){
// 		alert(err.massage);
// 	}
// 	p = 0;
// 	$('.recorder-progress-bar').width(p);
// 	$('form').submit();
// }	


// function uploadToPHPServer(blob) {
// 	var file = new File([blob], 'msr'+limit_time+'.wav', { type: 'audio/wav' });
// 	var formData = new FormData();
// 	formData.append('sn', $('input[name=sn]').val());
// 	formData.append('qid', $('input[name=qid]').val());
// 	formData.append('blob', file);

// 	$.ajax({url: 'https://127.0.0.1/mock/upload?limit_time='+limit_time, type: 'POST', cache: false, data: formData,
// 		async:false,dataType:'json', processData: false, contentType: false, success:function (data){
// 		}, error:function (e){
// 			console.log(e);
// 		}
// 	});
// }
</script>
</body>
</html>