<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include ("top.php");
?>
<section id="content">
	<section class="vbox">
		<header class="header bg-white b-b clearfix">
			<div class="row m-t-sm">
				<div class="col-sm-2 m-b-xs"><div class="btn-group">
					<button type="button" class="btn btn-sm btn-default refresh m-r-sm" title="Refresh"><i class="fa fa-refresh"></i></button>
					<button type="button" class="btn btn-sm btn-default  btn-save"><i class="fa fa-send m-r-sm"></i>成绩生成</button>
				<div></div>
				<div class="col-sm-2 m-b-xs infomsg l-h-2x font-bold"></div>
			</div>
		</header>
		<section class="scrollable wrapper">        					
			<div class="panel panel-default ">
				<div class="panel-body">
					<h4 data-id="<?=$student['id']?>" id="student"><?=$student['name']?>模考答题卡</h4>
					<h6 class="text-muted m-t"><?=$student['time']?></h6>
				
					<div class="m-t-xl">
						<div class="row text-center">
							<div class="col-lg-3">
								<section class="panel panel-default">
									<div class="panel-body">
										<span class=" h4 block m-t-sm m-b-sm">阅读</span> 
										<a class="m-t-sm block h3" style="color:#ff5a00"><?=$student['read']?> 分</a> 
									</div>
								</section>
							</div>
							<div class="col-lg-3">
								<section class="panel panel-default">
									<div class="panel-body">
										<span class=" h4 block m-t-sm m-b-sm">听力</span> 
										<a class="m-t-sm block h3" style="color:#ff5a00"><?=$student['listen']?> 分</a> 
									</div>
								</section>
							</div>
							<div class="col-lg-3">
								<section class="panel panel-default">
									<div class="panel-body">
										<span class=" h4 block m-t-sm m-b-sm">口语</span> 
										<a class="m-t-sm block h3" style="color:#ff5a00"><?=$student['speak']?> 分</a> 
									</div>
								</section>
							</div>
							<div class="col-lg-3">
								<section class="panel panel-default">
									<div class="panel-body">
										<span class=" h4 block m-t-sm m-b-sm">写作</span> 
										<a class="m-t-sm block h3" style="color:#ff5a00"><?=$student['write']?> 分</a> 
									</div>
								</section>
							</div>						
						</div>
					</div>

					<p class="carousel m-t-xxl clearfix h6"><span class="ribbon3">阅读</span></p>
					<div class="read m-t-xxl">
						<table class="table table-striped text-sm ">
							<thead><tr><th width="70">ID</th><th>题目</th><th class="text-center" width="100">回答</th><th width="100" class="text-center">正确答案</th><th width="110" class="text-center">答题时间</th></tr></thead>
							<tbody>
							<?php
							$index = 1;
							foreach ($item as $row) {
								if($row['type'] == "r"){
									$question = json_decode($row['question'], true);
									echo '<tr><td>'.$index.'</td>';
									echo '<td>'.$question['title'].'</td>';
									if($row['student_answer'] == $row['right_answer']){
										echo '<td class="font-bold text-center">'.$row['student_answer'].'</td>';
									}else{
										if($row['student_score'] == 2){
											echo '<td class="font-bold text-center">'.$row['student_answer'].'</td>';
										}else{
											echo '<td class="text-center"><span style="font-weight:bold;text-decoration:underline; color:red;">'.$row['student_answer'].'</span></td>';
										}
									}
									
									echo '<td class="font-bold text-center text-dark">'.$row['right_answer'].'</td>';
									echo '<td class="text-center">'.$row['student_time'].' s</td></tr>';
									$index++;
								}
							}
							?>
							</tbody>
						</table>
					</div>
					<p class="carousel m-t-xl clearfix h6"><span class="ribbon3">听力</span></p>
					<div class="listen m-t-xxl">
						<table class="table table-striped text-sm ">
							<thead><tr><th width="70">ID</th><th>题目</th><th class="text-center" width="100">回答</th><th width="100" class="text-center">正确答案</th><th width="110" class="text-center">答题时间</th></tr></thead>
							<tbody>
							<?php
							$index = 1;
							foreach ($item as $row) {
								if($row['type'] == "l"){
									$question = json_decode($row['question'], true);
									echo '<tr><td>'.$index.'</td>';
									echo '<td>'.$question['title'].'</td>';
									if($row['student_answer'] == $row['right_answer']){
										echo '<td class="font-bold text-center">'.$row['student_answer'].'</td>';
									}else{
										if($row['student_score'] == 1){
											echo '<td class="font-bold text-center">'.$row['student_answer'].'</td>';
										}else{
											echo '<td class="text-center"><span style="font-weight:bold;text-decoration:underline; color:red">'.$row['student_answer'].'</span></td>';
										}
									}
									echo '<td class="font-bold text-dark text-center">'.$row['right_answer'].'</td>';
									echo '<td class="text-center">'.$row['student_time'].' s</td></tr>';
									$index++;
								}
							}
							?>
							</tbody>								
						</table>
					</div>	
					<p class="carousel m-t-xl clearfix h6"><span class="ribbon3">口语</span></p>
					<div class="speak m-t-xxl">
						<?php
						foreach ($item as $row) {
						 	if($row['type'] == 's'){
						 		echo '<section class="panel panel-default"><header class="panel-heading font-bold no-padder">';
						 		echo '<p><audio controls="controls"><source src="/job/'.$student['name'].'/'.$row['student_answer'].'" type="audio/mpeg" /></audio></p>';
						 		echo '</header><div class="panel-body">';
						 		echo '<form class="bs-example form-horizontal">';
						 		echo '<input type="hidden" value="'.$row['id'].'" name="id">';
						 		echo '<div class="form-group"><label class="col-sm-1 control-label text-center">分数:</label>';
						 		echo '<div class="col-sm-10"><input type="text" class="form-control" name="score" value="'.$row['student_score'].'"></div></div>';
						 		echo '<div class="form-group"><label class="col-sm-1 control-label"></label>';
						 		echo '<div class="col-sm-10"><textarea class="form-control" rows="6" name="comments" placeholder="给学生的留言">'.$row['student_comments'].'</textarea></div>';
						 		echo '</div><div class="form-group"><div class="col-lg-offset-1 col-lg-10">';
						 		echo '</form><button class="btn btn-sm btn-default btn-submit">提交</button>';
						 		echo '<i class="fa fa-check-circle text-success btn-single fa-lg m-l d-n" aria-hidden="true"></i>';
						 		echo '</div></div>';
						 		echo '</div></section>';
						 	}
						 } 
						?>
					</div>	
					<p class="carousel m-t-xl clearfix h6"><span class="ribbon3">写作</span></p>
					<div class="write m-t-xxl">
						<?php
						foreach ($item as $row) {
						 	if($row['type'] == 'w'){
						 		$question = json_decode($row['question'], true);
						 		echo '<div class="panel panel-default panel-body text-dark l-h-2x text-left">';
						 		echo '<div class="inner-content"><p class="">题目: <span>'.$question['title'].'</span></p>';
						 		echo '<p class="m-t">学生作文:</p><p>'.$row['student_answer'].'</p></div></div>';

						 		echo '<section class="panel panel-default"><header class="panel-heading font-bold">写作评分</header>';
						 		echo '<div class="panel-body"><form class="bs-example form-horizontal">';
						 		echo '<input type="hidden" value="'.$row['id'].'" name="id">';
						 		echo '<div class="form-group"><label class="col-sm-1 control-label text-center">分数:</label>';
						 		echo '<div class="col-sm-10"><input type="text" class="form-control" name="score" value="'.$row['student_score'].'"></div></div>';
						 		echo '<div class="form-group"><label class="col-sm-1 control-label"></label>';
						 		echo '<div class="col-sm-10"><textarea class="form-control" rows="6" name="comments" placeholder="给学生的留言">'.$row['student_comments'].'</textarea></div>';
						 		echo '</div><div class="form-group"><div class="col-lg-offset-1 col-lg-10">';
						 		echo '</form><button class="btn btn-sm btn-default btn-submit">提交</button>';
						 		echo '<i class="fa fa-check-circle text-success btn-single fa-lg m-l d-n" aria-hidden="true"></i>';
						 		echo '</div></div>';
						 		echo '</div></section>';
						 	}
						 } 
						?>											
					</div>	
					<p class="carousel m-t-xl clearfix h6"><span class="ribbon3">指标图</span></p>		
					<div class="m-t-xxl">
						<div class="alert alert-danger m-b">
							<p>1. 上传图片尽可能在 256px * 256px</p>
							<p>2. 可重复上传指标图, 指标图会进行覆盖</p>
						</div>					
						<input type="file" class="filestyle" name="upload" id="upload" style="display: none">
						<div class="bootstrap-filestyle" style="display: inline;">
							<input type="text" class="form-control inline input-s" id="uploadview" disabled=""> 
							<label for="upload" class="btn btn-default"><span>选择分布图</span></label>
							<label class="btn btn-upload btn-success"><span>
								<?php
								if(isset($student['canvas']) && !empty($student['canvas'])){ echo "已上传, 重新上传" ;}
								else{echo "上传";}
								?>
							</span></label>
						</div>
					</div>																						
				</div>
			</div>				
		</section>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php include('footer.php'); ?>
<script type="text/javascript" src="/res/js/ajaxfileupload/ajaxfileupload.js"></script>
<script type="text/javascript">
G.set('nav_name', 'stun');
$(function (){


	$("#upload").change(function (){
		$('#uploadview').val($(this).val());
	});

	$('.btn-upload').on('click',function(){
		var id = $('#student').data('id');
		$.ajaxFileUpload({ 
			url: '/mkadc/datafactory/uploadcanvas',
			secureuri: false, //是否需要安全协议，一般设置为false
			fileElementId: 'upload', //文件上传域的ID
			data:{id:id},
			dataType: 'json', //返回值类型 一般设置为json
			success: function (data, status) {
				alert(data.reson);
			},
			error: function (data, status, e){
				alert("error: " +e);
			}
		});
	});

	$('.btn-submit').on('click', function (){
		var form = $(this).parents('form');
		var btn = $(this);
 		$.post('/mkadc/datafactory/markstudent', form.serialize(), function(data){
 			if(data.state =="failed"){
 				showTipMessageDialog (data.reson, data.state);
 			}else {
 				btn.next('.btn-single').removeClass('d-n');
 				btn.html("重新提交");
 			}
 		}, 'json');
		return false;
	});

	$('.btn-save').on('click', function (){
		var id = $('#student').data('id');
 		$.post('/mkadc/datafactory/studentscore', {id:id}, function(data){
 			if(data.state =="failed"){
 				showTipMessageDialog (data.reson,data.state);
 			}else {
 				window.location.reload(true);
 			}
 		}, 'json');
	});

});
</script>
</body>
</html>