<div class="purchaseDetails form">
<?php echo $form->create('PurchaseDetail');?>
	<fieldset>
 		<legend><?php __('Add PurchaseDetail');?></legend>
	<?php
		echo $form->input('purchase_id');
		echo $form->input('order_id');
		echo $form->input('order_dateil_id');
		echo $form->input('ordering_id');
		echo $form->input('ordering_dateil_id');
		echo $form->input('item_id');
		echo $form->input('subitem_id');
		echo $form->input('size');
		echo $form->input('bid');
		echo $form->input('quantity');
		echo $form->input('pay_quantity');
		echo $form->input('gram');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List PurchaseDetails', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Purchases', true), array('controller'=> 'purchases', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Purchase', true), array('controller'=> 'purchases', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Orders', true), array('controller'=> 'orders', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Order', true), array('controller'=> 'orders', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Order Dateils', true), array('controller'=> 'order_dateils', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Order Dateil', true), array('controller'=> 'order_dateils', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Orderings', true), array('controller'=> 'orderings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Ordering', true), array('controller'=> 'orderings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Items', true), array('controller'=> 'items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Item', true), array('controller'=> 'items', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Subitems', true), array('controller'=> 'subitems', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Subitem', true), array('controller'=> 'subitems', 'action'=>'add')); ?> </li>
	</ul>
</div>
