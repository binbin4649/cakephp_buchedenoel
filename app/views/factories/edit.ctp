<div class="factories form">
<p><?php echo $html->link(__('List Factories', true), array('action'=>'index')); ?> </p>
<?php echo $form->create('Factory');?>
	<fieldset>
 		<legend><?php __('Edit Factory');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('Factory.name', array(
			'label'=>__('Factory Name', true),
			'size'=>35
		));
		echo $form->input('Factory.name_kana', array(
			'label'=>__('Name Kana', true),
			'size'=>35
		));
		echo $form->input('Factory.charge_person', array(
			'label'=>__('Charge Person', true),
			'size'=>30
		));
		echo $form->input('Factory.charge_section', array(
			'label'=>__('Charge Section', true),
			'size'=>30
		));
		echo $form->input('Factory.post_code', array(
			'label'=>__('Post Code', true),
			'size'=>15
		));
		echo $form->input('Factory.district', array(
			'type'=>'select',
			'options'=>$district,
			'div'=>true,
			'label'=>__('District', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.adress_one', array(
			'label'=>__('Adress 1', true),
			'size'=>35,
			'after'=>'(市区町村)'
		));
		echo $form->input('Factory.adress_two', array(
			'label'=>__('Adress 2', true),
			'size'=>35,
			'after'=>'(番地、建物名)'
		));
		echo $form->input('Factory.tel', array(
			'label'=>__('Tel', true),
			'size'=>20
		));
		echo $form->input('Factory.extension_tel', array(
			'label'=>__('Extension Tel', true),
			'size'=>20
		));
		echo $form->input('Factory.fax', array(
			'label'=>__('Fax', true),
			'size'=>20
		));
		echo $form->input('Factory.mail', array(
			'label'=>__('Mail', true),
			'size'=>20
		));
		echo $form->input('Factory.delivery_days', array(
			'label'=>__('Delivery Days', true),
			'size'=>5
		));
		echo $form->input('Factory.custom_order_days', array(
			'label'=>__('Custom Order Days', true),
			'size'=>5
		));
		echo $form->input('Factory.repair_days', array(
			'label'=>__('Repair Days', true),
			'size'=>5
		));
		echo $form->input('Factory.tax_method', array(
			'type'=>'select',
			'options'=>$taxMethod,
			'div'=>true,
			'label'=>__('Tax Method', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.tax_fraction', array(
			'type'=>'select',
			'options'=>$taxFraction,
			'div'=>true,
			'label'=>__('Tax Fraction', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.total_day', array(
			'type'=>'select',
			'options'=>$totalDay,
			'div'=>true,
			'label'=>__('Total Day', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.payment_day', array(
			'type'=>'select',
			'options'=>$paymentDay,
			'div'=>true,
			'label'=>__('Payment Day', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.payment_code', array(
			'type'=>'select',
			'options'=>$paymentCode,
			'div'=>true,
			'label'=>__('Payment Code', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.trading_flag', array(
			'type'=>'select',
			'options'=>$tradingFlag,
			'div'=>true,
			'label'=>__('Trading Flag', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Factory.trading_start', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Trading Start', true),
			'minYear'=>'2000',
			'maxYear' =>MAXYEAR,
			'empty'=>'select'
		));
		echo $form->input('Factory.trading_end', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Trading End', true),
			'minYear'=>'2000',
			'maxYear' =>MAXYEAR,
			'empty'=>'select'
		));
		echo $form->input('Factory.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>3,
			'cols'=>45
		));
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Factory.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Factory.id'))); ?></li>
		<li><?php echo $html->link(__('List Factories', true), array('action'=>'index'));?></li>
	</ul>
</div>
