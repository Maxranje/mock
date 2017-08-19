<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(VIEWPATH.'student/inc/top.php');
?>
<section class="">
<header class="header ex-s-header padder-md padder-v clearfix">
	<div class="pull-left m-t m-r-sm"><img src="/res/images/logo_a.png" class="thumb-land "></div>
	<div class="pull-left m-t-lg tpo-title"><?=$exam['sequence']?></div>
	<div class="pull-right m-t-sm">
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-next"><i class="fa fa-fast-forward m-r-xs"></i>NEXT	</button>
			<button class="btn btn-shadow pull-right text-dark btn-back"><i class="fa fa-fast-backward m-r-xs"></i>BACK</button>
			<button class="btn btn-shadow pull-right text-dark btn-review" ><i class="fa fa-copy m-r-xs"></i>REVIEW</button>
			<button class="btn btn-shadow pull-right text-dark btn-viewtext"><i class="fa fa-file-text-o m-r-xs"></i>VIEWTEXT</button>
		</p>
		<p>
			<button class="btn btn-shadow pull-right text-dark btn-time" >HIDE TIME</button>
			<span class="pull-right top-time"><?=$time?></span>
		</p>
	</div>
	<div class="clearfix"></div>
</header>
<section  class="wrapper-lg scrollable">
	<?php
	$question = json_decode($exam['question_json'], true);
	$answer = explode(" ", $exam['student_answer']);
	echo '<p class="h4 md text-dark l-h-2x m-t font-400" >'.$question['title'].'</p>';

	?>
	<div class="row">
		<div class="panel panel-default panel-body col-lg-8 col-lg-offset-2 m-t-lg ex-s-dragquestion l-h-1x">
		<?php 
			if($answer[0] && $answer[0] != '-'){ 
				$index = $answer[0] == "A" ? 0 : ($answer[0] == 'B' ? "1" : ($answer[0] == 'C' ? "2" :($answer[0]=='D'?'3':($answer[0]=='E'?5:6))));
				echo '<span class="key"><a name="'.$index.'">'.$answer[0].'</a></span><span class="value"><a>'.$question['item'][$answer[0]].'</a></span>';
			}	
		?>	
		</div>
		<div class="panel panel-default panel-body col-lg-8 col-lg-offset-2 m-t  l-h-1x ex-s-dragquestion">
		<?php 
			if(isset($answer[1]) && $answer[1] != '-'){ 
				$index = $answer[1] == "A" ? 0 : ($answer[1] == 'B' ? "1" : ($answer[1] == 'C' ? "2" :($answer[1]=='D'?'3':($answer[1]=='E'?5:6))));
				echo '<span class="key"><a name="'.$index.'">'.$answer[1].'</a></span><span class="value"><a>'.$question['item'][$answer[1]].'</a></span>';
			}	
		?>			
		</div>
		<div class="panel panel-default panel-body col-lg-8 col-lg-offset-2 m-t ex-s-dragquestion l-h-1x" >
		<?php 
			if(isset($answer[2]) && $answer[2] != '-'){ 
				$index = $answer[2] == "A" ? 0 : ($answer[2] == 'B' ? "1" : ($answer[2] == 'C' ? "2" :($answer[2]=='D'?'3':($answer[2]=='E'?5:6))));
				echo '<span class="key"><a name="'.$index.'">'.$answer[2].'</a></span><span class="value"><a>'.$question['item'][$answer[2]].'</a></span>';
			}	
		?>				
		</div>
	</div>
	<div class="m-t-xl text-center h3 text-dark font-400">Answer Choices</div>
	<?php
	echo '<div class="row wrapper-lg" >';
	$index = 0 ;
	foreach ($question['item'] as $key=>$value) {
		if($index % 2 == 0){
			echo '<div class="panel panel-default panel-body col-lg-5 m-t-lg b-a ex-s-draganwser">';	
		}else{
			echo '<div class="panel panel-default panel-body col-lg-5 m-t-lg b-a ex-s-draganwser col-lg-offset-2">';
		}
		//echo '<div class="row" draggable="true" ondragstart="exdragstart(event)" id="draganwser'.$key.'">';
		echo '<div class="row" onclick="chooseit(\'draganwser'.$key.'\')" id="draganwser'.$key.'">';
		if(empty($answer)){
			echo '<p class="h4 md l-h col-sm-1 key"><a name="'.$index.'">'.$key.'</a></p><p class="h4 md l-h col-sm-11 value"><a>'.$value.'</a></p>';
		}else if($answer[0] == $key || (isset($answer[1]) && ($answer[1] == $key)) 
			|| isset($answer[2]) && $answer[2] == $key){
			echo '';
		} else {
			echo '<p class="h4 md l-h col-sm-1 key"><a name="'.$index.'">'.$key.'.</a></p><p class="h4 md l-h col-sm-11 value"><a>'.$value.'</a></p>';
		}
		echo '</div></div>';
		$index ++;
	}
	echo "</div>";
	?>
	<div class="m-t-xl text-center h3 text-dark font-400">To review passage. Click View Text	</div>
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
</section>
</section>
<?php include(VIEWPATH.'student/inc/footer.php'); ?>
<script type="text/javascript">
$(function (){

	$('.ex-s-dragquestion').on('click', function (){
		if($(this).html() == ""){
			return ;
		}
		var index = $(this).find('.key a').attr('name');
		var div = '<div class="row" onclick="chooseit(\'draganwser'+index+'\')" id="draganwser'+index+'">' +
			'<p class="h4 md l-h col-sm-1 key">'+$(this).children('.key').html()+'</p>'+
			'<p class="h4 md l-h col-sm-11 value">'+$(this).children('.value').html()+'</p></div>';
		$('.ex-s-draganwser').eq(index).html(div);
		$(this).html('');
		setanswer ();
	});

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
	$('.btn-viewtext').on('click', function (){
		var map = new Map();
		map.set('time', $('input[name=endtime]').val());
		zy.submit_form_action ("/mock/viewtext", map);		
	});
	$('input[name=radio]').change(function (){
		let answer = $(this).next('.question-item').find('a').html();
		$('input[name=answer]').val(answer);
	});

	setanswer ();
	timeinterval ();

});

function chooseit(id){
	let key = $('#'+id).children('.key').html();
	let value = $('#'+id).children('.value').html();
	let as = $('.ex-s-dragquestion');
	for (let i = 0; i<3; i++){
		if($(as[i]).html().trim() == ""){
			$(as[i]).html('<span class="key">'+key+'</span><span class="value">'+value+'</span>');
			$('#'+id).html('');
			break;
		}
	}
	setanswer();
}

function setanswer (){
	let as = $('.ex-s-dragquestion');
	let answer = "";
	for (let i = 0; i<3; i++){
		let k = $(as[i]).children('.key').children('a').html();
		if(k == "" || k == undefined){
			k = "-";
		}
		k = k.substring(0, 1);
		answer += k + " ";
	}	
	answer=answer.substring(0, answer.length-1);
	$('input[name=answer]').val(answer);
}

function timeover(){
	$('input[name=isover]').val('y');
	$('form').submit();
}
</script>
</body>

</html>