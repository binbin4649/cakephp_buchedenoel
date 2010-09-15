<div class="tagsItems form">
<?php echo $form->create('TagsItem');?>
	<fieldset>
 		<legend><?php __('Add TagsItem');?></legend>
	<?php
		echo $form->input('item_id');
		echo $form->input('tag_id');
		echo $form->input('created_user');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List TagsItems', true), array('action'=>'index'));?></li>
	</ul>
</div>
