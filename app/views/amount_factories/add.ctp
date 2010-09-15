<div class="amountFactories form">
<?php echo $form->create('AmountFactory');?>
	<fieldset>
 		<legend><?php __('Add AmountFactory');?></legend>
	<?php
		echo $form->input('amount_type', array(
			'type'=>'select',
			'options'=>$amountType,
			'div'=>true,
			'label'=>__('Amount Type', true),
		));
		echo $form->input('factory_id');
		echo $form->input('start_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Amount Start', true),
			'minYear'=>'2006',
			'maxYear' => MAXYEAR,
			'div'=>false
		));
		echo $form->input('end_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Amount End', true),
			'minYear'=>'2006',
			'maxYear' => MAXYEAR
		));
		echo $form->input('full_amount');
		echo $form->input('item_amount');
		echo $form->input('tax_amount');
		echo $form->input('cost_amount');
		echo $form->input('sales_qty');
		echo $form->input('stock_qty');
		echo $form->input('purchase_qty');
		echo $form->input('expense_amount');
		echo $form->input('purchase_amount');
		echo $form->input('stock_price_amount');
		echo $form->input('stock_cost_amount');
		echo $form->input('rank');
		echo $form->input('mark');
		echo $form->input('plan');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List AmountFactories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Factories', true), array('controller'=> 'factories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Factory', true), array('controller'=> 'factories', 'action'=>'add')); ?> </li>
	</ul>
</div>
