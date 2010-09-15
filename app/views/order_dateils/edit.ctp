<div class="orderDateils form">
<?php echo $form->create('OrderDateil');?>
	<fieldset>
 		<legend><?php __('Edit OrderDateil');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('order_id');
		echo $form->input('detail_no');
		echo $form->input('item_id');
		echo $form->input('subitem_id');
		echo $form->input('size');
		echo $form->input('lot_type');
		echo $form->input('specified_date');
		echo $form->input('store_arrival_date');
		echo $form->input('stock_date');
		echo $form->input('shipping_date');
		echo $form->input('bid');
		echo $form->input('bid_quantity');
		echo $form->input('cost');
		echo $form->input('tax');
		echo $form->input('pairing_quantity');
		echo $form->input('ordering_quantity');
		echo $form->input('sell_quantity');
		echo $form->input('marking');
		echo $form->input('transport_dateil_id');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('OrderDateil.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('OrderDateil.id'))); ?></li>
		<li><?php echo $html->link(__('List OrderDateils', true), array('action'=>'index'));?></li>
	</ul>
</div>
