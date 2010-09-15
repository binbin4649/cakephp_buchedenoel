<div class="index">
<p><?php echo $html->link(__('PriceTag Add', true), array('controller'=> 'pricetag_details', 'action'=>'add')); ?> </p>
<h2><?php __('Tag Order List');?></h2>
<?php
$modelName = 'Pricetag';
echo $form->create($modelName ,array('action'=>'index'));
echo $form->text($modelName.'.word');
echo '　';
echo $form->input($modelName.'.status', array(
	'type'=>'select',
	'options'=>$status,
	'label'=>__('Status', true),
	'empty'=>__('(Please Select)', true),
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
	<th><?php echo $paginator->sort(__('Status', true),'pricetag_status');?></th>
	<th><?php echo $paginator->sort('section_id');?></th>
	<th><?php echo $paginator->sort('total_quantity');?></th>
	<th><?php echo $paginator->sort('created');?></th>
</tr>
<?php
$i = 0;
foreach ($pricetags as $pricetag):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($pricetag['Pricetag']['id'], array('action'=>'view', $pricetag['Pricetag']['id'])); ?>
		</td>
		<td>
			<?php echo $status[$pricetag['Pricetag']['pricetag_status']]; ?>
		</td>
		<td>
			<?php echo $pricetag['Section']['name']; ?>
		</td>
		<td>
			<?php echo $pricetag['Pricetag']['total_quantity']; ?>
		</td>
		<td>
			<?php echo $pricetag['Pricetag']['created']; ?>
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