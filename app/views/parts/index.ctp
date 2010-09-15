<div class="parts index">
<h2><?php __('Parts');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('supply_code');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($parts as $part):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $part['Part']['id']; ?>
		</td>
		<td>
			<?php echo $part['Part']['item_id']; ?>
		</td>
		<td>
			<?php echo $html->link($part['Subitem']['name'], array('controller'=> 'subitems', 'action'=>'view', $part['Subitem']['id'])); ?>
		</td>
		<td>
			<?php echo $part['Part']['quantity']; ?>
		</td>
		<td>
			<?php echo $part['Part']['supply_code']; ?>
		</td>
		<td>
			<?php echo $part['Part']['created']; ?>
		</td>
		<td>
			<?php echo $part['Part']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $part['Part']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $part['Part']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $part['Part']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $part['Part']['id'])); ?>
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
		<li><?php echo $html->link(__('New Part', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Subitems', true), array('controller'=> 'subitems', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Subitem', true), array('controller'=> 'subitems', 'action'=>'add')); ?> </li>
	</ul>
</div>
