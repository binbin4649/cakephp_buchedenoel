<div class="materials form">
<p><?php echo $html->link(__('List Materials', true), array('action'=>'index'));?></p>
<?php echo $form->create('Material');?>
	<fieldset>
 		<legend><?php __('Edit Material');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Material Name', true),
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
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Material.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Material.id'))); ?></li>
		<li><?php echo $html->link(__('List Materials', true), array('action'=>'index'));?></li>
	</ul>
</div>
