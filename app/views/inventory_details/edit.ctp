<div class="inventoryDetails form">
<?php echo $form->create('InventoryDetail');?>
	<fieldset>
 		<legend><?php __('Edit InventoryDetail');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('inventory_id');
		echo $form->input('depot_id');
		echo $form->input('item_id');
		echo $form->input('subitem_id');
		echo $form->input('jan');
		echo $form->input('span');
		echo $form->input('face');
		echo $form->input('qty');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('InventoryDetail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('InventoryDetail.id'))); ?></li>
		<li><?php echo $html->link(__('List InventoryDetails', true), array('action'=>'index'));?></li>
	</ul>
</div>
