<div class="inventories index">
<h2><?php __('Inventories');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('depot_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($inventories as $inventory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $inventory['Inventory']['id']; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['subitem_id']; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['depot_id']; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['quantity']; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['created']; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['created_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $inventory['Inventory']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $inventory['Inventory']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $inventory['Inventory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inventory['Inventory']['id'])); ?>
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
		<li><?php echo $html->link(__('New Inventory', true), array('action'=>'add')); ?></li>
	</ul>
</div>
