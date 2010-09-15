<div class="processes form">
<p><?php echo $html->link(__('List Processes', true), array('action'=>'index'));?></p>
<?php echo $form->create('Process');?>
	<fieldset>
 		<legend><?php __('Edit Process');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Process Name', true),
			'size'=>30
		));
		echo $form->input('cleaning_plan', array(
			'type'=>'textarea',
			'label'=>__('Cleaning Plan', true),
			'rows'=>6,
			'cols'=>45
		));
		echo $form->input('notes', array(
			'type'=>'textarea',
			'label'=>__('Notes', true),
			'rows'=>6,
			'cols'=>45
		));
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Process.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Process.id'))); ?></li>
		<li><?php echo $html->link(__('List Processes', true), array('action'=>'index'));?></li>
	</ul>
</div>
