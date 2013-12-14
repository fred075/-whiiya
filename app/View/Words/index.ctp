<?php $this->set('menuNb', 2);?>
<center>
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