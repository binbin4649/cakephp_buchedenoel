<div class="stockRevisions form">
<?php echo $form->create('StockRevision');?>
	<fieldset>
 		<legend><?php __('Edit StockRevision');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('subitem_id');
		echo $form->input('depot_id');
		echo $form->input('quantity');
		echo $form->input('stock_change');
		echo $form->input('reason_type');
		echo $form->input('reason');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('StockRevision.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('StockRevision.id'))); ?></li>
		<li><?php echo $html->link(__('List StockRevisions', true), array('action'=>'index'));?></li>
	</ul>
</div>
