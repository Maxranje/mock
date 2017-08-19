<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section>
	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-default btn-shadow btn-countinue" ><span class="text-dark">CONTINUE</span></button>
		</div>
		<div class="clearfix"></div>
	</header>
	<section id="content" class="padder-md">
		<div class="m-t-lg">
			<p class="ready-title">Reading Directions</p>
			<div class="text-left wrapper-xl m-t-n-lg ready-info">
				<p>In this part of the Reading section. you will read 3 passages. In the test you will have 60 minutes to read the passage and answer the questions.</p>
				<p>Most questions are worth 1 point but the last question in this set is worth more than 1 point. The directions indicate how many points you may receive.</p>
				<p>Some passages include a word or phrase that is underlined in blue. Click on the word or phrase to see a definition or an explanation.</p>
				<p>When you want to move to the next question. click on Next. You may skip questions and go back to them later if you want to return to previous questions. click on Back.</p>
				<p>You can click on Review at any time and the review screen will show you which question you have answered and which you have not answered. From this review screen, you may go directly to any question you have already seen in the Reading section.</p>
				<p class="text-dark font-bold">Click on Continue to go on</p>
			</div>
		</div>
	</section>
	<section class="d-n"><form action="/mock/reading" method="post">
		<input type="text" name="sequence" value="<?=$exam['sequence']?>">
		<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
		<input type="text" name="starttime" value="<?=$time?>">
		<input type="text" name="endtime" value="<?=$time?>">
		<input type="text" name="beyound" value="n">
		<input type="text" name="token" value="<?=$token?>">
		<input type="text" name="isover" value="n">
	</form></section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	$(".btn-countinue").on('click', function (){
		$('form').submit();
	});
});
</script>
</body>
</html>