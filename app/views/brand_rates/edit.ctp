<div class="brandRates form">
<p><?php echo $html->link(__('List BrandRates', true), array('action'=>'index'));?></p>
<?php echo $form->create('BrandRate');?>
	<fieldset>
 		<legend><?php __('Edit BrandRate');?></legend>
	<?php
		echo $form->input('id');
		echo '<div class="input"><label>'.$this->data['Company']['id'].':</label>';
		echo $html->link($this->data['Company']['name'], array('controller'=> 'companies', 'action'=>'view', $this->data['Company']['id']));
		echo '</div>';
		echo $form->hidden('company_id', array(
			'value'=>$this->data['Company']['id']
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
		<li><?php //echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('BrandRate.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('BrandRate.id'))); ?></li>
		<li><?php echo $html->link(__('List BrandRates', true), array('action'=>'index'));?></li>
	</ul>
</div>