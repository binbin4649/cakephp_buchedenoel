<div class="stockRevisions index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('List StockRevision');?></h2>
<?php
$modelName = 'StockRevision';
echo $form->create($modelName ,array('action'=>'index'));
echo __('Subitem');
echo $form->text($modelName.'.subitem', array(
	'type'=>'text',
	'size'=>7,
	'div'=>false
));
echo '　';
echo __('Depot');
echo $form->text($modelName.'.depot', array(
	'type'=>'text',
	'size'=>7,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.stock_change', array(
	'type'=>'select',
	'options'=>$stockChange,
	'empty'=>__('(Please Select)', true),
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.reason_type', array(
	'type'=>'select',
	'options'=>$reasonType,
	'empty'=>__('(Please Select)', true),
	'div'=>false
));
echo '<br><br>';
echo $form->input($modelName.'.created_start', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>__('Created', true),
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'(select)',
	'div'=>false
));
echo $form->input($modelName.'.created_end', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>'　～　',
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'(select)',
	'div'=>false
));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　CSV出力';
	echo $form->checkbox($modelName.'.csv', array('div'=>false));
}
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
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('subitem_id');?></th>
	<th><?php echo $paginator->sort('depot_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('stock_change');?></th>
	<th><?php echo $paginator->sort('reason_type');?></th>
	<th><?php echo $paginator->sort('created');?></th>
</tr>
<?php
$i = 0;
foreach ($stockRevisions as $stockRevision):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($stockRevision['StockRevision']['id'], array('action'=>'view', $stockRevision['StockRevision']['id'])); ?>
		</td>
		<td>
			<?php echo $stockRevision['Subitem']['name']; ?>
		</td>
		<td>
			<?php echo $stockRevision['Depot']['name'].':'.$stockRevision['Depot']['id']; ?>
		</td>
		<td>
			<?php echo $stockRevision['StockRevision']['quantity']; ?>
		</td>
		<td>
			<?php echo $stockChange[$stockRevision['StockRevision']['stock_change']]; ?>
		</td>
		<td>
			<?php echo $reasonType[$stockRevision['StockRevision']['reason_type']]; ?>
		</td>
		<td>
			<?php echo $stockRevision['StockRevision']['created']; ?>
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
<li>検索：子品番は、子品番の部分一致で検索できます。倉庫は、倉庫番号での検索になります。</li>
</ul>