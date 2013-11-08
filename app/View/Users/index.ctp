<?php if ($this->Session->read('Auth.User.id')) echo "Logged in";?>

Welcome <?=$this->Session->read('Auth.User.username'); ?>!