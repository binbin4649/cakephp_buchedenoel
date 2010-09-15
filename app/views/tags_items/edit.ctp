<div class="tagsItems form">
<?php echo $form->create('TagsItem');?>
	<fieldset>
 		<legend><?php __('Edit TagsItem');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('item_id');
		echo $form->input('tag_id');
		echo $form->input('created_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('TagsItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('TagsItem.id'))); ?></li>
		<li><?php echo $html->link(__('List TagsItems', true), array('action'=>'index'));?></li>
	</ul>
</div>
