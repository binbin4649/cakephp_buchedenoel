<div class="daysCoordinations form">
<?php echo $form->create('DaysCoordination');?>
	<fieldset>
 		<legend><?php __('Add DaysCoordination');?></legend>
	<?php
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
		<li><?php echo $html->link(__('List DaysCoordinations', true), array('action'=>'index'));?></li>
	</ul>
</div>
