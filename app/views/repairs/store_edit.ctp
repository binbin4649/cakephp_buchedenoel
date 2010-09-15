<div class="repairs form">
<p><?php echo $html->link(__('Return Item View', true), array('action'=>'view/'.$this->data['Repair']['id']));?></p>
<?php echo $form->create('Repair');?>
	<fieldset>
 		<legend><?php __('Edit Repair');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('item_id', array(
			'value'=>$this->data['Item']['id'],
			'after'=>$this->data['Item']['name'],
			'size'=>7
		));
		echo $form->input('size', array(
			'size'=>7
		));
		echo $form->input('factory_id', array(
			'value'=>$this->data['Factory']['id'],
			'after'=>$this->data['Factory']['name'],
			'size'=>7
		));
		echo $form->input('Repair.user_id', array(
			'label'=>__('Charge Person', true),
			'value'=>$this->data['User']['id'],
			'after'=>$this->data['User']['name'],
			'size'=>7
		));
		echo $form->input('Repair.section_id', array(
			'label'=>__('Section', true),
			'value'=>$this->data['Section']['id'],
			'after'=>$this->data['Section']['name'],
			'size'=>7
		));
		echo $form->input('status', array(
			'type'=>'select',
			'options'=>$RepairStatus,
			'div'=>true,
			'label'=>__('Status', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Repair.estimate_status', array(
			'type'=>'select',
			'options'=>$EstimateStatus,
			'div'=>true,
			'label'=>__('Estimate Status', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Repair.reception_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Reception Date', true),
			'minYear'=> MINYEAR,
			'maxYear' => MAXYEAR,
			'empty'=>'select'
		));
		echo $form->input('Repair.store_arrival_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Store Arrival Date', true),
			'minYear'=> MINYEAR,
			'maxYear' => MAXYEAR,
			'empty'=>'select'
		));
		if(!empty($this->data['Repair']['shipping_date'])){
			echo '<div class="input text"><label>'.__('Shipping Date', true).'</label>'.$this->data['Repair']['shipping_date'].'</div>';
		}else{
			echo '<div class="input text"><label>'.__('Shipping Date', true).'</label>　</div>';
		}
		echo $form->input('Repair.control_number');
		echo $form->input('Repair.customer_name');
		echo $form->input('Repair.customer_tel');

		if(!empty($this->data['Repair']['repair_price'])){
			echo '<div class="input text"><label>'.__('Repair Price', true).'</label>'.number_format($this->data['Repair']['repair_price']).'</div>';
		}else{
			echo '<div class="input text"><label>'.__('Repair Price', true).'</label>　</div>';
		}

		echo $form->input('Repair.repair_content', array(
			'size'=>50
		));
		echo $form->input('Repair.remark', array(
			'label'=>__('Remarks', true),
			'type'=>'textarea',
			'rows'=>5,
			'cols'=>50
		));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Repairs', true), array('action'=>'index'));?></li>
	</ul>
</div>