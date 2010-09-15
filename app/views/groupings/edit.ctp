<div class="groupings form">
<?php echo $form->create('Grouping');?>
	<fieldset>
 		<legend><?php __('Edit Grouping');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Grouping Name', true),
			'size'=>20
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
		<li><?php echo $html->link(__('List Groupings', true), array('action'=>'index'));?></li>
	</ul>
</div>
