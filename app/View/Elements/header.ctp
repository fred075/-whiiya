<div>

<?php 
echo $this->Html->link($this->Html->image('logo.png', array('style'=>'height:120px')),'/',array('escape' => false));
?>

</div>
<div style='position:absolute;right:20px;top:20px'>
<?php 
if (($this->Session->read('Auth.User.credit'))) {?>
<span class="badge">Credit: <?=$this->Session->read('Auth.User.credit')?></span>
<span class="badge alert-danger login"><?=$this->Html->link('Logout','/users/logout'); ?></span>
<?php } else { ?>
<span class="badge alert-success login"><?=$this->Html->link('Login','/users/login'); ?></span>
<?php } ?>
</div>


<nav class="navbar navbar-default" role="navigation" >
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
<?php  if (($this->Session->read('Auth.User.credit'))) {?>
      <li class="active"><?=$this->Html->link('Profil','/users/profil');?></a></li>
<?php } ?>
      <li><?=$this->Html->link('List of words','/words');?></a></li>
      <li class="dropdown">
  </div><!-- /.navbar-collapse -->
</nav>