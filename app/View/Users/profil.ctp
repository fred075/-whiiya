<?php $this->set('menuNb', 1);?>

Welcome <?=$user['User']['username'] ?>!

<br>
Your mother language is <?=$user['Language']['description']; echo $this->Html->image('flags/'.$user['Language']['flag']); ?>! 
<br>

Credits: <?=$user['Credit']['amount'] ?>


<br>
<?php 
if ($nbOfEntriesForUser <=5) $color = 'blue';
if ($nbOfEntriesForUser >5) $color = 'red';
if ($nbOfEntriesForUser >10) $color = 'yellow';
	
	
	echo '<span class="glyphicon glyphicon-star" style="color:'.$color.';font-size:50px"></span>You have actually '.$nbOfEntriesForUser.' audio record(s)';
	
	

?>