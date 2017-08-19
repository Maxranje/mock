<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="vbox">
<header class="header ex-s-header padder-md padder-v clearfix">	
	<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
	<div class="pull-left m-t-lg tpo-title"><?php echo $sequence['0']." Reading" ;?></div>
	<div class="pull-right m-t-sm">
		<p>
			<a class="btn btn-shadow pull-right text-dark  btn-disabled"><i class="fa fa-fast-forward m-r-xs"></i>NEXT	</a>
			<a class="btn btn-shadow pull-right text-dark  btn-disabled"><i class="fa fa-fast-backward m-r-xs"></i>BACK</a>
			<a class="btn btn-shadow pull-right text-dark  btn-disabled"><i class="fa fa-copy m-r-xs"></i>REVIEW</a>
			<a class="btn btn-shadow pull-right text-dark btn-return"><i class="fa fa-file-text-o m-r-xs"></i>VIEWQUESTION</a>
		</p>
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-time" >HIDE TIME</button>
			<span class="pull-right top-time"><?=$time?></span>
		</p>
	</div>
	<div class="clearfix"></div></header>
<section style="top:130px;">
    <section class="hbox stretch">
		<aside class="b-r hidden-print">
		</aside>
		<section id="content">
			<section class="vbox">
				<section class="scrollable wrapper-lg bg-light lter ">
					<div class="text-dark">
						<?php
						$article = json_decode($article, true);
						?>
						<p class="read-view-title" ><?=$article['title']?></p>
						<div class="h4 md l-h-2x font-400 text-indent article_content"><?=$article['content']?></div>
					</div>
				</section>
			</section>
			<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
	</section>
	<section class="d-n"><form action="/mock/reading" method="post">
			<input type="text" name="sequence" value="<?=$sequence ?>">
			<input type="text" name="sn" value="<?=$serialnumber?>">
			<input type="text" name="starttime" value="<?=$time?>">
			<input type="text" name="endtime" value="">
			<input type="text" name="beyound" value="n">
			<input type="text" name="token" value="<?=$token?>">
			<input type="text" name="isover" value="n">
	</form></section>	
</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	$(".btn-return").on('click', function (){
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