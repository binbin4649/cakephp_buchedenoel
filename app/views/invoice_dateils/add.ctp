<div class="invoiceDateils form">
<?php echo $form->create('InvoiceDateil');?>
	<fieldset>
 		<legend><?php __('Add InvoiceDateil');?></legend>
	<?php
		echo $form->input('invoice_id');
		echo $form->input('detail_no');
		echo $form->input('sale_id');
		echo $form->input('sale_date');
		echo $form->input('sale_total');
		echo $form->input('sale_items');
		echo $form->input('tax');
		echo $form->input('shipping');
		echo $form->input('adjustment');
		echo $form->input('total_quantity');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List InvoiceDateils', true), array('action'=>'index'));?></li>
	</ul>
</div>
