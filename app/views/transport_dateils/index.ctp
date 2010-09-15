<div class="transportDateils index">
<h2><?php __('TransportDateils');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('transport_id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('pairing_quantity');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($transportDateils as $transportDateil):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $transportDateil['TransportDateil']['id']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['transport_id']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['subitem_id']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['quantity']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['pairing_quantity']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['created']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['created_user']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['updated']; ?>
		</td>
		<td>
			<?php echo $transportDateil['TransportDateil']['updated_user']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $transportDateil['TransportDateil']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $transportDateil['TransportDateil']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $transportDateil['TransportDateil']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $transportDateil['TransportDateil']['id'])); ?>
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
		<li><?php echo $html->link(__('New TransportDateil', true), array('action'=>'add')); ?></li>
	</ul>
</div>
