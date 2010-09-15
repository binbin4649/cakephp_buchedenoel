<div class="items form">
<?php echo $form->create('Item',array('type'=>'file','url'=>'csv_add'));?>
	<fieldset>
 		<legend><?php __('CSV Add Item');?></legend>
		<?php 
		
		echo $form->input('Item.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>

<ul>
	<li>1回の登録は約100件（100SKU）までとして下さい。（テスト環境：090728）</li>
</ul>