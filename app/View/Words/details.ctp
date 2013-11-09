<? echo $this->Html->script('jRecorder/js/jrecorder.js', true);?>
<? echo $this->Html->script('jRecorder/js/jquery.min.js', true);?>
<? echo $this->Html->script('audio-player/audio-player.js', true);?>



   <script>
   
   $.jRecorder(
     { 
        host : '../../js/jRecorder/html/acceptfile.php?filename=hello.wav' ,  //replace with your server path please
        callback_started_recording:     function(){callback_started(); },
        callback_stopped_recording:     function(){callback_stopped(); },
        callback_activityLevel:          function(level){callback_activityLevel(level); },
        callback_activityTime:     function(time){callback_activityTime(time); },
        callback_finished_sending:     function(time){ callback_finished_sending() },
        swf_path : 'jRecorder.swf',
     }
   );
   </script>




<?php if (isset($audio_to_add)) { ?>
<div class="alert alert-success">Your accent doesn't exit. Record your voice to earn some credits.</div>
<?php } ?>
<center><div class="hero-unit">
  <h1><?=$word['Word']['word'];?></h1>
  <p>This is a list of each pronouciation we found in our database:</p>
  <p>
  </p>

<?php if(isset($error)){ echo "<script>alert('Not enough credit');</script>";} else { ?>
<ul style='list-style:none;'>

<?php 

//Showing all the entries from audio table (all accents)
foreach($word['Audio1'] as $k => $v) {

	echo "<li style='height:40px'>";
	echo '<a href=# data-toggle="modal" data-target="#myModal">'.$v['file'].' '.$v['Language']['description'].'</a>';
	
	echo "<a href=# onMouseOver='playAudio(".$v['id'].")'>".$this->Html->image('sound.png', array('style'=>('width:25px;height:25px;margin-left:10px'))).'</a>';
	echo "</li>";
}

?>
</ul>
</div>
</center>

<script>
function playAudio(id) {
	var beepOne = $("#audio_"+id)[0];	
	beepOne.play();
}

</script>

<?php 
//generate th	e sounds. Path Syntax: /audio/<word>/<language_code>.wav. Ex: /audio/hello/CH_de.wav
//the sounds ID is the "audio_" + <ID of the audio entry> (Primary Key)
foreach($word['Audio1'] as $k => $v) {
	echo "
	<audio id='audio_".$v['id']."'  preload='auto'>
	<source src='http://localhost/we_have_it_in_your_accent/-whiiya/audio/".$word['Word']['word']."/".$v['Language']['code'].".wav' ></source>
	Your browser isn't invited for super fun audio time.
	</audio>
	
	";
	
}

?>
        
        


 <a href='fsefs' >Sound</a>


<div style="background-color: #eeeeee;border:1px solid #cccccc">
  
  Time: <span id="time">00:00</span>
  
</div>


<div>
  Level: <span id="level"></span>
</div>  

<div id="levelbase" style="width:200px;height:20px;background-color:#ffff00">
  
  <div id="levelbar" style="height:19px; width:2px;background-color:red"></div>
  
</div>

  Status: <span id="status"></status>

<input type="button" id="record" value="Record" style="color:red">  

<input type="button" id="stop" value="Stop">

<input type="button" id="send" value="Send Data">



<!-- jRecorder -->

 <script type="text/javascript">

                  
      
      
      
                  $('#record').click(function(){
                    
                    
                      $.jRecorder.record(30);
                      
                      
                      
                    
                    
                  })
                  
                  
                  $('#stop').click(function(){
                    
                    
                    
                     $.jRecorder.stop();
                    
                    
                  })
                  
                  
                   $('#send').click(function(){
                    
                    
                    
                     $.jRecorder.sendData();
                    
                    
                  })
                  

                  function callback_finished()
                  {
      
                      $('#status').html('Recording is finished');
                    
                  }
                  
                  function callback_started()
                  {
      
                      $('#status').html('Recording is started');
                    
                  }
                  
                  
                  
                  
                  function callback_error(code)
                  {
                      $('#status').html('Error, code:' + code);
                  }
                  
                  
                  function callback_stopped()
                  {
                      $('#status').html('Stop request is accepted');
                  }

                  function callback_finished_recording()
                  {
                    
                      $('#status').html('Recording event is finished');
                    
                    
                  }
                  
                  function callback_finished_sending()
                  {
                    
                      $('#status').html('File has been sent to server mentioned as host parameter');
                      
                      
                  }
                  
                  function callback_activityLevel(level)
                  {
                    
                    $('#level').html(level);
                    
                    if(level == -1)
                    {
                      $('#levelbar').css("width",  "2px");
                    }
                    else
                    {
                      $('#levelbar').css("width", (level * 2)+ "px");
                    }
                    
                    
                  }
                  
                  function callback_activityTime(time)
                  {
                   
                   //$('.flrecorder').css("width", "1px"); 
                   //$('.flrecorder').css("height", "1px"); 
                    $('#time').html(time);
                    
                  }

                  
                  
                   
                   
                              

           
        </script>
                
<!-- / jRecorder -->

<?php }?>