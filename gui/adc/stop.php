<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include ('top.php');
?>

<section id="content">
	<section class="vbox">
		<header class="header bg-white b-b clearfix">
			<div class="row m-t-sm">
				<div class="col-sm-8 m-b-xs">
					<button type="button" class="btn btn-sm btn-default " title="Refresh"><i class="fa fa-refresh"></i></button>
					<button type="button" class="btn btn-sm btn-danger btn-shutdownall m-l-sm" title="结束考试"><i class="fa fa-stop m-r-sm"></i> 停止考试</button>
					<a href="/mkadc/monitor" class="btn btn-sm btn-warning m-l-sm" title="实时数据监控"><i class="fa fa-stop m-r-sm"></i> 模考监控</a>
				</div>
				<div class="col-sm-2 m-b-xs infomsg l-h-2x font-bold"></div>
			</div>
		</header>
		<section class="scrollable wrapper  fadeInRight animated"  data-ride="animated" data-animation="fadeInRight" data-delay="500">
			<table class="easyui-datagrid table table-striped" id="table">
			</table>
		</section>	
		<div class="modal fade" id="shutdown">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header"><h4 class="modal-title"> 禁止学生考试</h4></div>	
					<div class="modal-body text-center">
						<div class="stopstudent d-n">
							<p class="h5 text-danger m-t">是否确定禁止该学生考试</p>
							<p class="h5 text-danger m-t">非紧急情况请勿禁止或开启，可能后影响数据录取</p>					
						</div>
						<div class="startstudent d-n">
							<p class="h5 text-danger m-t">是否确定允许该学生考试</p>
							<p class="h5 text-danger m-t">非紧急情况请勿禁止或开启，可能后影响数据录取</p>							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-default btn-danger btn-shutdown">确定</button>
					</div>						
				</div>
			</div>
		</div>
		<div class="modal fade" id="shutdownall">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header"><h4 class="modal-title"> 停止考试</h4></div>	
					<div class="modal-body text-center">
						<p class="text-danger m-t h5">是否确定结束考试, 一旦停止无法恢复, 且所有学生交卷.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-default btn-danger btn-shutdownall-ok">确定</button>
					</div>						
				</div>
			</div>
		</div>				
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
</section>
<?php include ('footer.php') ?>
<link rel="stylesheet" href="/res/js/esgrid/themes/bootstrap/easyui.css" type="text/css"/>
<link rel="stylesheet" href="/res/js/esgrid/themes/icon.css" type="text/css" >
<script src="/res/js/esgrid/jquery.easyui.min.js"></script>
<script class="text/javascript">
G.set('nav_name', 'es');
var shutdownmarker;
$(function (){

	$(document).on('click', '.student_shutdown', function(){
		shutdownmarker = $(this);
		if(shutdownmarker.data('out') == "live"){
			$('.startstudent').removeClass('d-n');
		}else {
			$('.stopstudent').removeClass('d-n');
		}
		$('#shutdown').modal ('show');
	});

	$('.btn-shutdown').on('click', function (){
		let id = shutdownmarker.data('id');
		let state = shutdownmarker.data('out');
		$('#shutdown').modal ('hide');
		$('.startstudent').addClass('d-n');
		$('.stopstudent').addClass('d-n');
		$.post('/mkadc/datafactory/shutdown', {id:id, state:state}, function (data){
			if (data.state == "failed"){
				showTipMessageDialog(data.reson, data.state);
				return;
			}
			if(state == 'shutdown'){
				shutdownmarker.data('out', "live").attr('title', '启动考试');
				shutdownmarker.html ('<i class="fa fa-check text-success"></i>');
			}else{
				shutdownmarker.data('out', "shutdown").attr('title', '停止考试');
				shutdownmarker.html ('<i class="fa fa-sign-out text-danger"></i>');
			}
		}, "json");
	});

	// 关闭全部
	$(document).on('click', '.btn-shutdownall', function(){
		$('#shutdownall').modal('show');
	});

	$('.btn-shutdownall-ok').on('click', function (){
		$.post('/mkadc/datafactory/shutdownall',  function (data){
			if(data.state == "failed"){
				showTipMessageDialog (data.reson,data.state);
			}else{
				window.location.reload(true);
			}
		}, "json");
	});

	initTables ();
});
function initTables () {
	var columns=[
		{field:'id', title:'ID', align:'center', hidden:true},
		{field:'state', title:'state', align:'center', hidden:true},
		{field:'name', title:'姓名', width:30, align:'center'},
		{field:'sex', title:'性别', width:15, align:'center'},
		{field:'age', title:'年龄', width:15, align:'center'},
		{field:'school', title:'学校', width:40,align:'center'},
		{field:'specialty', title:'专业',width:20, align:'center'},
		{field:'class', title:'年级',width:20, align:'center'},
		{field:'more', title:'更多',width:10, align:'center', formatter:function(value, row, index){
			let a = '<a class="student_shutdown th-sortable" data-id="'+row.id+'"';
			if(row.state == "0"){
				a+= ' data-out="live" title="启动考试"><i class="fa fa-check text-success"></i></a>';	
			}else{
				a+= ' data-out="shutdown" title="停止考试"><i class="fa fa-sign-out text-danger"></i></a>';
			}
			return a ;
		}},
	];
	createTable($('#table'), '/mkadc/datafactory/getexamingstudent', columns, true, {});
}
</script>
</body>
</html>