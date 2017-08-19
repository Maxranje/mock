<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="vbox">
	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence'] ?></div>
		<div class="pull-right m-t-sm">
			<p>
				<button class="btn btn-shadow pull-right text-dark btn-next"><i class="fa fa-fast-forward m-r-xs"></i>NEXT</button>
			</p>
			<p>
				<button class="btn btn-shadow pull-right text-dark btn-time" >HIDE TIME</button>
				<span class="pull-right top-time"><?=$time?></span>
			</p>
		</div>
		<div class="clearfix"></div>
	</header>
	<?php
		$question = json_decode($exam['question_json'], true);
	?>
	<section style="top:130px;">
	    <section class="hbox stretch">
			<section id="content">
				<section class="vbox">
					<section class="scrollable wrapper-lg bg-light lter ">
						<div class="text-dark">
							<div class="h4 md l-h-2x font-400 text-indent article_content"><?=$question['content']?></div>
						</div>					
					</section>
				</section>
				<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
			</section>

			<aside class="b-r hidden-print">
			</aside>
		</section>

	</section>


	<section class="d-n">
		<form action="/mock/writing" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="starttime" value="<?=$time?>">
			<input type="text" name="endtime" value="">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="isover" value="n">
		</form>
	</section>

</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
var result;
$(function (){
	$('.btn-next').on('click', function (){
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