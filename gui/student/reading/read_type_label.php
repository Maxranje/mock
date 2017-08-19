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
						data-class="'.$question['tag']['class'].'">Look at the four squares [<span class="blackblock"></span>] that indicate where the following sentence could be added to the passage.Where would the sentence best fit?</p>';
					echo '<p class="m-t-lg h4 md l-h text-dark font-bold ex-s-answer">'.$question['info'].'</p>';
					echo '<div class="l-h h4 md m-t-lg text-dark">  ';
				?>
			</div>
		</aside>
		<section id="content">
			<section class="vbox">
				<section class="wrapper-lg bg-light lter text-dark articlepanel" style="overflow-y: auto;">
					<?php $article = json_decode($article, true); ?>
					<p class="read-view-title"><?=$article['title']?></p>
					<div class="h4 md l-h-2x font-400 article_content text-indent" ><?=$article['content']?></div>
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
	var tag = $('a#'+id_name);
	for(let i=0; i<tag.length; i++){
		tag.eq(i).html('<span class="blackblock"></span>');
	}
	$('a#'+id_name).on('click', function (){
		for(let i=0; i<tag.length; i++){
			tag.eq(i).html('<span class="blackblock"></span>');
		}		
		$(this).html("<span class='underblack'>"+$('.ex-s-answer').html()+"</span>");
		let index = $(this).index();
		index = index == 0 ? "A" : (index == '1' ? "B" : (index == '2' ? "C" : "D"));
		$('input[name=answer]').val(index);
	});

	dom = tag.eq(0);
	<?php 
	if (!empty($exam['student_answer'])) {
		$index = $exam['student_answer'] == "A" ? 0 : ($exam['student_answer'] == 'B' ? "1" : ($exam['student_answer'] == 'C' ? "2" : "3"));
		echo "tag.eq(".$index.").html(\"<span class='underblack'>\"+$('.ex-s-answer').html()+\"</span>\");";
		echo "dom = tag.eq(".$index.");";
	}
	?>

	scortTotag (dom);	
});

function scortTotag (dom){
	console.log(dom.offset());
	var px = parseInt(dom.offset().top) - parseInt($('.article_content').offset().top );
	$(".articlepanel").animate({scrollTop:px+'px'},500);
}

function timeover(){
	$('input[name=isover]').val('y');
	$('form').submit();
}
</script>
</body>

</html>