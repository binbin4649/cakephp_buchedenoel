<div class="users form">
<?php  if(!empty($Message)) echo $Message; ?>
<?php echo $form->create('Company',array('type'=>'file','url'=>'csv_update'));?>
	<fieldset>
 		<legend><?php __('CSV Update Company');?></legend>
		<?php

		echo $form->input('Company.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>

<ul>
	<li>【開発メモ】</li>
</ul>