<div class="items form">
<?php echo $form->create('Stock',array('type'=>'file','url'=>'csv_add'));?>
	<fieldset>
 		<legend><?php __('CSV Add Stock');?></legend>
		<?php
		echo $form->input('Stock.depot', array(
			'type'=>'text',
			'label'=>__('Depot', true),
			'size'=>2
		));
		echo $form->input('Stock.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>

<ul>
	<li></li>
</ul>