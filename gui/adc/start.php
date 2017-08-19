<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('top.php');
?>
<section id="content">
	<section class="vbox text-dark">
		<header class="header bg-white b-b clearfix">
			<div class="row m-t-sm">
				<div class="col-sm-6 m-b-xs"><button type="button" class="btn btn-sm btn-default btn-startexam" title="Start"><i class="fa fa-check m-r-sm"></i>开始考试</button></div>
				<div class="col-sm-2 m-b-xs infomsg l-h-2x font-bold"></div>
			</div>
		</header>
		<section class="scrollable wrapper">    
			<div class="panel panel-default fadeInRight animated" data-ride="animated" data-animation="fadeInRight" data-delay="500">
				<div class="panel-body">
					<h5>考生信息录入</h5>
					<section class="m-t-md ">
						<table id="dg" class="easyui-datagrid" data-options="url:'/mkadc/datafactory/getunmockstudent', singleSelect: true, toolbar: '#tb', onDblClickCell: onDblClickCell,pagination:true,
							fitColumns:true,striped:true,idField:'id',pageList:[30,50,100],pageSize:50,nowrap: true,scrollbarSize:0">
							<thead>
								<tr>
									<th data-options="field:'id', title:'ID', align:'center', hidden:true">ID</th>
									<th data-options="field:'name',width:50, align:'center',editor:{type:'textbox',options:{required:true}}">姓名</th>
									<th data-options="field:'sex',width:50,align:'center',editor:{type:'combobox',options:{required:true,
										data:[{'tt':'F', value:'女'}, {'tt':'M', value:'男'}], valueField:'value', textField:'value'}}">性别</th>
									<th data-options="field:'age',width:50,align:'center',editor:{type:'numberbox',options:{precision:0}}">年龄</th>
									<th data-options="field:'school', width:50,align:'center',editor:'textbox'">学校</th>
									<th data-options="field:'major', width:50,align:'center',editor:'textbox'">专业</th>
									<th data-options="field:'class', width:50,align:'center',editor:'textbox'">班级</th>
									<th data-options="field:'phone', width:50, align:'center',editor:{type:'numberbox',options:{required:true}}">手机号</th>
									<th data-options="field:'email',width:40, align:'center',editor:'textbox'">Email</th>
								</tr>
							</thead>
						</table>									
					</section>
				</div>
			</div>				
			<div class="m-t-lg panel panel-default fadeInRight animated" data-ride="animated" data-animation="fadeInRight" data-delay="500">
				<div class="panel-body">
					<h5 class="">模考试题选择</h5>
					<section class="m-t-md clearfix">
						<ul class="ex-top">
							<?php
							foreach ($tpo as $row) {
								echo '<li class="wrapper-sm padder" data-active="0" data-tid="'.$row['tid'].'">';
								echo '<h5 class="text-info dker">'.$row['tpo_name'].'</h5>';
								echo '<p class="text-muted h6">应用'.$row['tpo_usedcount'].'次</p><div class="shadow"></div></li>';								
							}
							?>
						</ul>
					</section>
				</div>
			</div>	
			<div class="m-t-lg panel panel-default fadeInRight animated" data-ride="animated" data-animation="fadeInRight" data-delay="500">
				<div class="panel-body">
					<h5>考试城市</h5>
					<section class="m-t">
						<input type="text" name="place" class="form-control input-sm" placeholder="默认北京">
					</section>
					<h5 class="m-t-lg">监考教师</h5>
					<section class="m-t">
						<input type="text" name="teacher" class="form-control input-sm" placeholder="默认 admin">
					</section>					
				</div>
			</div>		
			<div id="tb" style="height:auto; padding: 10px 10px">
				<button class="btn btn-default btn-sm btn-add m-r-sm"><i class="fa fa-plus m-r"></i>添加考生</button>
				<button class="btn btn-default btn-sm btn-remove m-r-sm"><i class="fa fa-remove m-r"></i>删除考生</button>
				<button class="btn btn-default btn-sm btn-save m-r-sm"><i class="fa fa-save m-r"></i>保存信息</button>
				<button class="btn btn-default btn-sm btn-search m-r-sm"><i class="fa fa-search m-r"></i>搜索历史</button>
			</div>
			<div class="modal fade" id="start">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"><h4 class="modal-title"> 开始考试</h4></div>	
						<div class="modal-body">
							<p class="text-center wrapper-lg dialog-info m-t-n font-bold text-danger">是否确定开始考试, 一旦进行考试数据开始更新.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-default" data-dismiss="modal">取消</button>
							<button type="button" class="btn btn-default btn-info btn-start">考试</button>
						</div>						
					</div>
				</div>
			</div>
			<div class="modal fade" id="search" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<p class="modal-title col-lg-7 h4">历史考生检索</p>
							<p class="modal-title col-lg-4">
								<div class="input-group">
									<input type="text" class="input-sm form-control searchbox" placeholder="搜索学生姓名">		
									<span class="input-group-btn"><button class="btn btn-sm btn-default btn-search-student" type="button"><i class="fa fa-search"></i></button></span> 	
								</div>
							</p>
							<div class="clearfix"></div>
						</div>
						<div class="modal-body">
							<section class="panel panel-default m-l-n-md m-r-n-md m-b-none m-t-n-md" style="height: 400px;">
								<table id="student" style="height:100%; width: 100%"></table>
							</section>
						</div>
					</div>
				</div>
			</div>																	
		</section>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
</section>

<?php include('footer.php'); ?>
<link rel="stylesheet" href="/res/js/esgrid/themes/bootstrap/easyui.css" type="text/css"/>
<link rel="stylesheet" href="/res/js/esgrid/themes/icon.css" type="text/css" >
<script src="/res/js/esgrid/jquery.easyui.min.js"></script>
<script class="text/javascript">
G.set('nav_name', 'es');
var tid, saveflag = true;
$(function (){
	// tpo show
	$('.ex-top>li').mouseover(function (){
		$(this).children('.shadow').css('display','block');
	});
	$('.ex-top>li').mouseout(function (){
		if($(this).data('active') != '1'){
			$(this).children('.shadow').css('display','none');
		}
	});

	$('.ex-top>li').on('click', function (){
		$('.ex-top>li').data('active', '0').children('.shadow').css('display','none');
		$(this).data('active', '1');
		tid = $(this).data('tid');
	});
	
	//start exam
	$('.btn-startexam').on('click',function (){
		$('#start').modal('show');
	});

	$('.btn-start').on('click',function (){
		$('#start').modal('hide');
		var rows = $("#dg").datagrid("getRows");
		let str = ''; 
		for (let i=0; i < rows.length; i++) {
			str += rows[i].id + ",";
		}
		str = str.substring(0,str.length-1);
		let teacher = $('input[name=teacher]').val();
		let place = $('input[name=place]').val();
		$.post ('/mkadc/datafactory/startexam', {place:place, teacher:teacher, id:tid, idstr:str}, 
			function (data){
				if(data.state == "success"){
					window.location.reload(true);
				}else {
					showTipMessageDialog (data.reson, data.state);
				}
			},
		"json");
	});

	$('.btn-search-student').on('click',function (){
		let sc = $('.searchbox').val();
		$('#student').datagrid('load',{sc: $('.searchbox').val()});
	});	

	$('.btn-search').on('click', function (){
		$('#search').modal('show');
		setTimeout(function (){ initTables();}, 500);
	});


	$('.btn-add').on('click', function (){
		if (endEditing() && saveflag){
			$('#dg').datagrid('appendRow',{state:'0'});
			editIndex = $('#dg').datagrid('getRows').length-1;
			$('#dg').datagrid('selectRow', editIndex).datagrid('beginEdit', editIndex);
			saveflag = false;
		}
	});

	$('.btn-save').on('click', function (){
		$('#dg').datagrid('acceptChanges');
		let row = $('#dg').datagrid('getSelected');
		$.post('/mkadc/datafactory/changestudent', row, function (data){
			if(data.state == "failed"){
				showTipMessageDialog (data.reson, data.state);
				return;
			}
			row.id = data.id;
		},'json');
		$('#dg').datagrid('clearSelections');
		saveflag = true;
	});

	$('.btn-remove').on('click', function (){
		let row = $('#dg').datagrid('getSelected');
		console.log(row.id);
		if(typeof(row.id) == "undefined"){
			showTipMessageDialog ("由于该条记录未保存，所以请通过刷新的方式清除");
			return ;
		}
		$.post('/mkadc/datafactory/removestudent', {id:row.id}, function (data){
			if(data.state == "failed"){
				showTipMessageDialog (data.reson, data.state);
				return;
			}
			$('#dg').datagrid('deleteRow', $('#dg').datagrid('getRowIndex', row));
		},'json');
	});
});

var editIndex = undefined;
function endEditing(){
	if (editIndex == undefined){return true}
	if ($('#dg').datagrid('validateRow', editIndex)){
		$('#dg').datagrid('endEdit', editIndex);
		editIndex = undefined;
		return true;
	} else {
		return false;
	}
}

function onDblClickCell(index, field){
	if (endEditing()){
		$('#dg').datagrid('selectRow', index)
				.datagrid('beginEdit', index);
		var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
		if (ed){
			($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
		}
		editIndex = index;
	} else {
		setTimeout(function(){
			$('#dg').datagrid('selectRow', editIndex);
		},0);
	}
}



function initTables () {
	var ecolumns=[
		{field:'id', title:'ID', align:'center', hidden:true},
		{field:'name', title:'姓名',width:50, align:'center', formatter:function (value, row, index){
			return '<a onclick="select_student('+row.id+')" href="javascript:;" class="text-info">'+value+'</a>';
		}},
		{field:'sex', title:'性别', width:50,align:'center'},
		{field:'school', title:'学校', width:50,align:'center'},
		{field:'phone', title:'手机号',width:50, align:'center'}
	];
	createTable($('#student'), '/mkadc/datafactory/gethistorystudent', ecolumns, false, {});
}

function select_student (id){
	var rows = $("#dg").datagrid("getRows"); 
	for (let i=0; i < rows.length; i++) {
		if(rows[i].id == id){
			alert('考生信息已添加, 请选择其他考试人员');
			return;
		}
	}

	$.post('/mkadc/datafactory/gethistorystudent', {id:id, page:1, rows:50}, function (data){
		$('#dg').datagrid('appendRow',data.rows[0]);	
	}, "json");
}
</script>
</body>
</html>