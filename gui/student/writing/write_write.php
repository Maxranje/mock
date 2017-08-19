<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">
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

	<section style="top:130px;">
		<?php
		$question = json_decode($exam['question_json'], true);
		?>
		<section class="wrapper-lg">
			<p class="h4 md l-h text-dark font-400">Directions: You have 20 minutes to plan and write your response. Your response will be judged on the basis of the quality of your writing and on how well your response presents the points in the lecture and their relationship to the reading passage. Typically an effective response will be 150 to 225 words. </p>
			<p class="h4 md l-h text-dark m-t-lg m-b-n font-400">Question: <?=$question['title']?></p>
		</section>
		<div class="line m-b-none" ></div>
		<section class="hbox stretch">
			<section id="content">
				<section class="hbox stretch"> <!-- .aside -->
					<aside class="b-r">
						<section class="wrapper-lg m-t-n text-dark">
							<div class="h4 md l-h-2x font-400 text-indent article_content"><?=$question['content']?></div>
						</section>
					</aside>
					<aside id="note-detail" style="height: 600px;"> 
						<section class="vbox"> 
							<header class="header bg-light lter b-b">
								<a class="btn btn-default m-r-sm btn-copy">Copy</a>
								<a class="btn btn-default m-r-sm btn-paste" >Paste</a>
								<a class="btn btn-default">Word Count<span class="wordcount m-l-sm">0</span></a>
							</header> 
							<section class="bg-light lter"> 
								<section class="vbox b-b">
									<section class="paper"> <textarea type="text" class="form-control scrollable" placeholder=""></textarea> </section> 
								</section> 
							</section> 
						</section> 
					</aside>
				</section>
				<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
			</section>
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
			<input type="text" name="qid" value="<?=$exam['qid']?>">
			<input type="text" name="answer" value="">
		</form>
	</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
var result;
$(function (){
	var textarea = $('textarea').get(0);
	textarea.addEventListener('input', function (){
		var value = $(this).val();
		value = value.replace(/[\u4e00-\u9fa5]+/g, " ");
		value = value.replace(/^\s+|\s+$/gi," ");
		value = value.replace(/\s+/gi," ");
		result = value;
		var length = 0;
		var match = value.match(/\s/g);
		if (match) {
			length = match.length + 1;
		} else if (value) {
			length = 1;
		}
		$('.wordcount').html(length);
	});
	$('.top-time').html(sec2Time ($('.top-time').html()));

	$('.btn-next').on('click', function (){
		var endtime = $('input[name=endtime]').val();
		if(endtime > 0){
			$('#tip-msg').modal('show');	
		}
	});

	$('.btn-countinue').on('click', function (){
		$('input[name=answer]').val($('textarea').val());
		$('form').submit();
	});

	$('.btn-copy').on('click', function (){
		var range = window.getSelection().getRangeAt(0).cloneContents();
		var div = document.createElement('div');
		div.appendChild(range);
		text = div.innerHTML;
	});

	$('.btn-paste').on('click', function (){
		$('textarea').val(text);
		var value = $('textarea').val();
		value = value.replace(/[\u4e00-\u9fa5]+/g, " ");
		value = value.replace(/^\s+|\s+$/gi," ");
		value = value.replace(/\s+/gi," ");
		result = value;
		var length = 0;
		var match = value.match(/\s/g);
		if (match) {
			length = match.length + 1;
		} else if (value) {
			length = 1;
		}
		$('.wordcount').html(length);		
	});

	timeinterval ();
});
var selecter, text;
function timeover(){
	$('input[name=answer]').val($('textarea').val());
	$('form').submit();
}

</script>
<div class="modal fade" id="tip-msg">
	<div class="modal-dialog"><div class="modal-content">
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title"> Finish Warning</h4></div>	
    <div class="modal-body">
		<p class="text-center wrapper-lg dialog-info m-t-n">You still have time to work on this section. As long as there is time remaining, you will be able to review your response and continue to work on it. Click on Return to go back to the current question. Click on Continue to leave this section. Once you leave this section, you will NOT be able to return to it.</p>
	</div>
	<div class="modal-footer text-center">
		<button class="btn btn-info btn-sm btn-countinue">COUNTINUE</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">RETURN</button>
	</div>
</div></div></div>
</body>
</html>