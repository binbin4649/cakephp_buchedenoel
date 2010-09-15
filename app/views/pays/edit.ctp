<div class="pays form">
<p><?php echo $html->link(__('List Pays', true), array('action'=>'index'));?></p>
<p><?php echo $html->link(__('Return No.'.$this->data['Pay']['id'], true), array('controller'=>'pays', 'action'=>'view', $this->data['Pay']['id']));?></p>
<?php echo $form->create('Pay');?>
	<fieldset>
 		<legend><?php __('Edit Pay');?></legend>
	<?php
		echo $form->input('id');
		echo '<div class="input"><label>'.__('System No.', true).'</label>'.$this->data['Pay']['id'].'　</div>';
		echo '<div class="input"><label>'.__('Factory', true).'</label>'.$html->link($this->data['Factory']['name'], array('controller'=>'factories', 'action'=>'view', $this->data['Factory']['id'])).'　</div>';
		echo $form->input('Pay.pay_status', array(
			'type'=>'select',
			'options'=>$payStatus,
			'div'=>true,
			'label'=>__('Status', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Pay.partner_no', array(
			'label'=>__('Bill No.', true),
			'size'=>30
		));
		echo $form->input('Pay.pay_way_type', array(
			'type'=>'select',
			'options'=>$payWayType,
			'div'=>true,
			'label'=>__('Pay Way Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Pay.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Pay Date', true),
			'empty'=>'(select)',
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
		));
		echo $form->input('Pay.total_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Total Day', true),
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
		));
		echo $form->input('Pay.payment_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Payment Day', true),
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
		));
		echo '<div class="input"><label>'.__('Total', true).'</label>'.number_format($this->data['Pay']['total']).'　</div>';
		echo $form->hidden('Pay.total', array('value'=>$this->data['Pay']['total']));
		echo '<div class="input"><label>'.__('Tax', true).'</label>'.number_format($this->data['Pay']['tax']).'　</div>';
		echo $form->hidden('Pay.tax', array('value'=>$this->data['Pay']['tax']));
		echo $form->input('Pay.adjustment', array(
			'size'=>10
		));
		echo $form->input('Pay.remark', array(
			'label'=>__('Remarks', true),
			'type'=>'textarea',
			'rows'=>5,
			'cols'=>50
		));
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
