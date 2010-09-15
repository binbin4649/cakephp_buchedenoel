<div class="stocks form">
<?php echo $form->create('Stock');?>
	<fieldset>
 		<legend><?php __('Edit Stock');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('subitem_id');
		echo $form->input('depot_id');
		echo $form->input('quantity');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Stock.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Stock.id'))); ?></li>
		<li><?php echo $html->link(__('List Stocks', true), array('action'=>'index'));?></li>
	</ul>
</div>
