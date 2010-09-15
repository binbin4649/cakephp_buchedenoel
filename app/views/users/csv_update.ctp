<div class="users form">
<?php  if(!empty($Message)) echo $Message; ?>
<?php echo $form->create('User',array('type'=>'file','url'=>'csv_update'));?>
	<fieldset>
 		<legend><?php __('CSV Update User');?></legend>
		<?php

		echo $form->input('User.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>

<ul>
	<li>【開発メモ】給与奉行の所属コードの4番目はバイトかどうかを区別しているだけのようなので、システムは考慮していない。ちなみに5番目は全無視。</li>
	<li>ログインID(username)、パスワード(password)、備考(remarks)、は新規登録時以外は上書きされない。</li>
</ul>