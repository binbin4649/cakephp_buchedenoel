<div class="daysCoordinations index">
<h2><?php __('DaysCoordinations');?></h2>
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
	<th><?php echo $paginator->sort('apply_approve');?></th>
	<th><?php echo $paginator->sort('coordination_approve');?></th>
	<th><?php echo $paginator->sort('start_datetime');?></th>
	<th><?php echo $paginator->sort('end_datetime');?></th>
	<th><?php echo $paginator->sort('apply_day');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th><?php echo $paginator->sort('deleted');?></th>
	<th><?php echo $paginator->sort('deleted_date');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($daysCoordinations as $daysCoordination):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['id']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['name']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['apply_approve']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['coordination_approve']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['start_datetime']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['end_datetime']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['apply_day']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['created']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['created_user']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['updated']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['updated_user']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['deleted']; ?>
		</td>
		<td>
			<?php echo $daysCoordination['DaysCoordination']['deleted_date']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $daysCoordination['DaysCoordination']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $daysCoordination['DaysCoordination']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $daysCoordination['DaysCoordination']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $daysCoordination['DaysCoordination']['id'])); ?>
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
		<li><?php echo $html->link(__('New DaysCoordination', true), array('action'=>'add')); ?></li>
	</ul>
</div>
