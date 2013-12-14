<?php $this->set('menuNb', 1);?>

Welcome <?=$user['User']['username'] ?>!

<br>
Your mother language is <?=$user['Language']['description']; echo $this->Html->image('flags/'.$user['Language']['flag']); ?>! 
<br>

Credits: <?=$user['Credit']['amount'] ?>


<br>
<?php 
if ($nbOfEntriesForUser <=5) $color = '#2554C7';
if ($nbOfEntriesForUser >5) $color = '#342D7E';
if ($nbOfEntriesForUser >10) $color = '#D4A017';
	
	
	echo '<span class="glyphicon glyphicon-star" style="color:'.$color.';font-size:50px"></span>You have actually '.$nbOfEntriesForUser.' audio record(s)';
	
	

?>