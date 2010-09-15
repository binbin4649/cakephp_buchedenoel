<div class="salesDateils form">
<?php echo $form->create('SalesDateil');?>
	<fieldset>
 		<legend><?php __('Edit SalesDateil');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('sales_id');
		echo $form->input('detail_no');
		echo $form->input('item_id');
		echo $form->input('subitem_id');
		echo $form->input('size');
		echo $form->input('bid');
		echo $form->input('bid_quantity');
		echo $form->input('cost');
		echo $form->input('tax');
		echo $form->input('marking');
		echo $form->input('credit_quantity');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('SalesDateil.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('SalesDateil.id'))); ?></li>
		<li><?php echo $html->link(__('List SalesDateils', true), array('action'=>'index'));?></li>
	</ul>
</div>
