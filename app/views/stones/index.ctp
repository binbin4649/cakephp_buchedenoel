<div class="stones index">
<p><a href="/buchedenoel/pages/masters">商品マスタ一覧</a></p>
<h2><?php __('Stones');?></h2>
<?php
$modelName = 'Stone';
echo $form->create($modelName ,array('action'=>'index'));
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
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Stone Name', true),'name');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Edit');?></th>
</tr>
<?php
$i = 0;
foreach ($stones as $stone):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $stone['Stone']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($stone['Stone']['name'], array('action'=>'view', $stone['Stone']['id'])); ?>
		</td>
		<td>
			<?php echo $stone['Stone']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $stone['Stone']['id'])); ?>
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
		<li><?php echo $html->link(__('New Stone', true), array('action'=>'add')); ?></li>
	</ul>
</div>
