<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">
<header class="header ex-s-header padder-md padder-v clearfix">	
	<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
	<div class="pull-left m-t-lg tpo-title">
		<?php $title_array = explode(' ', $sequence);  echo $title_array[0].$title_array[1]. " Text Review"?></div>
	<div class="pull-right m-t-sm">
		<p><button class="btn btn-shadow pull-right text-dark btn-return"><i class="fa fa-mail-reply m-r-xs"></i>RETURN</button></p>
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-time" >HIDE TIME</button>
			<span class="pull-right top-time"><?=$time?></span>
		</p>
	</div>
	<div class="clearfix"></div>
</header>
<section  class="wrapper-lg scrollable">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row text-dark h3 font-400 padder">
				<p class="col-lg-6">Question</p>
				<p class="col-lg-6 text-right">Your Answer</p>
			</div>
			<div class="line  line-lg pull-in"></div>
			<div class="content wrapper-lg scrollable m-b-n-lg  m-t-n-lg">
				<?php
				$i = 1;
				foreach ($question as $row) {
					echo '<div class="row review-item" data-sequence="'.$row['sequence'].'" data-sn="'.$row['serialnumber'].'">';
					echo '<p class="col-lg-9" style="text-overflow:ellipsis; white-space:nowrap; overflow:hidden; "><span class="m-r-sm">'.$i.'</span>'.$row['question_json']['title'].'</p><p class="col-lg-3">'.$row['student_answer'].'</p></div>';
					$i++;
				}
				?>
			</div>
			<section class="d-n"><form action="/mock/reading" method="post">
				<input type="text" name="sequence" value="<?=$sequence?>">
				<input type="text" name="sn" value="<?=$serialnumber?>">
				<input type="text" name="starttime" value="<?=$time?>">
				<input type="text" name="endtime" value="">
				<input type="text" name="beyound" value="n">
				<input type="text" name="token" value="<?=$token?>">
				<input type="text" name="isover" value="n">
			</form></section>			
		</div>
	</div>
</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	$(".btn-return").on('click', function (){
		$('form').submit();
	});
	$(".review-item").on('click',	function (){
		$('input[name=sequence]').val($(this).data('sequence'));
		$sn = $(this).data('sn') - 1;
		$('input[name=sn]').val($sn);
		$('form').submit();
	});	
	timeinterval ();
});
function timeover(){
	$('input[name=isover]').val('y');
	$('form').submit();
}
</script>
</body>

</html>