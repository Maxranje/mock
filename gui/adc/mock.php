<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include ("top.php");
?>
<section id="content">
	<section class="hbox stretch">
		<aside>
			<section class="vbox">
				<header class="header bg-white b-b clearfix">
					<div class="row m-t-sm">
						<div class="col-sm-8 m-b-xs">
							<div class="btn-group">		
								<button class="btn btn-sm btn-default m-r-sm refresh" ><i class="fa fa-refresh"></i></button>
							</div>
							<div class="btn-group">
								<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">分类展示 <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="javascript:;" onclick="changetable('tpo')">按模考试题</a></li>
									<li class="divider"></li>
									<li><a href="javascript:;" onclick="changetable('location')">按考场城市</a></li>
								</ul>
							</div>							
						</div>
						<div class="col-sm-4 m-b-xs">
							<div class="input-group">
								<input type="text" class="input-sm form-control searchbox" placeholder="搜过套题名称">		
								<span class="input-group-btn"><button class="btn btn-sm btn-default btn-search" type="button"><i class="fa fa-search"></i></button></span> 	
							</div>
						</div>
					</div>
				</header>
				
				<section class="scrollable wrapper" id="tablepanel">
					<table class="table table-striped " id="table"></table>
				</section>

				<div class="modal fade" id="charts" aria-hidden="true" >
					<div class="modal-dialog" style="width: 800px; height: 500px;">
						<div class="modal-content">
							<div class="modal-header"><p class="modal-title h5">模考学生分数指标图</p></div>
							<div class="modal-body">
								<section class="panel panel-default m-l-n-md m-r-n-md m-b-none m-t-n-md" id="linechart" style="height: 500px; width: 774px; padding: 20px 0 10px">
									
								</section>
							</div>
						</div>
					</div>
				</div>	
				<div class="modal fade" id="score" aria-hidden="true" >
					<div class="modal-dialog">
						<div class="modal-content" style="border: 0px;">
							<section class="panel panel-default">
								<header class="panel-heading bg-danger lt no-border">
									<div class="clearfix"><div class="clear">
										<div class="h3 m-t-xs m-b-xs text-white"><span class="mocklocation"></span><i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i> </div>
										<small class="text-muted">平均分数</small> </div>
									</div>
								</header>
								<div class="list-group no-radius alt"> 
									<a class="list-group-item" href="#"> <span class="badge bg-success rs">0</span> <i class="fa fa-comment icon-muted m-r-xs"></i> 阅读平均分 </a> 
									<a class="list-group-item" href="#"> <span class="badge bg-success ls">0</span> <i class="fa fa-comment icon-muted m-r-xs"></i> 听力平均分 </a> 
									<a class="list-group-item" href="#"> <span class="badge bg-success ss">0</span> <i class="fa fa-comment icon-muted m-r-xs"></i> 口语平均分 </a> 
									<a class="list-group-item" href="#"> <span class="badge bg-success ws">0</span> <i class="fa fa-comment icon-muted m-r-xs"></i> 写作平均分 </a> 
								</div>
							</section>						
						</div>
					</div>
				</div>					
			</section>
		</aside>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
</section>
<?php include ('footer.php') ?>
<link rel="stylesheet" href="/res/js/esgrid/themes/bootstrap/easyui.css" type="text/css"/>
<link rel="stylesheet" href="/res/js/esgrid/themes/icon.css" type="text/css" >
<script src="/res/js/esgrid/jquery.easyui.min.js"></script>
<script src="/res/js/echarts/echarts.min.js"></script> 
<script class="text/javascript">
G.set('nav_name', 'mock');
var linechart ;
$(function (){

	$('.btn-search').on('click', function (){
		var sc = $('.searchbox').val();
		$('#table').treegrid('load', {sc:sc});
	});
	linechart = echarts.init(document.getElementById('linechart'), 'infographic');
	linechart.setOption(getMockChartsOptions([], []));	
	initLocationTables();
});

function changetable(type){
	$('#tablepanel').html('<table class="table table-striped " id="table"></table>');
	if(type == 'tpo'){
		initTpoTables();	
	}else {
		initLocationTables();
	}
}


function initLocationTables (){
	var columns=[
		{field:'id', title:'ID', align:'center', hidden:true,width:30},
		{field:'mid', title:'ID', align:'center', hidden:true,width:30},
		{field:'location', title:'模考地点',width:110, align:'left'},
		{field:'tponame', title:'模考试题', width:30,align:'center'},
		{field:'time', title:'模考时间',width:30, align:'center'},
		{field:'teacher', title:'监考教师',width:30, align:'center'},
		{field:'count', title:'考试人数',width:30, align:'center'},
		{field:'score', title:'平均分', width:20,align:'center'},
		{field:'options', title:'更多', width:20,align:'center'}
	];
	createStudentTables($('#table'), '/mkadc/datafactory/getmockbylocation', columns, true,'location', 'id');	
}

function initTpoTables (){
	var columns=[
		{field:'tid', title:'ID', align:'center', hidden:true},
		{field:'mid', title:'ID', align:'center', hidden:true},
		{field:'tponame', title:'模考试题', width:110,align:'left'},
		{field:'location', title:'模考地点',width:30, align:'center'},
		{field:'time', title:'模考时间',width:30, align:'center'},
		{field:'teacher', title:'监考教师',width:30, align:'center'},
		{field:'count', title:'考试人数',width:30, align:'center'},
		{field:'score', title:'平均分', width:20,align:'center'},
		{field:'options', title:'更多', width:20,align:'center'}
	];
	createStudentTables($('#table'), '/mkadc/datafactory/getmockbytpo', columns, true,'tponame','tid');	
}

function createStudentTables (){
	if(arguments[0] == undefined){
		showTipMsgDialog ("系统列表异常, 请刷新重试");
	}
	arguments[0].treegrid({
		url:arguments[1],
		pagination:true,
		fitColumns:true,
		striped:true,
		animate:true,
		idField:arguments[5],
		treeField:arguments[4],
		rownumbers: true,
		pageList:[30,50,100],
		pageSize:50,
		fit: arguments[3], 
		nowrap: true,
		scrollbarSize:0,
		columns:[arguments[2]]	
	});
	$('.datagrid-pager.pagination').pagination({
		displayMsg:'数据从 {from} 到 {to}, 供 {total} 条数据'
	})	
}

function scorelist (id){
	$.post('/mkadc/datafactory/getstudentavgscore', {mid:id}, function (data){
		console.log(data);
		if(data.state == "success"){
			$('#score .mocklocation').html(data.location);
			$('.ls').html(data.ls+" 分");
			$('.ws').html(data.ws+" 分");
			$('.rs').html(data.rs+" 分");
			$('.ss').html(data.ss+" 分");
			$('#score').modal('show');
		}else{
			showTipMessageDialog (data.reson, data.state);
		}
	}, "json");
}

function charts (id){
	$.post('/mkadc/datafactory/getstudentscore', {id:id}, function (data){
		if(data.state == "failed"){
			showTipMessageDialog (data.reson, data.state);
			return ;
		}
		var x = [];
		var y = [];
		for (let i = 0; i<data.student.length; i++){
			x[i] = data.student[i].name;
			y[i] = data.student[i].score;
		}
		console.log(x, y);
		linechart.setOption({ xAxis:{ data:x }, series:[ { name:'学生分数', data:y } ]});
		$('#charts').modal('show');
	},'json');
}

function getMockChartsOptions (x, y) {
	return option = {
		title: { text: 'STATISTICS' },
		grid: {	left: '2%', right: '5%', bottom: '12%', top:'15%',  containLabel: true},
		legend: { data:['本次考试考生分数分布图'] },
		toolbox: {show: true, feature: { magicType: {type: ['line', 'bar']}, } },
	    dataZoom: [ { show: true, realtime: true, }, { type: 'inside', realtime: true, } ],
		tooltip:{ show:true, formatter: '{a}<br/> {b} : {c} 分' },
		xAxis:  { type: 'category', boundaryGap: false, data: x },
		yAxis: [ 
			{ 
			name:'学生分数(分)', type: 'value', position:'left', 
			splitArea:{show:true,areaStyle:{color:['#fff','#F2F2F2']}},
			axisLabel: {formatter: '{value} 分'},
			max:'150'
			}
			//{ name:'累计(人)', type:'value', position:'right' }
		],
		series: [
			{
				name:'学生分数',
				type:'line',
				lineStyle:{normal :{ width:[2],shadowColor: 'rgba(0, 0, 0, 0.2)',shadowBlur: 4}},
				data:y,
				markLine: {data: [{type: 'average', name: '平均值'}]}
			}
		]
	};  
}

</script>
</body>
</html>