function sec2Time(time){
	let hours = 0, minutes=0, seconds=0; 
	time = parseInt(time);
	if(time >= 3600){  
		hours = Math.floor(time/3600);
		if(hours < 10){
			hours = "0" + hours;
		}  
		time = (time%3600);  
	}  
	if(time >= 60){  
		minutes = Math.floor(time/60);  
		if(minutes < 10){
			minutes = "0" + minutes;
		} 
		time = (time%60);  
	}  
	seconds = Math.floor(time);  
	if(seconds < 10){
		seconds = "0" + seconds;
	} 

	if(hours == 0){
		if(minutes == 0){
			minutes = '00';
		}
		t =  minutes + ":" + seconds;  
	}else{
		t =  hours + ":" + minutes + ":" + seconds;  
	}
	return t;   
} 


$(function (){
	$('.btn-time').on('click', function (){
		if($('.top-time').hasClass('d-n')){
			$('.top-time').removeClass('d-n');
		}else{
			$('.top-time').addClass('d-n');
		}
	});
	$('#error-msg').modal({backdrop:'static', keyboard:false, show:false});
});

function timeinterval(){
	let systime = parseInt($('input[name=starttime]').val());
	$('.top-time').html(sec2Time (systime));
	$('input[name=endtime]').val(systime);

	var ti = setInterval(function(){
		systime--;
		$('.top-time').html(sec2Time(systime));
		$('input[name=endtime]').val(systime);
		if (systime == 0){
			clearInterval(ti);
			timeover();
		}
	}, 1000);
}

