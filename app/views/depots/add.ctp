<div class="depots form">
<?php echo $form->create('Depot');?>
	<fieldset>
 		<legend><?php __('Add Depot');?></legend>
	<?php

		if($section){
			echo '<div class="input"><label>'.$section['Section']['id'].':</label>';
			echo $html->link($section['Section']['name'], array('controller'=> 'sections', 'action'=>'view', $section['Section']['id']));
			echo '</div>';
			echo $form->hidden('section_id', array(
				'value'=>$section['Section']['id']
			));
		}else{
			echo $form->input('section_id');
		}
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
