<div class="invoiceDateils index">
<h2><?php __('InvoiceDateils');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('invoice_id');?></th>
	<th><?php echo $paginator->sort('detail_no');?></th>
	<th><?php echo $paginator->sort('sale_id');?></th>
	<th><?php echo $paginator->sort('sale_date');?></th>
	<th><?php echo $paginator->sort('sale_total');?></th>
	<th><?php echo $paginator->sort('sale_items');?></th>
	<th><?php echo $paginator->sort('tax');?></th>
	<th><?php echo $paginator->sort('shipping');?></th>
	<th><?php echo $paginator->sort('adjustment');?></th>
	<th><?php echo $paginator->sort('total_quantity');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($invoiceDateils as $invoiceDateil):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['id']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['invoice_id']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['detail_no']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['sale_id']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['sale_date']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['sale_total']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['sale_items']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['tax']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['shipping']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['adjustment']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['total_quantity']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['created']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['created_user']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['updated']; ?>
		</td>
		<td>
			<?php echo $invoiceDateil['InvoiceDateil']['updated_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $invoiceDateil['InvoiceDateil']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $invoiceDateil['InvoiceDateil']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $invoiceDateil['InvoiceDateil']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invoiceDateil['InvoiceDateil']['id'])); ?>
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
		<li><?php echo $html->link(__('New InvoiceDateil', true), array('action'=>'add')); ?></li>
	</ul>
</div>
