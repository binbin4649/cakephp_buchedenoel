<div class="orderings index">
<h2><?php __('Orderings');?></h2>
<?php
$modelName = 'Ordering';
echo $form->create($modelName ,array('action'=>'index'));
echo $form->text($modelName.'.word');
echo '　';
echo $form->input($modelName.'.status', array(
	'type'=>'select',
	'options'=>$status,
	'label'=>__('Status', true),
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.orderings_type', array(
	'type'=>'select',
	'options'=>$type,
	'label'=>__('Ordering Type', true),
	'empty'=>__('(Select)', true),
	'div'=>false
));
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
	<th><?php echo $paginator->sort(__('Status', true),'ordering_status');?></th>
	<th><?php echo $paginator->sort(__('Ordering Type', true),'orderings_type');?></th>
	<th><?php echo $paginator->sort('factory_id');?></th>
	<th><?php echo $paginator->sort(__('Ordering Date', true),'date');?></th>
	<th><?php echo $paginator->sort('total');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($orderings as $ordering):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($ordering['Ordering']['id'], array('action'=>'view', $ordering['Ordering']['id'])); ?>
		</td>
		<td>
			<?php echo $ordering['Ordering']['ordering_status']; ?>
		</td>
		<td>
			<?php if(!empty($ordering['Ordering']['orderings_type'])) echo $type[$ordering['Ordering']['orderings_type']]; ?>
		</td>
		<td>
			<?php echo $ordering['Ordering']['factory_id']; ?>
		</td>
		<td>
			<?php echo $ordering['Ordering']['date']; ?>
		</td>
		<td>
			<?php echo number_format($ordering['Ordering']['total']); ?>
		</td>
		<td>
			<?php echo $ordering['Ordering']['updated']; ?>
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
<ul>
  <li>発注番号で検索できます。取消した発注を表示したいときは直接検索してください。</li>
  <li>並び順は、発注日順です。</li>
</ul>

