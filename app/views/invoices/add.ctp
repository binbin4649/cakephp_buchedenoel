<div class="invoices form">
<?php echo $form->create('Invoice');?>
	<fieldset>
 		<legend><?php __('Add Invoice');?></legend>
	<?php
		echo $form->input('section_id');
		echo $form->input('billing_id');
		echo $form->input('date');
		echo $form->input('previous_invoice');
		echo $form->input('previous_deposit');
		echo $form->input('balance_forward');
		echo $form->input('sales');
		echo $form->input('tax');
		echo $form->input('total');
		echo $form->input('month_total');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Invoices', true), array('action'=>'index'));?></li>
	</ul>
</div>
