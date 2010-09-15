<div class="itemImages form">
<?php echo $form->create('ItemImage');?>
	<fieldset>
 		<legend><?php __('Edit ItemImage');?></legend>
	<?php
		echo $form->input('id');

		echo $html->link('< '.$this->data['Item']['name'], array('controller'=>'items', 'action'=>'view/'.$this->data['Item']['id']));
		echo '<br>';
		echo $html->image('/img/itemimage/'.$this->data['ItemImage']['id'].'.jpg', array('width'=>150, 'height'=>150));
		echo $form->input('name', array(
			'label'=>__('Image Comment', true),
			'size'=>40
		));
		echo $form->hidden('ItemImage.item_id', array(
			'value'=>$this->data['ItemImage']['item_id']
		));
	?>
	</fieldset>
<?php echo $form->end(__('Edit', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ItemImage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ItemImage.id'))); ?></li>
	</ul>
</div>
