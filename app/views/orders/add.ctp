<div class="orders form">
<?php echo $form->create('Order');?>
	<fieldset>
 		<legend><?php __('Add Order');?></legend>
	<?php
		echo $form->input('order_type');
		echo $form->input('depot_id');
		echo $form->input('order_status');
		echo $form->input('destination_id');
		echo $form->input('events_no');
		echo $form->input('span_no');
		echo $form->input('date');
		echo $form->input('contact1');
		echo $form->input('contact2');
		echo $form->input('contact3');
		echo $form->input('contact4');
		echo $form->input('contribute1');
		echo $form->input('contribute2');
		echo $form->input('contribute3');
		echo $form->input('contribute4');
		echo $form->input('customers_name');
		echo $form->input('pairing1');
		echo $form->input('pairing2');
		echo $form->input('pairing3');
		echo $form->input('pairing4');
		echo $form->input('partners_no');
		echo $form->input('total');
		echo $form->input('price_total');
		echo $form->input('total_tax');
		echo $form->input('shipping');
		echo $form->input('adjustment');
		echo $form->input('delivery_no');
		echo $form->input('remark');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Orders', true), array('action'=>'index'));?></li>
	</ul>
</div>
