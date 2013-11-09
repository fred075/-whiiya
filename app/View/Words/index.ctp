
<div class="alert alert-success">List of words : </div>






<?php 

//debug($words);exit;

foreach($words as $k => $v) {

	echo $this->Html->link($v['Word']['word'], array('controller'=>'words', 'action'=>'details', $v['Word']['word']));
echo "<br>";
}

?>
