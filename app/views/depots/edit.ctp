<div class="depots form">
<?php echo $form->create('Depot');?>
	<fieldset>
 		<legend><?php __('Edit Depot');?></legend>
	<?php
		echo $form->input('id');
		echo '<div class="input"><label>'.$this->data['Section']['id'].':</label>';
		echo $html->link($this->data['Section']['name'], array('controller'=> 'sections', 'action'=>'view', $this->data['Section']['id']));
		echo '</div>';
		echo $form->hidden('section_id', array(
			'value'=>$this->data['Section']['id']
		));

		echo $form->input('name', array(
			'label'=>__('Depot Name', true),
			'size'=>20
		));
		echo $form->input('old_system_no');
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Depots', true), array('action'=>'index'));?></li>
	</ul>
</div>
