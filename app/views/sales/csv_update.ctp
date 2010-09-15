<div class="users form">
<?php  if(!empty($Message)) echo $Message; ?>
<?php echo $form->create('Sale',array('type'=>'file','url'=>'csv_update'));?>
	<fieldset>
 		<legend><?php __('CSV Update Sales');?></legend>
		<?php

		echo $form->input('Sale.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>

<ul>
	<li>販売管理システムの「小売売上CSV」「卸売上CSV」を対象に登録できます。</li>
	<li>CSVファイルは、500行、500KBを目安にアップロードして下さい。超えた場合は、深夜のバッチで処理されます。</li>
</ul>