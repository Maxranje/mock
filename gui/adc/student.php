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
								<button class="btn btn-sm btn-default m-r-sm btn-unscroe" >未评分考生列表</button>
								<button class="btn btn-sm btn-default m-r-sm btn-lastmock" >最近一次考试考生列表</button>
							</div>
						</div>
						<div class="col-sm-4 m-b-xs">
							<div class="input-group">
								<input type="text" class="input-sm form-control searchbox" placeholder="搜索学生姓名">		
								<span class="input-group-btn"><button class="btn btn-sm btn-default btn-search" type="button"><i class="fa fa-search"></i></button></span> 	
							</div>
						</div>
					</div>
				</header>
				
				<section class="scrollable wrapper" id="tablepanel">
					<table class="table table-striped " id="table">
					</table>
				</section>
			</section>
			<div class="modal fade" id="report">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"><h4 class="modal-title"> 导出报表</h4></div>	
						<div class="modal-body">
							<p class="text-center wrapper-lg dialog-info m-t-n font-bold text-danger">报表生成中，生成路径为系统目录 / 文档 / mockreport</p>
							<p class="text-center wrapper-lg dialog-info m-t-n font-bold text-danger">由于生成报表耗时较长，请耐心等待并且切勿关闭浏览器</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-default" data-dismiss="modal">取消</button>
							<button type="button" class="btn btn-default btn-info btn-start">考试</button>
						</div>						
					</div>
				</div>
			</div>
		</aside>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
</section>
<?php include ('footer.php') ?>
<link rel="stylesheet" href="/res/js/esgrid/themes/bootstrap/easyui.css" type="text/css" cache="false" />
<link rel="stylesheet" href="/res/js/esgrid/themes/icon.css" type="text/css" >
<script src="/res/js/esgrid/jquery.easyui.min.js"></script>
<script class="text/javascript">
G.set('nav_name', 'stun');
$(function (){

	$('.btn-search').on('click', function (){
		var sc = $('.searchbox').val();
		$('#table').treegrid('load', {sc:sc});
	});

	$('.btn-unscroe').on("click", function (){
		$('#tablepanel').html('<table class="table table-striped " id="table"></table>');
		initunscoreTables ();
		$(this).addClass('active');
		$('.btn-lastmock').removeClass('active');
	});

	$('.btn-lastmock').on("click", function (){
		$('#tablepanel').html('<table class="table table-striped " id="table"></table>');
		initlastmockTables ();
		$(this).addClass('active');
		$('.btn-unscroe').removeClass('active');		
	});	

	initTables();
});

function initTables (){
	var columns=[
		{field:'sid', title:'ID', align:'center', hidden:true},
		{field:'name', title:'姓名', width:20, align:'left'},
		{field:'tponame', title:'模考试题', width:30,align:'center'},
		{field:'location', title:'模考地点',width:30, align:'center'},
		{field:'time', title:'模考时间',width:30, align:'center'},
		{field:'score', title:'分数',width:20, align:'center'},
		{field:'smid', title:'ID', align:'center', hidden:true},
		{field:'statement', title:'', hidden:true, align:'center'},		
		{field:'options', title:'更多',width:20, align:'center'}
	];
	createStudentTables($('#table'), '/mkadc/datafactory/getstudentmanage', columns, true);	
}

function initunscoreTables (){
	var columns=[
		{field:'smid', title:'ID', align:'center', hidden:true},
		{field:'name', title:'姓名', width:20, align:'left'},
		{field:'location', title:'模考地点',width:30, align:'center'},
		{field:'tponame', title:'模考试题', width:30,align:'center'},
		{field:'time', title:'模考时间',width:30, align:'center'},	
		{field:'statement', title:'状态', width:20, align:'center'},	
		{field:'options', title:'更多',width:20, align:'center'}
	];
	createStudentTables($('#table'), '/mkadc/datafactory/getstudentunscorelist', columns, true);		
}

function initlastmockTables (){
	var columns=[
		{field:'smid', title:'ID', align:'center', hidden:true},
		{field:'name', title:'姓名', width:20, align:'left'},
		{field:'location', title:'模考地点',width:30, align:'center'},
		{field:'tponame', title:'模考试题', width:30,align:'center'},
		{field:'time', title:'模考时间',width:30, align:'center'},	
		{field:'statement', title:'状态', width:20, align:'center'},	
		{field:'options', title:'更多',width:20, align:'center'}
	];
	createStudentTables($('#table'), '/mkadc/datafactory/getstudentlastmocklist', columns, true);		
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
		idField:'sid',
		treeField:'name',
		rownumbers: true,
		pageList:[30,50,100],
		pageSize:50,
		fit: arguments[3], 
		queryParams:arguments[4],
		nowrap: true,
		scrollbarSize:0,
		columns:[arguments[2]]	
	});
	$('.datagrid-pager.pagination').pagination({
		displayMsg:'数据从 {from} 到 {to}, 供 {total} 条数据'
	})	
}
</script>
</body>
</html>