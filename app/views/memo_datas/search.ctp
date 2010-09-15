<div class="memoDatas index">
<h2></h2>
<?php
$modelName = 'MemoData';
echo $form->create($modelName ,array('action'=>'search'));
echo $form->text($modelName.'.word');
echo '　';
echo $form->submit('Seach', array('div'=>false));
echo $form->end();
?>
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
			<?php echo $html->link($memoData['MemoData']['name'], array('action'=>'view', $memoData['MemoData']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($memoCategories[$memoData['MemoData']['memo_category_id']], array('action'=>'category_index', $memoData['MemoData']['memo_category_id'])); ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['top_flag']; ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['updated']; ?>
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
<hr>
<ul>
	<li>タイトルおよび内容を部分一致で検索できます。検索に多少時間がかかる場合がありますので、気長にお待ち下さい。</li>
</ul>