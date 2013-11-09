Welcome <?=$user['User']['username'] ?>!

<br>

Your mother language is <?=$user['Language'][0]['description']; echo $this->Html->image('flags/'.$user['Language'][0]['flag']); ?>! 
<br>

Credits: <?=$user['Credit']['amount'] ?>