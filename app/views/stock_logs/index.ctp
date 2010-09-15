<div class="stockLogs index">
<h2><?php __('StockLogs');?></h2>
<?php
$modelName = 'StockLog';
echo $form->create($modelName ,array('action'=>'index'));
echo '子品番名';
echo $form->text($modelName.'.subitem', array(
	'type'=>'text',
	'size'=>7,
	'div'=>false
));
echo '　';
echo '倉庫id';
echo $form->text($modelName.'.depot', array(
	'type'=>'text',
	'size'=>7,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.plus', array(
	'type'=>'select',
	'options'=>$logPlus,
	'label'=>'Plus',
	'empty'=>__('(Please Select)', true),
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.mimus', array(
	'type'=>'select',
	'options'=>$logMimus,
	'label'=>'Mimus',
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
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('depot_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('plus');?></th>
	<th><?php echo $paginator->sort('mimus');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
</tr>
<?php
$i = 0;
foreach ($stockLogs as $stockLog):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($stockLog['Subitem']['name'], array('controller'=>'subitems', 'action'=>'view', $stockLog['StockLog']['subitem_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($stockLog['StockLog']['depot_id'], array('controller'=>'sections', 'action'=>'view', $stockLog['Depot']['section_id'])); ?>
		</td>
		<td>
			<?php echo $stockLog['StockLog']['quantity']; ?>
		</td>
		<td>
			<?php if(!empty($stockLog['StockLog']['plus'])) echo $logPlus[$stockLog['StockLog']['plus']]; ?>
		</td>
		<td>
			<?php if(!empty($stockLog['StockLog']['mimus'])) echo $logMimus[$stockLog['StockLog']['mimus']]; ?>
		</td>
		<td>
			<?php echo $stockLog['StockLog']['created']; ?>
		</td>
		<td>
			<?php echo $stockLog['User']['name']; ?>
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
	<li>検索は絞込み検索（AND検索）です。</li>
	<li>子品番検索は、子品番の一部だけでも検索できます。</li>
	<li>倉庫検索は、倉庫番号での検索です。</li>
</ul>
<?php //pr($stockLog); ?>