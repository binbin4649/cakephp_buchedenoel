<div class="memoCategories index">
<h2><?php __('MemoCategories');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Memo Category Name', true),'name');?></th>
	<th><?php echo $paginator->sort(__('Memo Sections', true),'memo_sections_id');?></th>
	<th><?php echo $paginator->sort(__('Updated', true),'updated');?></th>
</tr>
<?php
$i = 0;
foreach ($memoCategories as $memoCategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $memoCategory['MemoCategory']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($memoCategory['MemoCategory']['name'], array('action'=>'view', $memoCategory['MemoCategory']['id'])); ?>
		</td>
		<td>
			<?php echo $memoCategory['MemoCategory']['memo_sections_id']; ?>
		</td>
		<td>
			<?php echo $memoCategory['MemoCategory']['updated']; ?>
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
		<li><?php echo $html->link(__('New MemoCategory', true), array('action'=>'add')); ?></li>
	</ul>
</div>
