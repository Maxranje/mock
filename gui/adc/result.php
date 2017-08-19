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
					<button type="button" class="btn btn-sm btn-default  btn-report" title="导出PDF"><i class="fa fa-file-pdf-o m-r-sm"></i>导出PDF</button>
				<div></div>
				<div class="col-sm-2 m-b-xs infomsg l-h-2x font-bold"></div>
			</div>
		</header>
		<section class="scrollable wrapper">        					
			<div class="panel panel-default ">
				<div class="panel-body">
					<h4 data-id="<?=$student['id']?>" id="sid"><?=$student['name']?>模考答题卡</h4>
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
							$index = 0;
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
											echo '<td class="text-center"><span style="font-weight:bold;text-decoration:underline; color:red">'.$row['student_answer'].'</span></td>';
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
							$index = 0;
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
							if($row['type'] == "s"){
								$question = json_decode($row['question'], true);
								echo '<div class="panel panel-default panel-body text-dark l-h-2x text-left">';
								echo '<div class="inner-content">';
								echo '<p class="page-info" style="text-overflow:ellipsis; white-space:nowrap; overflow:hidden; ">考试题目<span class="m-l">'.$question['content'].'</span></p>';
								echo '<div class="line line-dashed line-lg pull-in"></div>';
								echo '<p class="page-info">考试得分<span class="m-l m-r-xs font-bold ">'.$row['student_score'].'</span>分</p>';
								echo '<div class="line line-dashed line-lg pull-in"></div>';
								echo '<p class="page-info">教师批注:</p>';
								echo '<p class="">'.$row['student_comments'].'</p>';
								echo '</div>';
								echo '</div>';
							}
						}
						?>					
					</div>	
					<p class="carousel m-t-xl clearfix h6"><span class="ribbon3">写作</span></p>
					<div class="write m-t-xxl">
						<?php
						foreach ($item as $row) {
							if($row['type'] == "w"){
								$question = json_decode($row['question'], true);
								echo '<div class="panel panel-default panel-body text-dark l-h-2x text-left">';
								echo '<div class="inner-content">';
								echo '<p class="page-info">考试题目<span class="m-l">'.$question['title'].'</span></p>';
								echo '<div class="line line-dashed line-lg pull-in"></div>';
								echo '<p class="page-info">学生作文</p>';
								echo '<p>'.$row['student_answer'].'</p>';
								echo '<div class="line line-dashed line-lg pull-in"></div>';
								echo '<p class="page-info">考试得分<span class="m-l m-r-xs font-bold ">'.$row['student_score'].'</span>分</p>';
								echo '<div class="line line-dashed line-lg pull-in"></div>';
								echo '<p class="page-info">教师批注:</p>';
								echo '<p class="">'.$row['student_comments'].'</p>';
								echo '</div>';
								echo '</div>';
							}
						}
						?>						
					</div>																			
				</div>
			</div>				
		</section>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php include('footer.php'); ?>
<script type="text/javascript">
G.set('nav_name', 'stun');

$(function (){
	$('.btn-report').on('click', function (){
		let sid = $('#sid').data('id');
		window.location.href="/mkadc/report/report?id="+sid;
	});
});

</script>
</body>
</html>