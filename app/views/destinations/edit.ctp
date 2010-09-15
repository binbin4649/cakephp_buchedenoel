<div class="destinations form">
<p><?php echo $html->link(__('List Destinations', true), array('action'=>'index'));?></p>
<?php echo $form->create('Destination');?>
	<fieldset>
 		<legend><?php __('Edit Destination');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Destination Name', true),
			'size'=>35
		));
		echo $form->input('company_id', array(
			'type'=>'text',
			'label'=>__('Company', true),
			'after'=>$html->link($this->data['Company']['name'], array('controller'=>'companies', 'action'=>'view/'.$this->data['Company']['id'])),
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
			'size'=>30
		));
		echo $form->input('trade_type', array(
			'type'=>'select',
			'options'=>$tradeType,
			'div'=>true,
			'label'=>__('Trade Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('shipping_flag', array(
			'type'=>'select',
			'options'=>$shippingFlag,
			'div'=>true,
			'label'=>__('Shipping Flag', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('shipping_condition', array(
			'label'=>__('Shipping Condition', true),
			'size'=>10
		));
		echo $form->input('shipping_cost', array(
			'label'=>__('Shipping Cost', true),
			'size'=>10
		));
		echo $form->input('remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>4,
			'cols'=>45
		));
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php //echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Destination.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Destination.id'))); ?></li>
		<li><?php echo $html->link(__('List Destinations', true), array('action'=>'index'));?></li>
	</ul>
</div>