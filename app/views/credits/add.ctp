<div class="view">
<p><?php echo $html->link(__('List Credits', true), array('action'=>'index'));?></p>
<?php
if(!empty($add_confirm)){
	$date = $add_confirm['Credit']['date']['year'].'-'.$add_confirm['Credit']['date']['month'].'-'.$add_confirm['Credit']['date']['day'];
	if(!empty($add_confirm['Credit']['bank_acut_id'])){
		$act_bank = $bankAcuts[$add_confirm['Credit']['bank_acut_id']];
	}else{
		$act_bank = '';
	}
	echo '<fieldset><h3>'.__('Confirm Credit').'</h3>';
	echo '<dl>';
	echo '<dt>'.__('Credit Methods').'</dt><dd>'.$creditMethods[$add_confirm['Credit']['credit_methods']].'　</dd>';
	echo '<dt>'.__('Bank Acut').'</dt><dd>'.$act_bank.'　</dd>';
	echo '<dt>'.__('Credit Date').'</dt><dd>'.$date.'　</dd>';
	echo '<dt>'.__('Billing').'</dt><dd>'.$add_confirm['Credit']['billing_name'].'　</dd>';
	echo '<dt>'.__('Deposit Amount').'</dt><dd>'.number_format($add_confirm['Credit']['deposit_amount']).'　</dd>';
	echo '<dt>'.__('Transfer Fee').'</dt><dd>'.number_format($add_confirm['Credit']['transfer_fee']).'　</dd>';
	echo '<dt>'.__('Offset Amount').'</dt><dd>'.number_format($add_confirm['Credit']['offset_amount']).'　</dd>';
	echo '<dt>'.__('Reconcile Amount').'</dt><dd>'.number_format($add_confirm['Credit']['reconcile_amount']).'　</dd>';
	echo '<dt>'.__('Remarks').'</dt><dd>'.nl2br($add_confirm['Credit']['remark']).'　</dd>';
	echo '</dl>';
	echo $addForm->switchAnchor('credits/add/add', array(0, 1, 2), 'OK?', 'Confirm Credit', $add_confirm['Credit']['status']);
	echo '</fieldset>';
}
?>
</div>

<div class="credits form">
<?php echo $form->create('Credit');?>
	<fieldset>
 		<legend><?php __('Add Credit');?></legend>
	<?php
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
