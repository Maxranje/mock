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
			<div class="wrapper-lg col-lg-offset-2 col-lg-8">
				<?php
				$question = json_decode($exam['question_json'], true);
				echo '<p class="font-400 l-h-2x listen-q-title">'.$question['title'].'</p>';
				?>
				<div class="wrapper-lg bg-gray text-center text-dark h4 font-400 m-t-lg">Click in correct box for each phrase</div>
				<div class="m-t-lg" id="question">
					<div class="bg-gray padder-v row h4 md font-400 b-b m-n">
						<div class="col-lg-8 text-dark "></div>
						<div class="col-lg-2 text-dark ">Yes</div>
						<div class="col-lg-2 text-dark ">No</div>
					</div>
					<?php
					foreach($question['item'] as $key=>$value) {
						echo '<div class="padder-v row h4 md font-400 b-b b-r b-l m-n question-table-item" data-value="-">';
						echo '<div class="col-lg-8 text-dark">'.$value.'</div>';
						echo '<div class="col-lg-2 text-dark"><input type="radio" name="answer_radio_'.$key.'" data-value="Y"></div>';
						echo '<div class="col-lg-2 text-dark"><input type="radio" name="answer_radio_'.$key.'" data-value="N"></div>';
						echo '</div>';
					}
					?>
				</div>
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
<script type="text/javascript">
$(function (){

	$('.btn-next').on('click', function (){
		if(!$(this).hasClass('btn-disabled')){
			$(this).addClass('btn-disabled');	
			$('.btn-ok').removeClass('btn-disabled');
		}
	});

	$('input[type=radio]').change(function (){
		if($('input[type=radio]:checked').length == 4){
			$('.btn-next').removeClass('btn-disabled');
			$('.btn-ok').addClass('btn-disabled');
		}
		$(this).parents('.question-table-item').data('value', $(this).data('value'));
		let answer = '';
		for(let i = 0; i<4; i++){
			answer += $('.question-table-item').eq(i).data('value') + " ";
		}
		answer = answer.trim();
		$('input[name=answer]').val(answer);
	});

	$('.btn-ok').on('click', function (){
		if(!$(this).hasClass('btn-disabled')){
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