<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="vbox">
<header class="header ex-s-header padder-md padder-v clearfix">
	<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
	<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
	<div class="pull-right m-t-sm">
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-next"><i class="fa fa-fast-forward m-r-xs"></i>NEXT	</button>
			<button class="btn btn-shadow pull-right text-dark btn-disabled" ><i class="fa fa-fast-backward m-r-xs"></i>BACK</button>
			<button class="btn btn-shadow pull-right text-dark btn-disabled" ><i class="fa fa-copy m-r-xs"></i>REVIEW</button>
		</p>
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-time" >HIDE TIME</button>
			<span class="pull-right top-time"><?=$time?></span>
		</p>
	</div>
	<div class="clearfix"></div>
</header>
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
						<p class="read-view-title"><?=$article['title']?></p>
						<div class="h4 md l-h-2x font-400 text-indent article_content"><?=$article['content']?></div>
					</div>
				</section>
			</section>
			<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
		</section>
	</section>
	<section class="d-n"><form action="/mock/reading" method="post">
			<input type="text" name="sequence" value="<?=$exam['sequence']?>">
			<input type="text" name="sn" value="<?=$exam['serialnumber']?>">
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

	var nsh = 0, nst = 0, nextAble = false;
	var nScrollHight = $('.scrollable').height();
	var paddingBottom = parseInt($('.scrollable').css('padding-bottom'));
	var paddingTop = parseInt($('.scrollable').css('padding-top'));
	$(".scrollable").scroll(function (){
		nsh = $(this)[0].scrollHeight;
		nst = $(this)[0].scrollTop;
		if( nst + paddingTop + paddingBottom + nScrollHight >= nsh){
			nextAble = true;
		}
	});

	$(".btn-next").on('click',	function (){
		if(!nextAble){ $('#tip-msg').modal('show'); return ; }
		$('form').submit();		
	});

	timeinterval ();
});

function timeover(){
	$('input[name=isover]').val('y');
	$('form').submit();
}

</script>
<div class="modal fade" id="tip-msg">
	<div class="modal-dialog"><div class="modal-content">
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title"> Message</h4></div>	
    <div class="modal-body">
		<p class="text-center wrapper-lg dialog-info m-t-n">You should use the scroll bar to read the whole passage before you begin to answer the question. However, the passage will appear again with each question.</p>
	</div>
</div></div></div>
</body>
</html>