/**
 * this file is common javascript
 * used for all plat
 * made by maxranje 
 */

if(typeof(zy) != 'undefined'){
	alert('Predefined variables already exist, please check...');
}
zy = new Object();
G = new Map ();

zy.submit_form_action = function (uri, map){
	try{
		let form = $('<form action="'+uri+'" method="post"></form>');
		map.forEach(function (value, key, map){
			form.append('<input name="'+ key +'" value="'+value+'">');
		});
		form.appendTo(document.body).submit();
	}
	catch(err){
		showTipMsgDialog ('Error: system error, please try agine');
	}
}

zy.send_sync_ajax = function (uri, data, callback) {
	$.ajax( { url:uri, data:data, type:'post', async:false, cache:false, 
		dataType:'json', success:callback, error: function (e){
			alert("Error: system error, please try agine");
		}
	});
}


/**
 *  arguments :
 *  0: table dom
 *  1: url
 *  2: column
 *  3: fit
 *  4: queryparams
 */
function createTable (){
	if(arguments[0] == undefined){
		showTipMsgDialog ("系统列表异常");
	}
	arguments[0].datagrid({
		url:arguments[1],
		pagination:true,
		fitColumns:true,
		singleSelect:true,
		striped:true,
		idField:'id',
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
function showTipMessageDialog(msg, state="failed"){
	if(state == "failed"){
		msg = "<span class='font-bold text-danger'>"+msg+"</span>";
	}else{
		msg = "<span class='font-bold text-info'>"+msg+"</span>";
	}
	$('#tip-msg .dialog-info').html(msg);
	$('#tip-msg').modal('show');
}