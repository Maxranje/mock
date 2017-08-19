<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">
	<header class="header ex-s-header padder-md padder-v clearfix">
		<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
		<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence'] ?></div>
		<div class="pull-right m-t-lg">
			<button class="btn btn-shadow pull-right text-dark btn-countinue">COUNTINUE</button>
		</div>
		<div class="clearfix"></div>
	</header>

	<section  class="wrapper-lg scrollable">
		<div class="">
			<p class="text-dark text-center ready-title">Writing Directions</p>
			<div class="wrapper-lg l-h-2x m-t-n">
			<p class="ready-info">For this task, you will read a passage about an academic topic. A clock at the top of the screen will show how much time you have to read. You may take notes on the passage while you read. The passage will then be removed and you will listen to a lecture about the same topic. While you listen, you may also take notes. You will be able to see the reading passage again when it is time for you to write. You may use your notes to help you answer the question.</p>
			<p class="ready-info">In an actual test, you will then have 20 minutes to write a response to a question that asks you about the relationship between the lecture you heard and the reading passage. Try to answer the question as completely as possible using information from the reading passage and lecture. The question does not ask you to express your personal opinion. Typically, an effective response will be 150 to 225 words.</p>
			<p class="ready-info">Your response will be judged on the quality of your writing and on the completeness and accuracy of the content.</p>
			<p class="ready-info">Now you will see the reading passage for minutes. Remember that it will be available to you again when you write. Immediately after the reading time ends, the lecture will begin, so keep your headset on until the lecture is over.</p>
			<p class="h4 text-dark">Click on Continue to go on.</p>
			</div>
		</div>
	</section>

	<section class="d-n">
		<form action="/mock/writing" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
			<input type="text" name="token" value="<?=$token?>">
		</form>
	</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	$('.btn-countinue').on('click', function (){
		$('form').submit();
	});
});
</script>
</body>
</html>