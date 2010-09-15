<?php //var_dump($memoData); ?>

<div class="memoDatas form">
<p><?php echo $html->link(__('<< List Board Index', true), array('action'=>'index')); ?> </p>
<p><?php echo $html->link('< '.$memoData['MemoCategory']['name'].'index', array('action'=>'category_index/'.$memoData['MemoCategory']['id'])); ?> </p>
<h2>
<?php
__('Board:Reply:');
echo $sectionName.':'.$memoData['MemoCategory']['name'];
?></h2>
<h4>Title</h4>
<div class="memodata">
<?php echo $memoData['MemoData']['name']; ?>
</div>
<h4>Contents</h4>
<div class="memodata">
<?php echo nl2br($memoData['MemoData']['contents']); ?>
</div>
<p>&nbsp;</p><p>&nbsp;</p>
<?php echo $form->create('MemoData', array('type'=>'file', 'action'=>'reply_add'));?>
	<fieldset>
 		<legend><?php __('Reply MemoData');?></legend>
	<?php
		echo $form->input('MemoData.name', array(
			'label'=>__('Title', true),
			'size'=>50,
			'value'=>'Re:'.$memoData['MemoData']['name']
		));

		echo $form->hidden('MemoData.memo_category_id', array(
			'value'=>$memoData['MemoData']['memo_category_id']
		));
		echo $form->hidden('MemoData.reply', array(
			'value'=>$memoData['MemoData']['id']
		));

		echo $form->input('MemoData.top_flag', array(
			'type'=>'select',
			'options'=>$topFlag,
			'div'=>true,
			'label'=>__('Top Flag', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('MemoData.contents', array(
			'type'=>'textarea',
			'label'=>__('Contents', true),
			'rows'=>10,
			'cols'=>80
		));
		echo $form->input('MemoData.upload_file',array('label'=>'Upload File','type'=>'file'));
	?>
	<?php echo $form->end(__('Reply', true));?>
	</fieldset>
</div>
<ul>
	<li>タイトルとカテゴリーは必須。</li>
	<li>アップロード可能なファイルは「gif, jpeg, jpg, png, doc, xls, pdf, ppt, zip」。サイズは8MBまで。</li>
	<li>アップロードするファイルのファイル名は半角英数で。一応記号も使えますが、油断しないようにお願いします。</li>
</ul>