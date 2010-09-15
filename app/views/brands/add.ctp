<div class="brands form">
<p><?php echo $html->link(__('List Brands', true), array('action'=>'index'));?></p>
<?php echo $form->create('Brand');?>
	<fieldset>
 		<legend><?php __('Add Brand');?></legend>
	<?php
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
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<ul>
	<li>Temporary Costrate:仮原価率</li>
</ul>
