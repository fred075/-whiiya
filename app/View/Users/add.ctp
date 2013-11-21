<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        
        echo "<div style='margin-left:7px;padding-left:0px'>";
        echo $this->Form->Label('Language');
        
        echo "<select name='data[User][language_id]' class='form-control'>";
        foreach ($languages as $lang){
        	echo "<option value='" . $lang['Language']['id'] . "'> " . $lang['Language']['description'] . "</option>";
        }
        echo "</select>";
        echo "</div>";
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>