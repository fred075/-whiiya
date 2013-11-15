
<center>
<div class="panel panel-info list-of-words">
	<div class="panel-heading">
		List of words :
	</div>
	<div class="panel-body">


<?php 

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