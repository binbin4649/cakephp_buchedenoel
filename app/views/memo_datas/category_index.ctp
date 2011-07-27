<div class="memoDatas index">
<p><?php echo $html->link(__('<< List Board Index', true), array('action'=>'index'));?></p>
<p><?php echo $html->link('< '.$sectionName.'index', array('action'=>'section_index/'.$categoryName['memo_sections_id'])); ?></p>
<h2><?php echo $sectionName.':'.$categoryName['name']; ?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('*');?></th>
	<th><?php __('Title');?></th>
	<th><?php __('Category');?></th>
	<th><?php __('top_flag');?></th>
	<th><?php __('created_user');?></th>
	<th><?php __('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($memoDatas as $memoData):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $memoData['MemoData']['id']; ?>
		</td>
		<td>
			<?php echo $html->link(mb_substr($memoData['MemoData']['name'], 0, 20), array('action'=>'view', $memoData['MemoData']['id'])); ?>
		</td>
		<td>
			<?php echo $memoCategories[$memoData['MemoData']['memo_category_id']]; ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['top_flag']; ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['created_user_section']; ?>:
			<?php echo $memoData['MemoData']['created_user']; ?>
		</td>
		<td>
			<?php echo mb_substr($memoData['MemoData']['updated'], 5, 11); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php  $paginator->options(array('url' => $this->params['pass'][0])); ?>
	<?php echo $paginator->prev('<< previous', array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next('next >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New MemoData', true), array('action'=>'add/'.$categoryName['memo_sections_id'])); ?></li>
	</ul>
</div>