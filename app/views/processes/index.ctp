<div class="processes index">
<p><a href="/'.SITE_DIR.'/pages/masters">商品マスタ一覧</a></p>
<h2><?php __('Processes');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Process Name', true),'name');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Edit');?></th>
</tr>
<?php
$i = 0;
foreach ($processes as $process):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $process['Process']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($process['Process']['name'], array('action'=>'view', $process['Process']['id'])); ?>
		</td>
		<td>
			<?php echo $process['Process']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $process['Process']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< previous', array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next('next >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Process', true), array('action'=>'add')); ?></li>
	</ul>
</div>
