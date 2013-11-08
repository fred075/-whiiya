Welcome <?=$this->Session->read('Auth.User.username'); ?>!

<br>

Your mother language is <?=$user['Language'][0]['description']; echo $this->Html->image('flags/'.$user['Language'][0]['flag']); ?>! 