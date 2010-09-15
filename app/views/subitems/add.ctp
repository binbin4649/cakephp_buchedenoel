<div class="subitems form">
<?php echo $form->create('Subitem');?>
	<fieldset>
 		<legend><?php __('Add Subitem');?></legend>
 		<p><?php __('Parent Item:');?><?php echo $html->link($item['Item']['name'], array('controller'=> 'items', 'action'=>'view', $item['Item']['id'])); ?></p>
	<?php
		echo $form->input('id');
		echo $form->input('Subitem.name', array(
			'label'=>__('Subitem Name', true),
			'size'=>30,
			'value'=>$item['Item']['name']
		));
		echo $form->input('Subitem.major_size', array(
			'type'=>'select',
			'options'=>$majorSize,
			'div'=>true,
			'label'=>__('Major Size', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.minority_size', array(
			'label'=>__('Minority  Size', true),
			'size'=>10
		));
		echo $form->input('Subitem.name_kana', array('label'=>__('Name Kana', true)));
		echo $form->input('Subitem.labor_cost', array(
			'label'=>__('Purchase price', true),
			'size'=>8
		));
		echo $form->input('Subitem.supply_full_cost', array(
			'label'=>__('Supply Full Cost', true),
			'size'=>8
		));
		echo $form->input('Subitem.cost', array(
			'label'=>__('Average cost', true),
			'size'=>8
		));
				echo $form->input('Subitem.process_id', array(
			'label'=>__('Process', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.material_id', array(
			'label'=>__('Material', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.selldata_id', array('label'=>__('Seller Data', true)));
		echo $form->hidden('Subitem.item_id', array(
			'value'=>$item['Item']['id']
		));
		echo '<div class="separater"><p>Only Anniversary</p>';
		echo $form->input('Subitem.carat', array(
			'label'=>__('Carat', true),
			'size'=>4,
		));
		echo $form->input('Subitem.color', array(
			'type'=>'select',
			'options'=>$color,
			'div'=>true,
			'label'=>__('Color', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.clarity', array(
			'type'=>'select',
			'options'=>$clarity,
			'div'=>true,
			'label'=>__('Clarity', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.cut', array(
			'type'=>'select',
			'options'=>$cut,
			'div'=>true,
			'label'=>__('Cut', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.grade_report', array(
			'label'=>__('Grade Report', true),
			'size'=>25
		));
		echo '</div>';
		echo $form->end(__('Register', true));
	?>
	</fieldset>
</div>
