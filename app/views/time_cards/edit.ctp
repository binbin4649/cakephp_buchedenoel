<div class="timeCards form">
<?php echo $form->create('TimeCard');?>
	<fieldset>
 		<legend><?php __('Edit TimeCard');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('chopping');
		echo $form->input('user_id');
		echo $form->input('chop_date');
		echo $form->input('ip_number');
		echo $form->input('remarks');
		echo $form->input('created_user');
		echo $form->input('updated_user');
		echo $form->input('deleted');
		echo $form->input('deleted_date');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('TimeCard.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('TimeCard.id'))); ?></li>
		<li><?php echo $html->link(__('List TimeCards', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
