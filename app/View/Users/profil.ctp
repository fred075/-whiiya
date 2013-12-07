<?php $this->set('menuNb', 1);?>

Welcome <?=$user['User']['username'] ?>!

<br>
Your mother language is <?=$user['Language']['description']; echo $this->Html->image('flags/'.$user['Language']['flag']); ?>! 
<br>

Credits: <?=$user['Credit']['amount'] ?>