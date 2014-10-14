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
 		<legend><?php __('Add Part');?></legend>
 			<p><?php __('Parent Item:');?><?php echo $html->link($rootItem['Item']['name'], array('controller'=> 'items', 'action'=>'view', $rootItem['Item']['id'])); ?></p>
 			<p><?php __('Child Item:');?><?php echo $html->link($subitem['Subitem']['name'], array('controller'=> 'subitems', 'action'=>'view', $subitem['Subitem']['id'])); ?></p>
 			<label><?php __('Item Name');?></label>
	<?php echo $form->input('Part.AutoItemName', array('type'=>'text','div'=>false,'label'=>false,'size'=>30,'id'=>'getData')); ?>
	<?php
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
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<ul>
<li>部品に指定する品番は「完全一致」で入力して下さい。入力サポート機能があります。</li>
<li>取扱区分(Supply Code)はデフォルトで「支給品」です。</li>
</ul>

