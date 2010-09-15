<div class="subitems form">
<?php echo $form->create('Subitem');?>
	<fieldset>
 		<legend><?php __('Edit Subitem');?></legend>
 		<p><?php __('Parent Item:');?><?php echo $html->link($this->data['Item']['name'], array('controller'=> 'items', 'action'=>'view', $this->data['Item']['id'])); ?></p>
	<?php
		echo $form->input('id');
		echo $form->input('Subitem.name', array(
			'label'=>__('Subitem Name', true),
			'size'=>30
		));
		echo '<div class="input"><label>'.__('JAN Code', true).'</label>'.$this->data['Subitem']['jan'].'　</div>';
		echo $form->input('Subitem.major_size', array(
			'type'=>'select',
			'options'=>$majorSize,
			'div'=>true,
			'label'=>__('Major Size', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.minority_size', array(
			'label'=>__('Minority Size', true),
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
		echo '<div class="input"><label>'.__('Seller Data', true).'</label>'.$this->data['Subitem']['selldata_id'].'　</div>';
		echo $form->hidden('Subitem.item_id', array(
			'value'=>$this->data['Item']['id']
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
		echo $form->input('Subitem.stone_cost', array(
			'label'=>__('Stone Cost', true),
			'size'=>10
		));
		echo $form->input('Subitem.grade_report', array(
			'label'=>__('Grade Report', true),
			'size'=>25
		));
		echo $form->input('Subitem.grade_cost', array(
			'label'=>__('Grade Cost', true),
			'size'=>10
		));
		echo $form->input('Subitem.metal_gram', array(
			'label'=>__('Metal Gram', true),
			'size'=>5,
			'after'=>'g'
		));
		echo $form->input('Subitem.metal_cost', array(
			'label'=>__('Metal Cost', true),
			'size'=>10
		));
		echo '</div>';
		echo $form->end(__('Edit', true));
	?>
	</fieldset>
<?php ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Subitem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Subitem.id'))); ?></li>
	</ul>
</div>
<hr>
<ul>
	<li>基本サイズ「その他」を選択すると、基本サイズ外の内容が適用されます。</li>
</ul>
