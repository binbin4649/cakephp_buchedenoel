<div class="posts form">
<p><?php echo $html->link(__('List Posts', true), array('action'=>'index'));?></p>
<?php echo $form->create('Post');?>
	<fieldset>
 		<legend><?php __('Edit Post');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Post Name', true),
			'size'=>30,
		));
		echo $form->input('name_english', array(
			'label'=>__('English', true),
			'size'=>30,
		));
		echo $form->input('kyuuyo_bugyo_code', array(
			'label'=>__('Kyuuyo Bugyo', true),
			'size'=>30,
		));
		echo $form->input('list_order', array(
			'label'=>__('Order of Priority', true),
			'size'=>5,
		));
		echo $form->input('remarks', array(
			'label'=>__('Remarks', true)
		));
		echo $form->input('access_authority', array(
			'label'=>__('Access Authority', true)
		));
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Post.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Post.id'))); ?></li>
		<li><?php echo $html->link(__('List Posts', true), array('action'=>'index'));?></li>
	</ul>
</div>
