<div class="tags form">
<p><?php echo $html->link(__('List Tags', true), array('action'=>'index'));?></p>
<?php echo $form->create('Tag');?>
	<fieldset>
 		<legend><?php __('Add Tag');?></legend>
	<?php
		echo $form->input('name', array(
			'label'=>__('Tag Name', true),
			'size'=>20
		));
	?>
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Tags', true), array('action'=>'index'));?></li>
	</ul>
</div>
