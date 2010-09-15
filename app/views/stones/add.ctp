<div class="stones form">
<p><?php echo $html->link(__('List Stones', true), array('action'=>'index'));?></p>
<?php echo $form->create('Stone');?>
	<fieldset>
 		<legend><?php __('Add Stone');?></legend>
	<?php
		echo $form->input('name', array(
			'label'=>__('Stone Name', true),
			'size'=>30
		));
		echo $form->input('notes', array(
			'type'=>'textarea',
			'label'=>__('Notes', true),
			'rows'=>6,
			'cols'=>45
		));
	?>
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Stones', true), array('action'=>'index'));?></li>
	</ul>
</div>
