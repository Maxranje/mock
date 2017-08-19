<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>

<section class="">
	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
		<div class="pull-right m-t">
			<p>
				<button class="btn btn-shadow pull-right text-dark btn-next btn-disabled"><i class="fa fa-fast-forward m-r-xs"></i>NEXT</button>
				<button class="btn btn-shadow pull-right text-dark btn-ok btn-disabled"><i class="fa fa-check m-r-xs"></i>OK</button>
			</p>	
			<p>
				<button class="btn btn-shadow pull-right text-dark btn-time" >HIDE TIME</button>
				<span class="pull-right top-time"><?=$time?></span>
			</p>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-lg scrollable">
		<div class="wrapper-lg row">
			<div class="wrapper-lg m-t col-lg-offset-2 col-lg-8">
				<?php
				$question = json_decode($exam['question_json'], true);
				echo '<p class="font-400 l-h-2x listen-q-title">'.$question['title'].'</p>';
				echo '<div class="l-h h4 md m-t-md text-dark" id="question">';
				foreach ($question['item'] as $key => $value) {
					echo '<div class="m-t-lg">';
					echo '<label style="display:block">';
					echo '<span class="block col-lg-1 question-l-item" style="cursor:pointer; width:1.33%;">';
					echo '<input type="hidden" value="'.$key.'" name="answer_item">';
					echo '<input type="checkbox" name="answer_checkbox">';
					echo '</span>';
					echo '<span class="block col-lg-10 question-l-item" style="cursor:pointer">'.$value.'</span>';
					echo '<div class="clearfix"></div>';
					echo '</label>';
					echo '</div>';
				} 
				echo '</div>';
				echo '<p class="font-400 l-h-2x m-t-lg question-l-item" id="question_info">Check of two answer.</p>';
				?>
			</div>
		</div>
	</section>

	<section class="d-n">
		<form action="/mock/listening" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="starttime" value="<?=$time?>">
			<input type="text" name="endtime" value="">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="isover" value="n">
			<input type="text" name="answer" value="">
			<input type="text" name="qid" value="<?=$exam['qid']?>">
		</form>
	</section>
	
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<link rel="stylesheet" href="/res/js/fuelux/fuelux.css" type="text/css" cache="false">
<script src="/res/js/fuelux/fuelux.js" cache="false"></script>
<script type="text/javascript">
$(function (){
	$('span.question-l-item').on('click', function (){
		if($('input[name=answer_checkbox]:checked').length == 2){
			$('.btn-next').removeClass('btn-disabled');
			$('.btn-ok').addClass('btn-disabled');
		}else{
			$('.btn-next').addClass('btn-disabled');
			$('.btn-ok').addClass('btn-disabled');
		}
	});

	$('.btn-next').on('click', function (){
		if(!$(this).hasClass('btn-disabled')){
			$(this).addClass('btn-disabled');	
			$('.btn-ok').removeClass('btn-disabled');
		}
	});

	$('.btn-ok').on('click', function (){
		if(!$(this).hasClass('btn-disabled')){
			var a = $('input[name=answer_checkbox]:checked');
			let answer = $(a[0]).prev('input[name=answer_item]').val();
			answer += " "+$(a[1]).prev('input[name=answer_item]').val();
			$('input[name=answer]').val(answer);
			$('form').submit();
		}
	});

	$('.top-time').html(sec2Time ($('.top-time').html()));
	timeinterval ();
});

function timeover(){
	$('input[name=isover]').val('y');
	$('form').submit();
}
</script>
</body>
</html>