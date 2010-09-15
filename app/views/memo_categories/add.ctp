<div class="memoCategories form">
<p><?php echo $html->link(__('List MemoCategories', true), array('action'=>'index'));?></p>
<?php echo $form->create('MemoCategory');?>
	<fieldset>
 		<legend><?php __('Add MemoCategory');?></legend>
	<?php
		echo $form->input('MemoCategory.name', array('label'=>__('Memo Category Name', true)));
		echo $form->input('MemoCategory.memo_sections_id', array(
			'type'=>'select',
			'options'=>$memoSections,
			'div'=>true,
			'label'=>__('Memo Sections', true),
			'empty'=>__('(Please Select)', true)
		));
	?>
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List MemoCategories', true), array('action'=>'index'));?></li>
	</ul>
</div>
