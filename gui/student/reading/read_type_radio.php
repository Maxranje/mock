<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<style type="text/css">

</style>
<section class="vbox">
<header class="header ex-s-header padder-md padder-v clearfix">
	<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
	<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
	<div class="pull-right m-t-sm">
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-next"><i class="fa fa-fast-forward m-r-xs"></i>NEXT	</a>
			<button class="btn btn-shadow pull-right text-dark btn-back 
				<?php
				$title_array = explode(' ', $exam['sequence']); 
				if( $title_array[5]== '1') echo "btn-disabled" ?>" ><i class="fa fa-fast-backward m-r-xs"></i>BACK</button>
			<button class="btn btn-shadow pull-right text-dark btn-review" ><i class="fa fa-copy m-r-xs"></i>REVIEW</button>
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
			<div class="wrapper-lg m-t">
				<?php
				$question = json_decode($exam['question_json'], true);
				echo '<p class="font-400 l-h-2x h4 md text-dark question_title" data-id="'.$question['tag']['id'].'" 
						data-class="'.$question['tag']['class'].'">'.$question['title'].'</p>';
				echo '<div class="l-h h4 md m-t-lg text-dark">  ';
				foreach ($question['item'] as $key => $value) {
					if($key == $exam['student_answer']){
						echo '<label><input type="radio" name="radio" id="answer_a" class="block pull-left" checked="checked">';	
					}else{
						echo '<label><input type="radio" name="radio" id="answer_a" class="block pull-left">';
					}
					echo '<p class="m-l-md question-item"><a>'.$key.'</a>.</p><p class="m-l-sm question-item content">'.$value.'</p>';
					echo '<div class="clearfix"></div></label>';
				}
				echo '<p class="l-h-2x h4 md text-dark">'.$question['info'].'</p></div>';
				?>
			</div>
		</aside>
		<section id="content">
			<section class="vbox">
				<section class="wrapper-lg bg-light lter articlepanel text-dark" style="overflow-y: auto;"> 
					<?php $article = json_decode($article, true); ?>
					<p class="read-view-title"><?=$article['title']?></p>
					<div class="h4 md l-h-2x font-400 article_content text-indent"><?=$article['content']?></div>
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
				<input type="text" name="answer" value="">
				<input type="text" name="qid" value="<?=$exam['qid']?>">
			</form></section>
			<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
		</section>
	</section>
</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){
	$(".btn-next").on('click',	function (){
		
		$('form').submit();		
	});
	$(".btn-back").on('click',	function (){
		if ($(this).hasClass('btn-disabled')){
			return ;
		}
		$('input[name=beyound]').val('y');
		$('form').submit();
	});	
	$(".btn-review").on('click', function (){
		var map = new Map();
		map.set('time', $('input[name=endtime]').val());
		zy.submit_form_action ("/mock/review", map);
	});	
	$('input[name=radio]').change(function (){
		let answer = $(this).next('.question-item').find('a').html();
		$('input[name=answer]').val(answer);
	});
	timeinterval ();

	var id_name = $('.question_title').data('id');
	$('#'+id_name).addClass ($('.question_title').data('class'));
	scortTotag ('#'+id_name);

});

function scortTotag (id){
	var px = parseInt($(id).offset().top) - parseInt($('.article_content').offset().top );
	$(".articlepanel").animate({scrollTop:px+'px'},500);
}

function timeover(){
	$('input[name=isover]').val('y');
	$('form').submit();
}
</script>
</body>
</html>