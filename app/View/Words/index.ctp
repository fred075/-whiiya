<?php $this->set('menuNb', 2);?>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

<script>
  $(function() {
	  
    var availableTags = [
<?php 
foreach($words as $k => $v) {
	echo '"'.$v['Word']['word'].'",';
}
?>
    ];
    
    $( "#wordsTextbox" ).autocomplete({
      source: availableTags
    });
  });
  </script>
  

<center>

<form method="post" action="" role="form">
<div class="form-group" style='width:420px'> 
<input type="text" id="wordsTextbox" name="wordsTextbox" class="form-control" style="float:left;width:300px">
<button class="btn btn-info">Search</button>
</div>
</form>

<div class="panel panel-info list-of-words">
	<div class="panel-heading">
		List of words :
	</div>
	<div class="panel-body">
	
	

<?php 

if(!empty($audio_empty)) {
	//pr($audio_empty);
	echo $this->element('modal', array(
	    "title" => 'Earn some extra credits.',
		"content" => '<div style="float:left"><span class="glyphicon glyphicon-usd" style="font-size:50px;color:#9ADBFC"></span></div> Listen to the word '. $this->Html->link($audio_empty['Word']['word'], '/words/details/' . $audio_empty['Word']['word']) . ', record your voice and earn some credits.'
	));
}

//debug($words);exit;

foreach($words as $k => $v) {
$class = empty($v['Audio1'])?"no_audio":"";
	echo $this->Html->link($v['Word']['word'], array('controller'=>'words', 'action'=>'details', $v['Word']['word']), array('class'=>$class));

echo "<br>";
}

?>

	</div>
</div>

</center>