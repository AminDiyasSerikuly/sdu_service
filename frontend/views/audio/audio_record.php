<?php
/** @var string|array $sentences */

use common\models\User;

Yii::$app->cdn->get('font-awesome')->register();
$user = User::find()->where(['id' => Yii::$app->user->getId()])->one();

?>
<script src="/js/audiojs/audio.min.js">
</script>

<script>
    audiojs.events.ready(function () {
        audiojs.createAll();
    });
</script>
<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
<div class="card">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <strong><?= Yii::$app->session->getFlash('success'); ?></strong>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('danger')): ?>
        <div class="alert alert-danger">
            <strong><?= Yii::$app->session->getFlash('danger'); ?></strong>
        </div>
    <?php endif; ?>
    <?php if (count($sentences) != 0): ?>
        <div class="alert alert-warning">
            <strong>Для записи аудио нажмите на микрофон и записывайте аудио. <br>
                Для сохранение аудио и показа следующего текста нажмите на стрелку на право..</strong>
            <strong class="float-right">Осталось приложении: <?= count($sentences); ?></strong>
        </div>
    <?php endif; ?>
    <div class="card-header">
        <?php if (count($sentences) != 0): ?>
            <div class="pool">
                <div class="text-area text-center">
                    <p class="text-self" id="text-self" style="font-size: 130%;">
                    </p>
                </div>
                <hr>
                <div class="microphone_area text-center row">
                    <div class="col-sm-2 col-md-2">
                    </div>
                    <div class="microphone-area col-sm-8 col-md-8">
                        <img data-toggle="false" class="img-area" src="/img/system_image/microphone.png" alt=""
                             width="45" height="45"
                             id="img-start" style="border-radius: 50%;">
                        <div id="formats">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <i class="fa fa-arrow-right awesome-style" id="right-button"></i>
                        <input type="hidden" value="0" id="right-button-value">
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;" id="current_audio_card">
                    <div id="current_audio" class="audio col-8  offset-2">
                        <audio id="currentAudio" preload="metadata">
                        </audio>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<input type="hidden" value="<?= Yii::$app->request->get('id'); ?>" id="book_id">
<input type="hidden" value="<?= count($sentences) ?>" id="count_splitted_text">


<?php
$css = <<<CSS
   .card{
        width: auto;
        height: auto;
        border: none;
        /*border: 1px solid lightgray;*/
        /*border-radius: 3px;*/
        padding: 1rem;
    }
    .card-header{
        padding: 0;
        margin-bottom: 0;
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    .pool{
        width: 100%;
        min-height:550px;
        background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);
        padding: 18rem 0 4rem 0;
        border-radius: 3px ;
    }
    .text-area{
        padding: 1rem;

    }
    .mini-text-area{
        padding: 0.5rem;
        background: grey;
        color: white;
    }
    .text-self{
        font-size: 110%;
        font-weight: bold;
        font-family: 'Lato', sans-serif;
        color: white;
    }

    .text_audio_top{

    }
    .text_audio{
        padding: 10px;
        background-color: #008793;
        border-radius: 5px;
        margin-top: 1rem;
        cursor: pointer;
        z-index: auto;
    }
    .text_user{
        padding: 10px;
        /*background-color: #008793;*/
        border-radius: 5px;
        margin-top: 1rem;
        cursor: pointer;
        z-index: auto;
    }

    .img-area:hover{
        background-color: #a8eb12; border-radius: 50%; padding: 0.2rem;
        cursor: pointer;
    }
    .reading_text{
        font-size: 90%;
        font-weight: bold;
        padding-right: 0;
    }
    .checkbox_area{
        padding: 2px 7px 0 0;
    }
    .text_audio_top{
        /*padding: 1rem;*/
    }
    #reading_text_input{
        width: 100% !important;
    }
    .this-play{
        font-size: 170%;
        color: green;
    }
    .this-play-delete{
        color: red;
        font-size: 175%;
    }
    .awesome-style{
        font-size: 3rem;
        font-weight: lighter;
        color: lightgreen;
        cursor: pointer;
        width: 3rem;
        height: 3rem;
    }
     .awesome-style:hover{
        border-radius: 50%;
        background-color: #2b669a;
       
     }
    .card_provider{
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
      width: 100%;
    }
    
    .card_provider:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    
  
CSS;
$this->registerCss($css);
$sentences = json_encode($sentences);

Yii::$app->cdn->get('audio-record')->register();

$js = <<<JS
var sentences = $sentences;
var minimum  = Object.keys(sentences)[0];
var maximum = Object.keys(sentences).length;
var randomnumber = Math.floor(Math.random() * (maximum - 1));
var randomValue = Object.keys(sentences)[randomnumber];
$('#text-self').text(sentences[randomValue]);
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
    var sub_id = randomValue;
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
            // getAudios();
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
    var error = false;
    try {
        rec.exportWAV(saveInServer)
    }
    catch (e) {
        alert('Чтобы перейти на следующий текст необходимо записать аудио на текущий');
        error = true;
    }
    if(!error){
    }
  

});
JS;

$this->registerJs($js);
?>

