<div class="destinations form">
<p><?php echo $html->link(__('List Destinations', true), array('action'=>'index'));?></p>
<?php echo $form->create('Destination');?>
	<fieldset>
 		<legend><?php __('Add Destination');?></legend>
	<?php
		echo $form->input('name', array(
			'value'=>$company['Company']['name'],
			'label'=>__('Destination Name', true),
			'size'=>35
		));

		if($company){
			echo '<div class="input"><label>'.__('Company', true).':'.$company['Company']['id'].'</label>';
			echo $html->link($company['Company']['name'], array('controller'=> 'companies', 'action'=>'view', $company['Company']['id']));
			echo '</div>';
			echo $form->hidden('company_id', array(
				'value'=>$company['Company']['id']
			));
		}else{
			echo $form->input('company_id', array(
				'type'=>'text',
				'label'=>__('Company', true),
				'size'=>10
			));
		}

		echo $form->input('contact_section', array(
			'value'=>$company['Company']['contact_section'],
			'label'=>__('Contact Section', true),
			'size'=>20
		));
		echo $form->input('contact_post', array(
			'value'=>$company['Company']['contact_post'],
			'label'=>__('Contact Post', true),
			'size'=>20
		));
		echo $form->input('contact_name', array(
			'value'=>$company['Company']['contact_name'],
			'label'=>__('Contact Name', true),
			'size'=>20
		));
		echo $form->input('post_code', array(
			'value'=>$company['Company']['post_code'],
			'label'=>__('Post Code', true),
			'size'=>10
		));
		echo $form->input('district', array(
			'value'=>$company['Company']['district'],
			'type'=>'select',
			'options'=>$district,
			'div'=>true,
			'label'=>__('District', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('address_one', array(
			'value'=>$company['Company']['address_one'],
			'label'=>__('Adress One', true),
			'size'=>40
		));
		echo $form->input('address_two', array(
			'value'=>$company['Company']['address_two'],
			'label'=>__('Adress Two', true),
			'size'=>40
		));
		echo $form->input('tel', array(
			'value'=>$company['Company']['tel'],
			'label'=>__('Tel', true),
			'size'=>20
		));
		echo $form->input('fax', array(
			'value'=>$company['Company']['fax'],
			'label'=>__('Fax', true),
			'size'=>20
		));
		echo $form->input('mail', array(
			'value'=>$company['Company']['mail'],
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
		<li><?php echo $html->link(__('List Destinations', true), array('action'=>'index'));?></li>
	</ul>
</div>
