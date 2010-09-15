<div class="daysCoordinations form">
<?php echo $form->create('DaysCoordination');?>
	<fieldset>
 		<legend><?php __('Edit DaysCoordination');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('apply_approve');
		echo $form->input('coordination_approve');
		echo $form->input('start_datetime');
		echo $form->input('end_datetime');
		echo $form->input('apply_day');
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
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('DaysCoordination.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('DaysCoordination.id'))); ?></li>
		<li><?php echo $html->link(__('List DaysCoordinations', true), array('action'=>'index'));?></li>
	</ul>
</div>
