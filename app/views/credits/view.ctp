<div class="view">
<p><?php echo $html->link(__('List Credits', true), array('action'=>'index'));?></p>
<fieldset><h3><?php __('Confirm Credit')?></h3>
<?php
	if(!empty($credit['Credit']['bank_acut_id'])){
		$act_bank = $bankAcuts[$credit['Credit']['bank_acut_id']];
	}else{
		$act_bank = '';
	}
	echo '<dl>';
	echo '<dt>'.__('Credit Methods').'</dt><dd>'.$creditMethods[$credit['Credit']['credit_methods']].'　</dd>';
	echo '<dt>'.__('Bank Acut').'</dt><dd>'.$act_bank.'　</dd>';
	echo '<dt>'.__('Credit Date').'</dt><dd>'.$credit['Credit']['date'].'　</dd>';
	echo '<dt>'.__('Billing').'</dt><dd>'.$credit['Credit']['billing_name'].'　</dd>';
	echo '<dt>'.__('Deposit Amount').'</dt><dd>'.number_format($credit['Credit']['deposit_amount']).'　</dd>';
	echo '<dt>'.__('Transfer Fee').'</dt><dd>'.number_format($credit['Credit']['transfer_fee']).'　</dd>';
	echo '<dt>'.__('Offset Amount').'</dt><dd>'.number_format($credit['Credit']['offset_amount']).'　</dd>';
	echo '<dt>'.__('Reconcile Amount').'</dt><dd>'.number_format($credit['Credit']['reconcile_amount']).'　</dd>';
	echo '<dt>'.__('Created').'</dt><dd>'.$credit['Credit']['created_user'].':'.$credit['Credit']['created'].'　</dd>';
	echo '<dt>'.__('Updated').'</dt><dd>'.$credit['Credit']['updated_user'].':'.$credit['Credit']['updated'].'　</dd>';
	echo '<dt>'.__('Remarks').'</dt><dd>'.nl2br($credit['Credit']['remark']).'　</dd>';
	echo '</dl>';
?>
</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Credit', true), array('action'=>'edit', $credit['Credit']['id'])); ?> </li>
	</ul>
</div>
<?php //pr($credit); ?>