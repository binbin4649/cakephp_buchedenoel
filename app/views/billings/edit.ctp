<div class="billings form">
<p><?php echo $html->link(__('List Billings', true), array('action'=>'index')); ?> </p>
<?php echo $form->create('Billing');?>
	<fieldset>
 		<legend><?php __('Edit Billing');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Billing Name', true),
			'size'=>35
		));
		echo $form->input('contact_section', array(
			'label'=>__('Contact Section', true),
			'size'=>25
		));
		echo $form->input('contact_post', array(
			'label'=>__('Contact Post', true),
			'size'=>25
		));
		echo $form->input('contact_name', array(
			'label'=>__('Contact Name', true),
			'size'=>25
		));
		echo $form->input('post_code', array(
			'label'=>__('Post Code', true),
			'size'=>20
		));
		echo $form->input('district', array(
			'type'=>'select',
			'options'=>$district,
			'div'=>true,
			'label'=>__('District', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('address_one', array(
			'label'=>__('Adress One', true),
			'size'=>40
		));
		echo $form->input('address_two', array(
			'label'=>__('Adress Two', true),
			'size'=>40
		));
		echo $form->input('tel', array(
			'label'=>__('Tel', true),
			'size'=>20
		));
		echo $form->input('fax', array(
			'label'=>__('Fax', true),
			'size'=>20
		));
		echo $form->input('mail', array(
			'label'=>__('Mail', true),
			'size'=>30
		));
		echo $form->input('trade_type', array(
			'type'=>'select',
			'options'=>$tradeType,
			'div'=>true,
			'label'=>__('Trade Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('invoice_type', array(
			'type'=>'select',
			'options'=>$invoiceType,
			'div'=>true,
			'label'=>__('Invoice Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('total_day', array(
			'type'=>'select',
			'options'=>$totalDay,
			'div'=>true,
			'label'=>__('Total Day', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('payment_day', array(
			'type'=>'select',
			'options'=>$paymentDay,
			'div'=>true,
			'label'=>__('Payment Day', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('tax_fraction', array(
			'type'=>'select',
			'options'=>$taxFraction,
			'div'=>true,
			'label'=>__('Tax Fraction', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45
		));
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php //echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Billing.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Billing.id'))); ?></li>
		<li><?php echo $html->link(__('List Billings', true), array('action'=>'index'));?></li>
	</ul>
</div>
<hr>
<ul>
	<li>取引先マスタの消費税計算方法が請求単位だった場合、請求先マスタの端数処理が適用されます。
取引先マスタの消費税計算方法が伝票単位、明細単位、単品単位だった場合、請求先マスタの端数処理は意味がありません。</li>
</ul>
