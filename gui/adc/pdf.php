<style type="text/css">

.navbar-fixed-top+section{padding-top:70px}.appear{visibility:hidden}.animated{-webkit-animation-duration:1s;-moz-animation-duration:1s;-ms-animation-duration:1s;-o-animation-duration:1s;animation-duration:1s}.d-n{display:none}.device{border-radius:6px!important}.device header{border-radius:5px 5px 0 0}.device.phone{border-radius:15px!important}.device.phone header{border-radius:14px 14px 0 0}.device.phone footer{border-radius:0 0 14px 14px}.navbar{border:none;-webkit-transition:padding ease-in-out .2s;transition:padding ease-in-out .2s}.navbar.affix-top{padding:10px 0}.navbar-nav>li>a{font-weight:700;text-transform:uppercase;font-size:12px}.navbar-nav .dropdown-submenu .dropdown-menu{left:0;top:100%;border:none;background-color:#f5f5f5;min-width:220px}#responsive{background:url(../images/render-1.png) #25313e center top no-repeat;background-size:cover}#responsive>div{background-color:#25313e;background-color:rgba(37,49,62,.95)}@media (max-width:767px){.navbar-fixed-top+section{padding-top:50px}.navbar.affix-top{padding:0}.navbar-brand{float:left!important}.h1{font-size:20px}}.chart-default-panel{height:430px}.piechart-panel{height:300px}.mapchart-panel{height:445px}ul.ex-top{margin:0;padding:0}ul.ex-top>li{position:relative;width:20%;height:80px;border:1px solid #ddd;list-style:none;float:left;margin-right:-1px;margin-top:-1px;background-color:#fdfdfd;background-image:-webkit-linear-gradient(bottom,#f5f5f5 0,#fbfbfb 35.3%,#fdfdfd 63.7%,#fbfbfb 100%);cursor:pointer}ul.ex-top>li>.shadow{position:absolute;right:-13px;bottom:-12px;width:145px;height:74px;display:none;background:url(../images/list_icon.png) no-repeat 0 -57px;z-index:2000}.ribbon3{display:inline-block;position:absolute;width:60px;height:25px;line-height:27px;padding-left:20px;background:#ffc333;color:#000;left:-23px;top:0}.ribbon3:before{content:'';position:absolute;width:0;height:0;border-bottom:8px solid #795805;border-left:8px solid transparent;top:-8px;left:0}.ribbon3:after{height:0;content:"";position:absolute;width:0;border-top:12px solid transparent;border-bottom:13px solid transparent;border-left:12px solid #ffc333;right:-12px}.padder-md{padding-right:25px;padding-left:25px}.vertical-center{position:absolute;left:50%;top:50%;transform:translate(-50%,+50%)}	
.mockscore{float: left; width: 20%; border:1px solid #000; border-right: 0px;} .mockscore h5{margin-bottom: 10px;}

.text-gray{color:#aaa;}
.page-info {border-bottom: 1px solid #ccc; padding: 10px 15px;}
.page-info.n-b {border-bottom: 0px ;}

</style>
<section class="scrollable">
	<h3><?php echo $student['name']?> </h3>
	<p><?php echo "Registration Number: ".$student['sid']?> </p>
	<div style="text-align: center; clear:both;">
		<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: center;">
			<tr width="100%"><td>Test</td><td>Test Date</td><td>Reading</td><td>Listening</td><td>Speaking</td><td>Writing</td><td>Total</td></tr>
			<tr>
				<td>TOEFL iBT</td>
				<td><?=$student['time']?></td>
				<td><?=$student['read']?></td>
				<td><?=$student['listen']?></td>
				<td><?=$student['speak']?></td>
				<td><?=$student['write']?></td>
				<td><?php echo $student['write'] + $student['read']+$student['speak']+$student['listen']; ?></td>
			</tr>
		</table>									
	</div>

	<div style="margin-top: 40px; text-align: center;"> <img src="/res/canvas/<?=$student['canvas']?>"> </div>			


	<h4 style="margin-top:40px;">阅读</h4>
	<div class="read m-t-md">
		<table style="border-spacing:0px 10px;">
			<thead>
				<tr>
					<th width="70" align="left">ID</th>
					<th align="left">Title</th>
					<th width="80" align="center">Answer</th>
					<th width="80" align="center">Right</th>
					<th width="80" align="center">Time</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$index = 1;
			foreach ($item as $row) {
				if($row['type'] == "r"){
					$question = json_decode($row['question'], true);
					echo '<tr><td>'.$index.'</td><td>'.$question['title'].'</td>';
					if($row['student_answer'] == $row['right_answer']){
						echo '<td align="center">'.$row['student_answer'].'</td>';
					}else{
						if($row['student_score'] == 2){
							echo '<td align="center">'.$row['student_answer'].'</td>';
						}else{
							echo '<td align="center"><span style="font-weight:bold;text-decoration:underline;">'.$row['student_answer'].'</span></td>';
						}
					}
					echo '<td align="center">'.$row['right_answer'].'</td>';
					echo '<td align="center">'.$row['student_time'].' s</td></tr>';
					$index++;
				}
			}
			?>
				
			</tbody>
		</table>
	</div>
	
	<h4 style="margin-top:40px;">听力</h4>
	<div class="read m-t-md">
		<table style="border-spacing:0px 10px;">
			<thead>
				<tr>
					<th width="70" align="left">ID</th>
					<th align="left">Title</th>
					<th width="80" align="center">Answer</th>
					<th width="80" align="center">Right</th>
					<th width="80" align="center">Time</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$index = 0;
			foreach ($item as $row) {
				if($row['type'] == "l"){
					$question = json_decode($row['question'], true);
					echo '<tr><td>'.$index.'</td><td>'.$question['title'].'</td>';
					if($row['student_answer'] == $row['right_answer']){
						echo '<td align="center">'.$row['student_answer'].'</td>';
					}else{
						if($row['student_score'] == 1){
							echo '<td align="center">'.$row['student_answer'].'</td>';
						}else{
							echo '<td align="center"><span style="font-weight:bold;text-decoration:underline;">'.$row['student_answer'].'</span></td>';
						}
					}
					echo '<td align="center">'.$row['right_answer'].'</td>';
					echo '<td align="center">'.$row['student_time'].' s</td></tr>';
					$index++;			
				}
			}
			?>
			</tbody>								
		</table>
	</div>	
	<h4 style="margin-top:40px;">口语</h4>
	<?php
	foreach ($item as $row) {
		if($row['type'] == "s"){
			$question = json_decode($row['question'], true);
			echo '<div style="border:1px solid #ccc; margin-top:20px;margin-bottom:20px;">';
			echo '<p class="page-info" style="text-overflow:ellipsis; white-space:nowrap; overflow:hidden; ">考试题目: <br/><br/><span>'.$question['content'].'</span></p>';
			echo '<p class="page-info" style="border:0px;">教师批注: <br/><br/> <span>'.$row['student_comments'].'</span></p>';
			echo '</div>';
		}
	}
	?>					
	<h4 style="margin-top:40px;">写作</h4>
	<?php
	foreach ($item as $row) {
		if($row['type'] == "w"){
			$question = json_decode($row['question'], true);
			echo '<div style="border:1px solid #ccc; margin-top:20px;margin-bottom:20px;">';
			echo '<p class="page-info" style="text-overflow:ellipsis; white-space:nowrap; overflow:hidden; ">考试题目: <br/><br/><span>'.$question['title'].'</span></p>';
			echo '<p class="page-info">学生作文:<br><br>'.$row['student_answer'].'</p>';
			echo '<p class="page-info" style="border:0px;">教师批注:<br/><br/> <span>'.$row['student_comments'].'</span></p>';
			echo '</div>';
		}
	}
	?>																											
</section>