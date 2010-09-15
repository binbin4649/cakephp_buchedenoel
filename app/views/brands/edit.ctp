<div class="brands form">
<p><?php echo $html->link(__('List Brands', true), array('action'=>'index'));?></p>
<?php echo $form->create('Brand');?>
	<fieldset>
 		<legend><?php __('Edit Brand');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array(
			'label'=>__('Brand Name', true),
			'size'=>35
		));
		echo '<div class="separater"><p>Only Anniversary</p>';
		echo $form->input('temporary_costrate', array(
			'label'=>__('Temporary Costrate', true),
			'size'=>5
		));
		echo '</div>';
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Brand.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Brand.id'))); ?></li>
		<li><?php echo $html->link(__('List Brands', true), array('action'=>'index'));?></li>
	</ul>
</div>
<ul>
	<li>Temporary Costrate(仮原価率):入力例1）50% = 500　例2）45.9% = 459</li>
</ul>
