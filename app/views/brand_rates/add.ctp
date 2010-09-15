<div class="brandRates form">
<p><?php echo $html->link(__('List BrandRates', true), array('action'=>'index'));?></p>
<?php echo $form->create('BrandRate');?>
	<fieldset>
 		<legend><?php __('Add BrandRate');?></legend>
	<?php
		echo '<div class="input"><label>'.$company['Company']['id'].':</label>';
		echo $html->link($company['Company']['name'], array('controller'=> 'companies', 'action'=>'view', $company['Company']['id']));
		echo '</div>';
		echo $form->hidden('company_id', array(
			'value'=>$company['Company']['id']
		));

		echo $form->input('brand_id', array(
			'label'=>__('Brand', true),
		));
		echo $form->input('rate', array(
			'label'=>__('Rate', true),
			'size'=>5
		));
		echo $form->input('cancel_flag', array(
			'type'=>'select',
			'options'=>$cancelFlag,
			'div'=>true,
			'label'=>__('Cancel Flag', true),
			'empty'=>__('(Please Select)', true)
		));
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List BrandRates', true), array('action'=>'index'));?></li>
	</ul>
</div>
