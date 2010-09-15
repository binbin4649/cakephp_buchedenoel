<div class="sales index">
<h2><?php __('Sales');?></h2>
<?php
$modelName = 'Sale';
echo $form->create($modelName ,array('action'=>'index'));
echo __('Id');
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>3,
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
echo __('Destination');
echo $form->text($modelName.'.destination', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.sale_type', array(
	'type'=>'select',
	'options'=>$saleType,
	'label'=>'Type',
	'empty'=>__('(Select)', true),
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
echo '<br><br>売上日';
echo $form->input('Sale.start_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>'2009',
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input('Sale.end_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>'2009',
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
	<th><?php echo $paginator->sort('sale_type');?></th>
	<th><?php echo $paginator->sort(__('Status', true),'sale_status');?></th>
	<th><?php echo $paginator->sort('depot_id');?></th>
	<th><?php echo $paginator->sort('destination_id');?></th>

	<th><?php echo $paginator->sort('Total');?></th>

	<th><?php echo $paginator->sort(__('Sale Date', true),'date');?></th>
	<th><?php echo $paginator->sort('total_day');?></th>
	<th><?php echo $paginator->sort(__('Partners No.', true),'partners_no');?></th>
</tr>
<?php
$i = 0;
foreach ($sales as $sale):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($sale['Sale']['id'], array('action'=>'view', $sale['Sale']['id'])); ?>
		</td>
		<td>
			<?php echo $saleType[$sale['Sale']['sale_type']]; ?>
		</td>
		<td>
			<?php echo $saleStatus[$sale['Sale']['sale_status']]; ?>
		</td>
		<td>
			<?php echo $sale['Sale']['depot_id']; ?>
		</td>
		<td>
			<?php echo mb_substr($sale['Destination']['name'], 0, 10); ?>
		</td>
		<td>
			<?php echo number_format($sale['Sale']['total']); ?>
		</td>
		<td>
			<?php echo $sale['Sale']['date']; ?>
		</td>
		<td>
			<?php echo $sale['Sale']['total_day']; ?>
		</td>
		<td>
			<?php echo $sale['Sale']['partners_no']; ?>
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
