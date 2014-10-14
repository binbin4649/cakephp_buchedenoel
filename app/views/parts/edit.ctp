<script type="text/javascript">
$(function() {
  $('#getData').autocomplete('/'.SITE_DIR.'/order_dateils/getData');
});
</script>

<?php
echo $javascript->link("jquery",false);
echo $javascript->link("jquery.autocomplete",false);
?>
<div class="parts form">
<?php echo $form->create('Part');?>
	<fieldset>
 		<legend><?php __('Edit Part');?></legend>
 			<p><?php __('Parent Item:');?><?php echo $html->link($rootItem['Item']['name'], array('controller'=> 'items', 'action'=>'view', $rootItem['Item']['id'])); ?></p>
 			<p><?php __('Child Item:');?><?php echo $html->link($subitem['Subitem']['name'], array('controller'=> 'subitems', 'action'=>'view', $subitem['Subitem']['id'])); ?></p>
 	<label>Part ID</label>
 	<p><?php echo $this->data['Part']['id']; ?></p>
 	<label><?php __('Item Name');?></label>
	<?php
		echo $form->input('id');
		echo $form->input('Part.AutoItemName', array('type'=>'text','div'=>false,'label'=>false,'size'=>30,'id'=>'getData','value'=>$item['Item']['name']));
		echo $form->input('Part.quantity', array(
			'label'=>__('Quantity', true),
			'size'=>4
		));
		echo $form->input('Part.supply_code', array(
			'type'=>'select',
			'options'=>$supplyCode,
			'div'=>true,
			'label'=>__('Supply Code', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->hidden('Part.subitem_id', array(
			'value'=>$subitem['Subitem']['id']
		));
	?>
	</fieldset>
<?php echo $form->end(__('Edit', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Part.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Part.id'))); ?></li>
	</ul>
</div>
