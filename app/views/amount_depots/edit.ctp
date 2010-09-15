<div class="amountDepots form">
<?php echo $form->create('AmountDepot');?>
	<fieldset>
 		<legend><?php __('Edit AmountDepot');?></legend>
	<?php
		$modelName = 'AmountDepot';
		$subModel = 'Depot';
		$sub_id = 'depot_id';
		echo $form->input('id');
		echo '<div class="input"><label>'.__('Name', true).'</label>'.$this->data[$modelName]['name'].'　</div>';
		echo $form->input('amount_type', array(
			'type'=>'select',
			'options'=>$amountType,
			'div'=>true,
			'label'=>__('Amount Type', true),
		));
		echo $form->input($sub_id);
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
		echo '<div class="input"><label>'.__('Created', true).'</label>'.$this->data[$modelName]['created'].':'.$this->data[$modelName]['created_user'].'　</div>';
		echo '<div class="input"><label>'.__('Updated', true).'</label>'.$this->data[$modelName]['updated'].':'.$this->data[$modelName]['updated_user'].'　</div>';
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List AmountDepots', true), array('action'=>'index'));?></li>
	</ul>
</div>
