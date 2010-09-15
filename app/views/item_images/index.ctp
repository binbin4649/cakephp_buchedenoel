<div class="itemImages index">
<h2><?php __('ItemImages');?></h2>
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
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($itemImages as $itemImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $itemImage['ItemImage']['id']; ?>
		</td>
		<td>
			<?php echo $itemImage['ItemImage']['name']; ?>
		</td>
		<td>
			<?php echo $html->link($itemImage['Item']['name'], array('controller'=> 'items', 'action'=>'view', $itemImage['Item']['id'])); ?>
		</td>
		<td>
			<?php echo $itemImage['ItemImage']['created']; ?>
		</td>
		<td>
			<?php echo $itemImage['ItemImage']['created_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $itemImage['ItemImage']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $itemImage['ItemImage']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $itemImage['ItemImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $itemImage['ItemImage']['id'])); ?>
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
		<li><?php echo $html->link(__('New ItemImage', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Items', true), array('controller'=> 'items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Item', true), array('controller'=> 'items', 'action'=>'add')); ?> </li>
	</ul>
</div>
