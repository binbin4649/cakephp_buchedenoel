<div class="memoDatas form">
<p><?php echo $html->link(__('<<< List Board Index', true), array('action'=>'index')); ?> </p>
<p><?php echo $html->link('<< '.$sectionName.'index', array('action'=>'section_index/'.$this->data['MemoCategory']['memo_sections_id'])); ?> </p>
<p><?php echo $html->link('< '.$this->data['MemoCategory']['name'].'index', array('action'=>'category_index/'.$this->data['MemoData']['memo_category_id'])); ?> </p>
<h2>
<?php
__('Board:Edit:');
echo $sectionName;
?>
</h2>
<?php echo $form->create('MemoData', array('type'=>'file'));?>
	<fieldset>
 		<legend><?php __('Add MemoData');?></legend>
	<?php
		echo $form->input('id');
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
		if(!empty($this->data['MemoData']['file'])){
			echo '<div class="input text"><label for="MemoDataName">File</label>';
			echo '<a href="/buchedenoel/files/memo/'.$this->data['MemoData']['file'].'" target="_blank">'.$this->data['MemoData']['file'].'</a>';
			echo '</div>';
			echo $form->hidden('MemoData.file', array(
				'value'=>$this->data['MemoData']['file']
			));
		}
		echo $form->input('MemoData.upload_file',array('label'=>'Upload File','type'=>'file'));
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('MemoData.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('MemoData.id'))); ?></li>
	</ul>
</div>
<ul>
	<li>添付ファイルは、追加ではなくて上書きされます。</li>
</ul>