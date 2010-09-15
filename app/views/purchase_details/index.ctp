<div class="purchaseDetails index">
<h2><?php __('PurchaseDetails');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('purchase_id');?></th>
	<th><?php echo $paginator->sort('order_id');?></th>
	<th><?php echo $paginator->sort('order_dateil_id');?></th>
	<th><?php echo $paginator->sort('ordering_id');?></th>
	<th><?php echo $paginator->sort('ordering_dateil_id');?></th>
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('size');?></th>
	<th><?php echo $paginator->sort('bid');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('pay_quantity');?></th>
	<th><?php echo $paginator->sort('gram');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($purchaseDetails as $purchaseDetail):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($purchaseDetail['Purchase']['id'], array('controller'=> 'purchases', 'action'=>'view', $purchaseDetail['Purchase']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($purchaseDetail['Order']['id'], array('controller'=> 'orders', 'action'=>'view', $purchaseDetail['Order']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($purchaseDetail['OrderDateil']['id'], array('controller'=> 'order_dateils', 'action'=>'view', $purchaseDetail['OrderDateil']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($purchaseDetail['Ordering']['id'], array('controller'=> 'orderings', 'action'=>'view', $purchaseDetail['Ordering']['id'])); ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['ordering_dateil_id']; ?>
		</td>
		<td>
			<?php echo $html->link($purchaseDetail['Item']['title'], array('controller'=> 'items', 'action'=>'view', $purchaseDetail['Item']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($purchaseDetail['Subitem']['name'], array('controller'=> 'subitems', 'action'=>'view', $purchaseDetail['Subitem']['id'])); ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['size']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['bid']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['quantity']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['pay_quantity']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['gram']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['created']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['created_user']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['updated']; ?>
		</td>
		<td>
			<?php echo $purchaseDetail['PurchaseDetail']['updated_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $purchaseDetail['PurchaseDetail']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $purchaseDetail['PurchaseDetail']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $purchaseDetail['PurchaseDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $purchaseDetail['PurchaseDetail']['id'])); ?>
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
		<li><?php echo $html->link(__('New PurchaseDetail', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Purchases', true), array('controller'=> 'purchases', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Purchase', true), array('controller'=> 'purchases', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Orders', true), array('controller'=> 'orders', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Order', true), array('controller'=> 'orders', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Order Dateils', true), array('controller'=> 'order_dateils', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Order Dateil', true), array('controller'=> 'order_dateils', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Orderings', true), array('controller'=> 'orderings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Ordering', true), array('controller'=> 'orderings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Items', true), array('controller'=> 'items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Item', true), array('controller'=> 'items', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Subitems', true), array('controller'=> 'subitems', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Subitem', true), array('controller'=> 'subitems', 'action'=>'add')); ?> </li>
	</ul>
</div>
