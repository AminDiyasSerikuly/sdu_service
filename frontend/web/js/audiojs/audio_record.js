var sentences = $sentences;
$('#text-self').text(sentences[Object.keys(sentences)[0]]);
console.log(sentences);
getAudios();
var hide_current_audio = $('#current_audio_card');
hide_current_audio.hide();
URL = window.URL || window.webkitURL;
var gumStream;
var rec;
var input;
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext;


$('#img-start').click(function() {
    var  clicks =  $(this).data('clicks');
    if(typeof clicks === 'undefined'){
        clicks = !clicks;
    }
    if(clicks){
        startRecording();
        $(this).attr("src" , "/img/system_image/recording.gif");
    }
    else{
        stopRecording();
        $(this).attr("src" , "/img/system_image/microphone.png");
    }
    $(this).data('clicks' , !clicks);
});
function startRecording() {
    console.log("recordButton clicked");
    var constraints = {audio: true, video: false};
    navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
        console.log("getUserMedia() success, stream created, initializing Recorder.js ...");
        audioContext = new AudioContext();
        // document.getElementById("formats").innerHTML = "Format: 1 channel pcm @ " + audioContext.sampleRate / 1000 + "kHz"
        gumStream = stream;
        input = audioContext.createMediaStreamSource(stream);
        rec = new Recorder(input, {numChannels: 1});
        rec.record();
        console.log("Recording started");
    })
        .catch(function (err) {
            $('#img-start').prop('disable' , true);
        });
}

function stopRecording() {
    console.log("stopButton clicked");
    rec.stop();
    rec.exportWAV(showAudio);
    gumStream.getAudioTracks()[0].stop();
    rec.exportWAV(showAudio);
}
function showAudio(blob){
    var url = URL.createObjectURL(blob);
    var audioShow = document.getElementById('currentAudio');
    audioShow.src = url;
    hide_current_audio.show();
}
function saveInServer(blob){
    var url = URL.createObjectURL(blob);
    var sub_id = Object.keys(sentences)[0];
    var book_id = $("#book_id").val();
    var filename = new Date().toISOString();
    var formData = new FormData();
    formData.append("audio_data", blob);
    formData.append('name' , 'uploadAudio');
    formData.append('sub_id', sub_id );
    formData.append('book_id', book_id);
    $.ajax({
        url: "/audio/is-ajax",
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            getAudios();
        }
    });
}
function getAudios(){
    var formData = new FormData();
    formData.append('name' , 'getAudio');
    formData.append('book_id' , $("#book_id").val());
    $.ajax({
        url: "/audio/is-ajax",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data.audioList);
            var dataList =  (data.audioList);
            jQuery.each(dataList , function(key,value){
                var audioValue = document.getElementById("audioValue-" + key);
                var userValue = document.getElementById("userValue-" + key);
                var textValue = $("#textValue-" + key);
                var textValue2 = $("#textValue2-" + key);
                textValue.attr("style" , "background-color: lightgreen");
                textValue.attr("data-id" , "1");
                textValue2.removeClass('hidden');
                audioValue.src = value.audio_path;
                userValue.textContent = value.username;
            });
        }
    });
}
$('#right-button').click(function(){
    hide_current_audio.hide();
    var countSplittedText = $("#count_splitted_text").val();
    var rightButton = $('#right-button-value');
    var leftButton = $('#left-button-value');
    var startPoint = rightButton.val();

    try {
        rec.exportWAV(saveInServer)
    }
    catch (e) {
        alert('Чтобы перейти на следующий текст необходимо записать аудио на текущий');
    }
    startPoint = (Object.keys(sentences)[0]);
    var nextTextValue = $("#textValue-"+startPoint);
    var prevTextValue = $("#textValue-"+(parseInt(startPoint) - 1));
    var nextTextValueText = nextTextValue.text();
    nextTextValue.attr('style' , 'background-color:lightblue;');
    if($("#textValue-"+parseInt(startPoint) - 1).data("id") == 0){
        prevTextValue.attr('style' , 'background-color:grey;');
    }
    var textShowArea = $('#text-self');
    textShowArea.text(sentences[startPoint]);
    rightButton.val(parseInt(startPoint) + 1);
    leftButton.val(parseInt(startPoint) - 1);

});
$('#left-button').click(function(){
    hide_current_audio.hide();
    var leftButton = $('#left-button-value');
    var rightButton = $('#right-button-value');
    var startPoint = leftButton.val();
    var prevTextValue = $("#textValue-"+(parseInt(startPoint)));
    var nextTextValue = $("#textValue-"+(parseInt(startPoint) + 1));
    var prevTextValueText = prevTextValue.text();
    prevTextValue.attr('style' , 'background-color:lightgreen;');
    nextTextValue.attr('style' , 'background-color:grey;');
    var textShowArea = $('#text-self');
    textShowArea.text(prevTextValueText);
    leftButton.val(parseInt(startPoint) - 1);
    rightButton.val(parseInt(startPoint) + 1);
    console.log(prevTextValue);

});
