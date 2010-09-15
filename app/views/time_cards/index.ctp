<div class="timeCards index">
<h2><?php __('TimeCards');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('chopping');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('chop_date');?></th>
	<th><?php echo $paginator->sort('ip_number');?></th>
	<th><?php echo $paginator->sort('remarks');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('deleted');?></th>
	<th><?php echo $paginator->sort('deleted_date');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($timeCards as $timeCard):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $timeCard['TimeCard']['id']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['chopping']; ?>
		</td>
		<td>
			<?php echo $html->link($timeCard['User']['name'], array('controller'=> 'users', 'action'=>'view', $timeCard['User']['id'])); ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['chop_date']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['ip_number']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['remarks']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['created_user']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['updated_user']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['created']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['updated']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['deleted']; ?>
		</td>
		<td>
			<?php echo $timeCard['TimeCard']['deleted_date']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $timeCard['TimeCard']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $timeCard['TimeCard']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $timeCard['TimeCard']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $timeCard['TimeCard']['id'])); ?>
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
		<li><?php echo $html->link(__('New TimeCard', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
