<div class="factories index">
<p><a href="/'.SITE_DIR.'/pages/masters">商品マスタ一覧</a></p>
<h2><?php __('Factories');?></h2>
<?php
$modelName = 'Factory';
echo $form->create($modelName ,array('action'=>'index'));
echo $form->text($modelName.'.word');
echo '　';
echo $form->submit('Seach', array('div'=>false));
echo '<br>';
echo $form->checkbox($modelName.'.trading_flag');
echo '停止を含む';
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
	<th><?php echo $paginator->sort(__('*', true), 'id');?></th>
	<th><?php echo $paginator->sort(__('Factory Name', true), 'name');?></th>
	<th><?php echo $paginator->sort(__('Trading Flag', true), 'trading_flag');?></th>
	<th><?php echo $paginator->sort(__('Updated', true), 'updated');?></th>
</tr>
<?php
$i = 0;
foreach ($factories as $factory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $factory['Factory']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($factory['Factory']['name'], array('action'=>'view', $factory['Factory']['id'])); ?>
		</td>
		<td>
			<?php if(!empty($factory['Factory']['trading_flag'])) echo $trading_flag[$factory['Factory']['trading_flag']] ?>
		</td>
		<td>
			<?php echo substr($factory['Factory']['updated'], 0, 10); ?>
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
		<li><?php echo $html->link(__('New Factory', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<hr>
<ul>
	<li>IDまたは名前で検索できます。</li>
</ul>