<div class="orderDateils index">
<h2><?php __('OrderDateils');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('order_id');?></th>
	<th><?php echo $paginator->sort('detail_no');?></th>
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('size');?></th>
	<th><?php echo $paginator->sort('lot_type');?></th>
	<th><?php echo $paginator->sort('specified_date');?></th>
	<th><?php echo $paginator->sort('store_arrival_date');?></th>
	<th><?php echo $paginator->sort('stock_date');?></th>
	<th><?php echo $paginator->sort('shipping_date');?></th>
	<th><?php echo $paginator->sort('bid');?></th>
	<th><?php echo $paginator->sort('bid_quantity');?></th>
	<th><?php echo $paginator->sort('cost');?></th>
	<th><?php echo $paginator->sort('tax');?></th>
	<th><?php echo $paginator->sort('pairing_quantity');?></th>
	<th><?php echo $paginator->sort('ordering_quantity');?></th>
	<th><?php echo $paginator->sort('sell_quantity');?></th>
	<th><?php echo $paginator->sort('marking');?></th>
	<th><?php echo $paginator->sort('transport_dateil_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($orderDateils as $orderDateil):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $orderDateil['OrderDateil']['id']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['order_id']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['detail_no']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['item_id']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['subitem_id']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['size']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['lot_type']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['specified_date']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['store_arrival_date']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['stock_date']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['shipping_date']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['bid']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['bid_quantity']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['cost']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['tax']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['pairing_quantity']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['ordering_quantity']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['sell_quantity']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['marking']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['transport_dateil_id']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['created']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['created_user']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['updated']; ?>
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['updated_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $orderDateil['OrderDateil']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $orderDateil['OrderDateil']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $orderDateil['OrderDateil']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderDateil['OrderDateil']['id'])); ?>
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
		<li><?php echo $html->link(__('New OrderDateil', true), array('action'=>'add')); ?></li>
	</ul>
</div>
