<div class="pays form">
<?php echo $form->create('Pay');?>
	<fieldset>
 		<legend><?php __('Add Pay');?></legend>
	<?php
		echo $form->input('factory_id');
		echo $form->input('date');
		echo $form->input('pay_status');
		echo $form->input('partner_no');
		echo $form->input('pay_way_type');
		echo $form->input('total');
		echo $form->input('tax');
		echo $form->input('adjustment');
		echo $form->input('remark');
		echo $form->input('created_user');
		echo $form->input('updated_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Pays', true), array('action'=>'index'));?></li>
	</ul>
</div>
