<div class="inventories form">
<?php echo $form->create('Inventory');?>
	<fieldset>
 		<legend><?php __('Add Inventory');?></legend>
	<?php
		echo $form->input('subitem_id');
		echo $form->input('depot_id');
		echo $form->input('quantity');
		echo $form->input('created_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Inventories', true), array('action'=>'index'));?></li>
	</ul>
</div>
