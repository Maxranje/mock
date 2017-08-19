<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('top.php');
?>
<section id="content">
	<section class="vbox">
		<header class="header bg-white b-b clearfix">
			<div class="row m-t-sm"><div class="col-sm-1 m-b-xs"><div class="btn-group"><button type="button" class="btn btn-sm btn-default refresh" title="Refresh"><i class="fa fa-refresh"></i></button></div></div></div>
		</header>
		<section class="scrollable wrapper">        	
						
			<h5 class="m-t-none m-t">模考状态 <span class="m-l-sm h6 text-muted"></span></h5>
			<?php
			if($state == "failed"){
				echo '<h3 class="state">'.$reson.'</h3>';
			}else {
				echo '<ul class="list-group gutter list-group-lg list-group-sp sortable m-t-md">';
				foreach ($student as $row) {
					echo '<li class="list-group-item m-t"> ';
					echo '<div class="clear">';
					echo '<a class="pull-left media-xs"><i class="fa fa-sort text-muted fa m-r-sm"></i> '.$row['name'].'</a>';
					echo '<a href="#" class="active pull-right media-xs text-right taginfo" data-toggle="class"><i class="fa fa-angle-double-down fa-lg text-success text-active"></i><i class="fa fa-angle-double-up text-success fa-lg text"></i></a>';
					echo '</div>';
					echo '<div class="m-t-sm">';
					echo '<div class="progress progress-sm progress-striped active m-b-none" >';
					echo '<div class="progress-bar progress-bar-success" data-toggle="tooltip" data-original-title="'.$row['progress'].'%" style="width: '.$row['progress'].'%"></div>';
					echo '</div></div>';
					echo '<div class="clear m-t d-n tagpanel">';
					echo '<div class="row pull-out bg-info text-center">';
					echo '<div class="col-xs-3"><div class="padder-v text-white"> <p class="m-t-sm">阅读</p> <p class="m-b-xs h6">'.$row['read'].' / 42 (完成 / 全部)</p> </div></div>';
					echo '<div class="col-xs-3 dk"><div class="padder-v text-white"> <p class="m-t-sm">听力</p> <p class="m-b-xs h6">'.$row['listen'].' / 34 (完成 / 全部)</p> </div></div>';
					echo '<div class="col-xs-3"><div class="padder-v text-white"> <p class="m-t-sm">口语</p> <p class="m-b-xs h6">'.$row['speak'].' / 6 (完成 / 全部)</p> </div></div>';
					echo '<div class="col-xs-3 dk"><div class="padder-v text-white"> <p class="m-t-sm">写作</p> <p class="m-b-xs h6">'.$row['write'].' / 2 (完成 / 全部)</p> </div></div>';
					echo '</div></div></li>';
				}
				echo '</ul>';			
			}
			?>			
		</section>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php include('footer.php'); ?>
<script type="text/javascript">
$(function (){

	$('.taginfo').on ('click', function (){
		$(this).parents('li').find('.tagpanel').slideToggle();
	});

});
G.set('nav_name', 'es');
</script>
</body>
</html>