<div class="sales index">
<h2><?php __('Sales');?></h2>
<?php
$modelName = 'Sale';
echo $form->create($modelName ,array('action'=>'store_index'));
echo __('Id');
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>1,
	'div'=>false
));
echo '　';
echo __('Depot');
echo $form->text($modelName.'.depot', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo __('Contact1');
echo $form->text($modelName.'.contact1', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.sale_status', array(
	'type'=>'select',
	'options'=>$saleStatus,
	'label'=>'Status',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<p>
<?php
echo '売上日';
echo $form->input('Sale.start_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input('Sale.end_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo $form->end();
?>
</p>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th>状態・区分</th>
	<th><?php echo $paginator->sort('depot_id');?></th>
	<th><?php echo $paginator->sort(__('Sale Date', true),'date');?></th>
	<th><?php echo $paginator->sort(__('Total', true),'total');?></th>
	<th><?php echo $paginator->sort(__('Contact1', true),'contact1');?></th>
</tr>
<?php
$i = 0;
foreach ($sales as $sale):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if($sale['Sale']['sale_type'] == '3'){
		$type_status = '社販';
	}else{
		$type_status = $saleStatus[$sale['Sale']['sale_status']];
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($sale['Sale']['id'], array('action'=>'view', $sale['Sale']['id'])); ?>
		</td>
		<td>
			<?php echo $type_status; ?>
		</td>
		<td>
			<?php echo $sale['Depot']['name'].':'.$sale['Sale']['depot_id']; ?>
		</td>
		<td>
			<?php echo $sale['Sale']['date']; ?>
		</td>
		<td>
			<?php echo number_format($sale['Sale']['total']); ?>
		</td>
		<td>
			<?php echo $sale['User']['User']['name']; ?>
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
<p><?php echo '合計金額：'.number_format($totalTotal); ?></p>
