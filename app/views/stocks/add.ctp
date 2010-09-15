<div class="stocks form">
<?php echo $form->create('Stock');?>
	<fieldset>
 		<legend><?php __('Add Stock');?></legend>
	<?php
		echo $form->input('subitem_id');
		echo $form->input('depot_id');
		echo $form->input('quantity');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Stocks', true), array('action'=>'index'));?></li>
	</ul>
</div>
