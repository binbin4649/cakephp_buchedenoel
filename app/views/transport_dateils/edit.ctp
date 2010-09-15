<div class="transportDateils form">
<?php echo $form->create('TransportDateil');?>
	<fieldset>
 		<legend><?php __('Edit TransportDateil');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('transport_id');
		echo $form->input('subitem_id');
		echo $form->input('quantity');
		echo $form->input('pairing_quantity');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('TransportDateil.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('TransportDateil.id'))); ?></li>
		<li><?php echo $html->link(__('List TransportDateils', true), array('action'=>'index'));?></li>
	</ul>
</div>
