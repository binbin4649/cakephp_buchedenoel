<div class="salesDateils index">
<h2><?php __('SalesDateils');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('sales_id');?></th>
	<th><?php echo $paginator->sort('detail_no');?></th>
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('size');?></th>
	<th><?php echo $paginator->sort('bid');?></th>
	<th><?php echo $paginator->sort('bid_quantity');?></th>
	<th><?php echo $paginator->sort('cost');?></th>
	<th><?php echo $paginator->sort('tax');?></th>
	<th><?php echo $paginator->sort('marking');?></th>
	<th><?php echo $paginator->sort('credit_quantity');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($salesDateils as $salesDateil):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $salesDateil['SalesDateil']['id']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['sales_id']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['detail_no']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['item_id']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['subitem_id']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['size']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['bid']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['bid_quantity']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['cost']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['tax']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['marking']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['credit_quantity']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['created']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['created_user']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['updated']; ?>
		</td>
		<td>
			<?php echo $salesDateil['SalesDateil']['updated_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $salesDateil['SalesDateil']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $salesDateil['SalesDateil']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $salesDateil['SalesDateil']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $salesDateil['SalesDateil']['id'])); ?>
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
		<li><?php echo $html->link(__('New SalesDateil', true), array('action'=>'add')); ?></li>
	</ul>
</div>
