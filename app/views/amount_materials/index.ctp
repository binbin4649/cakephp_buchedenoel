<div class="amountMaterials index">
<h2><?php __('AmountMaterials');?></h2>
<?php
$modelName = 'AmountMaterial';
$subModel = 'Material';
$sub_id = 'material_id';
echo $form->create($modelName ,array('action'=>'index'));
echo $form->input($modelName.'.'.$sub_id, array(
	'type'=>'select',
	'label'=>$subModel,
	'div'=>false,
	'empty'=>__('(Select)', true),
	'options'=>$materials,
));
echo '　';
echo $form->input($modelName.'.amount_type', array(
	'type'=>'select',
	'options'=>$amountType,
	'label'=>'Amount Type',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '<br><br>開始日';
echo $form->input($modelName.'.start_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>'2006',
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '　終了日';
echo $form->input($modelName.'.end_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>'2006',
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
echo $form->end();
?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('full_amount');?></th>
	<th><?php echo $paginator->sort('cost_amount');?></th>
	<th><?php echo $paginator->sort('purchase_amount');?></th>
	<th><?php echo $paginator->sort('stock_cost_amount');?></th>
</tr>
<?php
$i = 0;
foreach ($amountMaterials as $amountMaterial):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $amountMaterial['AmountMaterial']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($amountMaterial['AmountMaterial']['name'], array('action'=>'edit', $amountMaterial['AmountMaterial']['id'])); ?>
		</td>
		<td>
			<?php echo $amountMaterial['AmountMaterial']['full_amount']; ?>
		</td>
		<td>
			<?php echo $amountMaterial['AmountMaterial']['cost_amount']; ?>
		</td>
		<td>
			<?php echo $amountMaterial['AmountMaterial']['purchase_amount']; ?>
		</td>
		<td>
			<?php echo $amountMaterial['AmountMaterial']['stock_cost_amount']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New AmountMaterial', true), array('action'=>'add')); ?></li>
	</ul>
</div>
