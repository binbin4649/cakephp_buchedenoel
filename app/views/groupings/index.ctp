<div class="groupings index">
<h2><?php __('Groupings');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Grouping Name', true),'name');?></th>
	<th><?php echo $paginator->sort('cancel_flag');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($groupings as $grouping):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $grouping['Grouping']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($grouping['Grouping']['name'], array('action'=>'edit', $grouping['Grouping']['id'])); ?>
		</td>
		<td>
			<?php echo $grouping['Grouping']['cancel_flag']; ?>
		</td>
		<td>
			<?php echo $grouping['Grouping']['updated']; ?>
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
		<li><?php echo $html->link(__('New Grouping', true), array('action'=>'add')); ?></li>
	</ul>
</div>
