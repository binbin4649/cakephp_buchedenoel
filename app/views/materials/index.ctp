<div class="materials index">
<p><a href="/'.SITE_DIR.'/pages/masters">商品マスタ一覧</a></p>
<h2><?php __('Materials');?></h2>
<?php
$modelName = 'Material';
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
	<th><?php echo $paginator->sort('*');?></th>
	<th><?php echo $paginator->sort('Material name');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Edit');?></th>
</tr>
<?php
$i = 0;
foreach ($materials as $material):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $material['Material']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($material['Material']['name'], array('action'=>'view', $material['Material']['id'])); ?>
		</td>
		<td>
			<?php echo $material['Material']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link('Edit', array('action'=>'edit', $material['Material']['id'])); ?>
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
		<li><?php echo $html->link(__('New Material', true), array('action'=>'add')); ?></li>
	</ul>
</div>
