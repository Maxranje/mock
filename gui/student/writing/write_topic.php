<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">

	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-shadow pull-right text-dark btn-next"><i class="fa fa-fast-forward m-r-xs"></i>NEXT</button>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-lg scrollable">
		<div class="m-t-lg wrapper-lg">
			<?php  $question = json_decode($exam['question_json'], true); ?>
			<p class="text-center"> <img src="/res/images/tfmk/tfmk-w.jpg"> </p>
			<p class="text-center m-t listen-b1"><a class="listen-btn" href="javascript:;">点击听录音</a></p>
			<div class="m-t-lg row d-n listen-p1">
				<div class="progress progress-sm progress-striped active col-lg-6 col-lg-offset-3 no-padder b-a m-b-sm">
					<div class="progress-bar progress-bar-success" data-toggle="tooltip" style="width: 0%"></div>
				</div>
			</div>
			<div class="row d-n listen-p2">
				<div class="col-lg-6 col-lg-offset-3 no-padder clear">
					<p class="pull-left starttime">00:00</p><p class="pull-right endtime">00:00</p>
				</div>
			</div>
		</div>
	</section>
	
	<div class="d-n">
		<audio preload="load" id="audition">
			<source src="/res/audio/tfmk/<?=$question['audio']?>" type="audio/mpeg">
		</audio>
	</div>

	<section class="d-n">
		<form action="/mock/writing" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="isover" value="n">
		</form>
	</section>

</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function(){
	var audition = document.getElementById('audition');
	audition.onended = function (){
		clearInterval(si);
		$('.progress').removeClass('active'); 
		$('form').submit();
	}
	$('.listen-btn').on('click', function (){
		$('.listen-b1').addClass('d-n');
		$('.listen-p1').removeClass('d-n');
		$('.listen-p2').removeClass('d-n');
		$('.endtime').html(sec2Time(Math.floor(audition.duration)));
		var i = parseInt($('.progress').width())/parseInt(audition.duration);
		audition.play();
		si = setInterval(function (){
			processspeed(audition, i);
		}, 1000);
	});

	$('.btn-next').on('click', function (){
		$('form').submit();	
	});
});

function processspeed(audition, i){
	p1 = p1+i;
	$('.progress-bar').width(p1);
	$('.starttime').html(sec2Time( audition.currentTime));
}

var si, p1 = 0;
</script>
</body>
</html>