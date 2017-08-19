
$(function (){

	try {
		// webkit shim
		window.AudioContext = window.AudioContext || window.webkitAudioContext;	
		navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
		window.URL = window.URL || window.webkitURL;
		audio_context = new AudioContext;

	} catch (e) {	
		alert('No web audio support in this browser!');
	}

	navigator.getUserMedia({audio: true}, startMediaStream, errorMediaStream);
});

/**
 * media stream code
 */
var mediaRecorder
function startMediaStream (stream) {
	mediaRecorder = new MediaStreamRecorder(stream);
	mediaRecorder.mimeType = 'audio/wav';
	mediaRecorder.ondataavailable = endrecorderevent;
}

function errorMediaStream (e) {
	console.err(e);
	alert('error');
}


// var audio_context;
// var recorder;
// function startUserMedia(stream) {
// 	var input = audio_context.createMediaStreamSource(stream);

// 	recorder = new Recorder(input);
// 	status = true;
// }
// function getlink() {
// 	recorder && recorder.exportWAV(function(blob) {
// 		au.src =  URL.createObjectURL(blob); 
// 	});
// }
