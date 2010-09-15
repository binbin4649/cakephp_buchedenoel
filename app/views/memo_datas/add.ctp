<div class="memoDatas form">
<p><?php echo $html->link(__('<< List Board Index', true), array('action'=>'index')); ?> </p>

<p><?php echo @$html->link('< '.$sectionName.'index', array('action'=>'section_index/'.$this->params['pass'][0])); ?> </p>

<h2>
<?php
__('Board:New Posts:');
echo $sectionName;
?>
</h2>
<?php echo $form->create('MemoData', array('type'=>'file'));?>
	<fieldset>
 		<legend><?php __('Add MemoData');?></legend>
	<?php
		echo $form->input('MemoData.name', array(
			'label'=>__('Title', true),
			'size'=>50
		));
		echo $form->input('MemoData.memo_category_id', array(
			'label'=>__('Category', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('MemoData.top_flag', array(
			'type'=>'select',
			'options'=>$topFlag,
			'div'=>true,
			'label'=>__('Top Flag', true),
			'empty'=>__('(Please Select)', true)
		));
		//echo $form->input('MemoData.dev_status');
		echo $form->input('MemoData.contents', array(
			'type'=>'textarea',
			'label'=>__('Contents', true),
			'rows'=>10,
			'cols'=>80
		));
		//echo $form->input('MemoData.reply');
		echo $form->input('MemoData.upload_file',array('label'=>'Upload File','type'=>'file'));
	?>
	<?php echo $form->end(__('New Posts', true));?>
	</fieldset>
</div>
<ul>
	<li>タイトルとカテゴリーは必須。</li>
	<li>アップロード可能なファイルは「gif, jpeg, jpg, png, doc, xls, pdf, ppt, zip」。サイズは8MBまで。</li>
	<li>アップロードするファイルのファイル名は、半角英数、ドット.、ハイフン-、アンダースコア_、以外は自動削除されます。全部日本語の場合は日時のみのファイル名になります。</li>
</ul>