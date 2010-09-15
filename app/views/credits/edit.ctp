<div class="credits form">
<p><?php echo $html->link(__('List Credits', true), array('action'=>'index'));?></p>
<p><?php echo $html->link(__('Return Credit No.'.$this->data['Credit']['id'], true), array('action'=>'view/'.$this->data['Credit']['id']));?></p>
<?php echo $form->create('Credit');?>
	<fieldset>
 		<legend><?php __('Edit Credit');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('Credit.credit_methods', array(
			'type'=>'select',
			'options'=>$creditMethods,
			'div'=>true,
			'label'=>__('Credit Methods', true)
		));
		echo $form->input('Credit.bank_acut_id', array(
			'type'=>'select',
			'options'=>$bankAcuts,
			'div'=>true,
			'label'=>__('Bank Acut', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Credit.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Credit Date', true),
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
		));
		echo $form->input('Credit.billing_id', array(
			'label'=>__('Billing', true),
			'size'=>10,
			'after'=>'<a href="/buchedenoel/billings" target="_blank">請求先検索</a>'
		));
		echo $form->input('Credit.deposit_amount', array(
			'label'=>__('Deposit Amount', true),
			'size'=>10
		));
		echo $form->input('Credit.transfer_fee', array(
			'label'=>__('Transfer Fee', true),
			'size'=>10
		));
		echo $form->input('Credit.offset_amount', array(
			'label'=>__('Offset Amount', true),
			'size'=>10
		));
		echo $form->input('Credit.adjustment', array(
			'label'=>__('Adjustment', true),
			'size'=>10
		));
		echo $form->input('Credit.reconcile_amount', array(
			'label'=>__('Reconcile Amount', true),
			'size'=>10
		));
		echo $form->input('Credit.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>2,
			'cols'=>40
		));
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>