<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('top.php');
?>
<section id="content">
	<section class="vbox">
		<header class="header bg-white b-b clearfix">
			<div class="row m-t-sm">
				<div class="col-sm-1 m-b-xs"><div class="btn-group"><button type="button" class="btn btn-sm btn-default refresh" title="Refresh"><i class="fa fa-refresh"></i></button></div></div>
				<div class="col-sm-2 m-b-xs infomsg l-h-2x font-bold"></div>
			</div>
		</header>
		<section class="scrollable wrapper">
			<div class="row">
				<div class="col-lg-3">
					<section class="panel panel-default">
						<div class="panel-body">
							<span class="fa-stack fa-2x pull-left m-r-sm"> 
								<i class="fa fa-circle fa-stack-2x text-info lter"></i>
								<i class="fa fa-users fa-stack-1x text-white"></i> 
							</span> 
							<a class="clear"> 
								<span class="h3 block m-t-xs"><strong><?=$countstun?></strong></span> 
								<small class="text-muted text-sm">总模考人数</small> 
							</a> 
						</div>
					</section>
				</div>
				<div class="col-lg-3">
					<section class="panel panel-default">
						<div class="panel-body">
							<span class="fa-stack fa-2x pull-left m-r-sm"> 
								<i class="fa fa-circle fa-stack-2x text-primary dker"></i>
								<i class="fa fa-line-chart fa-stack-1x text-white"></i> 
							</span> 
							<a class="clear"> 
								<span class="h3 block m-t-xs"><strong><?=$mockcount?></strong></span> 
								<small class="text-muted text-sm">总考试次数</small> 
							</a> 
						</div>
					</section>
				</div>
				<div class="col-lg-3">
					<section class="panel panel-default">
						<div class="panel-body">
							<span class="fa-stack fa-2x pull-left m-r-sm"> 
								<i class="fa fa-circle fa-stack-2x text-danger"></i>
								<i class="fa fa-rocket fa-stack-1x text-white"></i> 
							</span> 
							<a class="clear"> 
								<span class="h3 block m-t-xs"><strong><?=$tponum?></strong></span> 
								<small class="text-muted text-sm">平台套题数目</small> 
							</a> 
						</div>
					</section>
				</div>	
				<div class="col-lg-3">
					<section class="panel panel-default">
						<div class="panel-body">
							<span class="fa-stack fa-2x pull-left m-r-sm"> 
								<i class="fa fa-circle fa-stack-2x text-warning dker"></i>
								<i class="fa fa-map fa-stack-1x text-white"></i> 
							</span> 
							<a class="clear"> 
								<span class="h3 block m-t-xs"><strong><?=$totaltime?></strong></span> 
								<small class="text-muted text-sm">总考试时间(H)</small> 
							</a> 
						</div>
					</section>
				</div>							
			</div>

			<!-- charts -->
			<div class="row">
				<div class="col-lg-12">
					<section class="panel panel-default">
						<div class="panel-body chart-default-panel" id="line-chart"></div>
					</section>
				</div>
			</div>

			<!-- pie and map -->
			<div class="row">
				<div class="col-lg-4">
					<section class="panel panel-default">
						<div class="text-center wrapper bg-white lt">
							<div class="piechart-panel" id="pie-chart"></div>
						</div>
						<ul class="list-group no-radius list-tpo">
						</ul>
					</section>
				</div>		
				<div class="col-lg-8">
					<section class="panel panel-default">
						<div class="panel-body mapchart-panel" id="map-chart"></div>
					</section>
				</div>						
			</div>        
		</section>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
</section>
<?php include("footer.php"); ?>
<script src="/res/js/charts/sparkline/jquery.sparkline.min.js"></script>
<script src="/res/js/echarts/echarts.min.js"></script> 
<script src="/res/js/echarts/china.js"></script> 
<script src="/res/js/script/dashboarts.js"></script> 
<script type="text/javascript">
var line_chart;
G.set('nav_name', 'ds');
$(function(){
	line_chart = echarts.init(document.getElementById('line-chart'), 'infographic');
	pie_chart = echarts.init(document.getElementById('pie-chart'), 'infographic');
	map_chart = echarts.init(document.getElementById('map-chart'), 'infographic');
	

	$.post('/mkadc/datafactory/getchartsdata',  function (data){
		if(data.state == "failed"){
			showTipMessageDialog (data.reson);
			return ;
		}
		map_chart.setOption(getMapChartsOptions(data.location));
		pie_chart.setOption(getPieChartsOptions(data.tpo));	
		line_chart.setOption(getLineChartsOptions(data.exam));
		
		for(let i =0; i< data.tpo.length && i<3; i++){
			$('.list-tpo').append('<li class="list-group-item"><span class="pull-right">'+data.tpo[i].value+'</span><span class="label bg-primary m-r-sm">'+(i+1)+'</span>'+data.tpo[i].name+'</li>');
		}
	}, "json");
	
	
});

</script>
</body>
</html>