<div class="salesStateCodes form">
<p><?php echo $html->link(__('List SalesStateCodes', true), array('action'=>'index'));?></p>
<?php echo $form->create('SalesStateCode');?>
	<fieldset>
 		<legend><?php __('Edit SalesStateCode');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('SalesStateCode.name', array(
			'label'=>__('Sales Code Name', true),
			'size'=>25
		));
		echo $form->input('SalesStateCode.explain', array(
			'type'=>'textarea',
			'label'=>__('Explain', true),
			'rows'=>8,
			'cols'=>50
		));
		echo $form->input('SalesStateCode.cutom_order_approve', array(
			'type'=>'select',
			'options'=>$cutomOrderApprove,
			'div'=>true,
			'label'=>__('Custom Order Approve', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('SalesStateCode.order_approve', array(
			'type'=>'select',
			'options'=>$orderApprove,
			'div'=>true,
			'label'=>__('Order Approve', true),
			'empty'=>__('(Please Select)', true)
		));
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('SalesStateCode.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('SalesStateCode.id'))); ?></li>
		<li><?php echo $html->link(__('List SalesStateCodes', true), array('action'=>'index'));?></li>
	</ul>
</div>
