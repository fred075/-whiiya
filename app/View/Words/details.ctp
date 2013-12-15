<?php $this->set('menuNb', 2);?>

<? echo $this->Html->script('jRecorder/js/jquery.min.js', true);?>
<? echo $this->Html->script('jRecorder/js/jRecorder.js', true);?>
<? echo $this->Html->script('rating/rating.js', true);?>
<? echo $this->Html->css('../js/rating/rating.js.css', true);?>

<?php 

$fullPath = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$string = $fullPath;
$string = explode('/', $string);
array_pop($string);
array_pop($string);
array_pop($string);
$string = implode('/', $string);

?>

   <script>
function aff(){
	alert("You've just earnt 5 credits");
	$('#recordWindow').hide();
	//window.location.reload();
}
   $.jRecorder(
     { 
        host : "../../js/jRecorder/html/acceptfile.php?filename=<?=$word['Word']['word']?>/<?=$this->Session->read('Auth.User.Language.code')?>/<?=$this->Session->read('Auth.User.id')?>"  ,  //replace with your server path please
        callback_started_recording:     function(){callback_started(); },
        callback_stopped_recording:     function(){callback_stopped(); },
        callback_activityLevel:          function(level){callback_activityLevel(level); },
        callback_activityTime:     function(time){callback_activityTime(time); },
        callback_finished_sending:     function(time){ callback_finished_sending(); },
        swf_path : '../../js/jRecorder/html/jRecorder.swf',
     }
   );
   </script>





<center><div class="hero-unit">
  <h1><?=$word['Word']['word'];?></h1>
  <?php if ($word['Audio1']) { ?>
  <p>This is a list of each pronouciation we found in our database:</p>
  <p>
  </p>
  <?php } else { ?>
  
  <div class="alert alert-warning" style="width:300px">No audio file found.</div>
  
  
  <?php }?>
<?php if(isset($error)){ echo "<script>alert('Not enough credit');</script>";} else { ?>

<?php 
//Showing all the entries from audio table (all accents)
foreach($word['Audio1'] as $k => $v) {
	$sumVoting = 0;
	$userHasVoted = false;
	
	foreach ($v['Rating'] as $v2) { //if the user has already voted, disable the rating
		$sumVoting += $v2['rating']; //sum up the ratings
		if($v2['user_id'] == $this->Session->read('Auth.User.id')) { //go through each voting
			$userHasVoted = true;
		}
	}
	$nbOfVotings = count($word['Audio1'][$k]['Rating']);
	if($nbOfVotings == null || $nbOfVotings == 0 ) { 
		$meanVoting = '';
		$visualVoting = 0;
	} else {
		$meanVoting = $sumVoting / $nbOfVotings;
		$visualVoting = $meanVoting * 90 / 5;
	}
	
	echo '<script type="text/javascript">';
	
	if($userHasVoted == false) {
		echo '
			$(function() {
				$("#Rater'.$v['id'].'").rater({ postHref: "../rating" });
			});
		';
	}
	
	echo '</script>';
	
	echo "<div style='width:350px;height:40px'>";
	echo "<div style='float:left;text-align:right;width:50%'>";
	echo '<a href=# data-toggle="modal" data-target="#myModal">'.$v['file'].' '.$v['Language']['description'].'</a>';
	
	echo "<a href=# onMouseOver='playAudio(".$v['id'].")'>".$this->Html->image('sound.png', array('style'=>('width:25px;height:25px;margin-left:10px'))).'</a>';
	echo "</div>";
echo '
	<div id="Rater'.$v['id'].'" name="'.$v['id'].'" class="stat" style="width:165px;float:right">
		<div class="statVal">
			<span class="ui-rater" style="text-align:left">
				<span class="ui-rater-starsOff" style="width:90px;"><span class="ui-rater-starsOn" style="width:'.$visualVoting.'px"></span></span>
				<span class="ui-rater-rating">'.$meanVoting.'</span>&#160;(<span class="ui-rater-rateCount">'.$nbOfVotings.'</span>)
			</span>
        </div>
    </div>
';
	
	echo "</div>";
}

?>
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
	<source src='http://".$string."/audio/".$word['Word']['word']."/".$v['Language']['code'].".wav' ></source>
	Your browser isn't invited for super fun audio time.
	</audio>
	
	";
	
}

?>
<br />


<center>
<?php if (isset($audio_to_add) and $audio_to_add == true) { ?>
<div class="alert alert-success" style="width:350px"><span class="glyphicon glyphicon-hand-down" style="font-size:30px;float:left"></span> Your accent doesn't exit. Record your voice to earn some credits.</div>

<div class="panel panel-primary" id="recordWindow">
 <div class="panel-heading" id="title">
  Sound Recorder
 </div> 
  <div class="panel-body">
  		Time: <span id="time">00:00</span>
  <br/>
  <div >
 		Audio recording level: <span id="level"></span>
 		<div id="levelbase" style="height:20px;width:200px;background-color:#ffff00; align:left;text-align:left;">
  		<div id="levelbar" style="height:19px;width:2px;background-color:red"></div>
  		</div>
  </div>
  <br />      
  <div >
  <input type="button" class="btn btn-success" id="record" value="Record" style="width:100px;">  

  <input type="button" class="btn btn-danger" id="stop" value="Stop" style="width:100px;">

   <input type="button" class="btn btn-primary" id="send" value="Submit" disabled style="width:100px;">
   </div>
</div>



<br />
<div style="background-color: #eeeeee;border:1px solid #cccccc">
  Status: <span id="status"></status>
  <br />
</div>
</div>
</center>
<?php } ?>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<div id="disqus_thread"></div>
<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'scjmf'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>  

<!-- jRecorder -->

 <script type="text/javascript">

                  
      
      
      
                  $('#record').click(function(){
                    
                    
                      $.jRecorder.record(8);
                      
                      
                      
                    
                    
                  })
                  
                  
                  $('#stop').click(function(){
                    
                    
                     document.getElementById('send').disabled = false;
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
                      aff();
                      
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

