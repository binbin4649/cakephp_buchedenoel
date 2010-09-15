<div class="companies form">
<p><?php echo $html->link(__('List Companies', true), array('action'=>'index'));?></p>
<?php echo $form->create('Company');?>
	<fieldset>
		<legend><?php __('Edit Company');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Company Name', true),
			'size'=>35
		));
		echo $form->input('kana', array(
			'label'=>__('Kana', true),
			'size'=>35
		));
		echo $form->input('user_id', array(
			'type'=>'text',
			'label'=>__('Contact User', true),
			'after'=>$this->data['User']['name'],
			'size'=>10
		));
		echo $form->input('billing_id', array(
			'type'=>'text',
			'label'=>__('Billing', true),
			'after'=>$html->link($this->data['Billing']['name'], array('controller'=>'billings', 'action'=>'view/'.$this->data['Billing']['id'])),
			'size'=>10
		));
		echo $form->input('contact_section', array(
			'label'=>__('Contact Section', true),
			'size'=>20
		));
		echo $form->input('contact_post', array(
			'label'=>__('Contact Post', true),
			'size'=>20
		));
		echo $form->input('contact_name', array(
			'label'=>__('Contact Name', true),
			'size'=>20
		));
		echo $form->input('post_code', array(
			'label'=>__('Post Code', true),
			'size'=>10
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
			'size'=>20
		));
		echo $form->input('url', array(
			'label'=>__('Home Page', true),
			'size'=>40
		));
		echo $form->input('trade_type', array(
			'type'=>'select',
			'options'=>$tradeType,
			'div'=>true,
			'label'=>__('Trade Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('basic_rate', array(
			'label'=>__('Basic Rate', true),
			'size'=>5
		));
		echo $form->input('rate_fraction', array(
			'type'=>'select',
			'options'=>$rateFraction,
			'div'=>true,
			'label'=>__('Rate Fraction', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('tax_method', array(
			'type'=>'select',
			'options'=>$taxMethod,
			'div'=>true,
			'label'=>__('Tax Method', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('tax_fraction', array(
			'type'=>'select',
			'options'=>$taxFraction,
			'div'=>true,
			'label'=>__('Tax Fraction', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('start_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Start Day', true),
			'selected'=>array('year'=>'2009', 'month'=>'01', 'day'=>'01'),
			'minYear'=>'2009',
			'maxYear' =>MAXYEAR,
		));
		echo $form->input('last_visit_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Last Visit Day', true),
			'selected'=>array('year'=>'2009', 'month'=>'01', 'day'=>'01'),
			'minYear'=>'2009',
			'maxYear' =>MAXYEAR,
		));
		echo $form->input('agreement', array(
			'label'=>__('Agreement', true),
			'size'=>30
		));
		echo $form->input('stations', array(
			'type'=>'textarea',
			'label'=>__('Stations', true),
			'rows'=>3,
			'cols'=>45
		));
		echo $form->input('more', array(
			'type'=>'textarea',
			'label'=>__('More', true),
			'rows'=>3,
			'cols'=>45
		));
		echo $form->input('store_info', array(
			'type'=>'textarea',
			'label'=>__('Store Info', true),
			'rows'=>3,
			'cols'=>45
		));
		echo $form->input('remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>3,
			'cols'=>45
		));
		echo $form->input('username');
		echo $form->input('password');
		echo $form->input('Grouping');
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Companies', true), array('action'=>'index'));?></li>
	</ul>
</div>
<hr>
<ul>
	<li>掛率は4桁で入力してください。　（例）「49.25%」の場合は「4925」、「50%」の場合は「5000」</li>
	<li>消費税計算方法が請求単位の場合は、請求先マスタの端数処理が適用されます。</li>
</ul>