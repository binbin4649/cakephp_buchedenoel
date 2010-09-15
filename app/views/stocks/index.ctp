<?php
if(!empty($csv)){
	echo '<br>在庫CSV：<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。<br>';
}
?>
<div class="stocks index">
<?php
echo $form->create('Stock' ,array('action'=>'index'));
echo '子品番名';
echo $form->text('Stock.subitem_name', array(
	'size'=>7,
));
echo '　JAN';
echo $form->text('Stock.subitem_jan', array(
	'size'=>10,
));
echo '　親品番ID';
echo $form->text('Stock.item_id', array(
	'size'=>4,
));
echo '<br><br>';
echo '　倉庫名';
echo $form->text('Stock.depot_name', array(
	'label'=>false,
	'size'=>7
));
echo '　倉庫ID';
echo $form->text('Stock.depot_id', array(
	'label'=>false,
	'size'=>7
));
echo '　';
/*
controller はまた今度
echo $form->input('Stock.is_stock',array(
	'type'=>'checkbox',
	'label'=>false,
	'div'=>false
));
echo '在庫有のみ　';
*/
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo $form->input('Stock.csv',array(
		'type'=>'checkbox',
		'div'=>false
	));
	echo '　';
}
if(!empty($this->params['pass'])){
	echo $form->hidden('Stock.ac', array('value'=>$this->params['pass']['0']));
	echo $form->hidden('Stock.id_ex', array('value'=>$this->params['pass']['1']));
}
echo $form->submit('Seach', array('div'=>false));
echo '　　';
echo $html->link('Reset', array('controller'=>'stocks', 'action'=>'index/reset'));
echo '<h2>';
if(@$this->viewVars['depot']){
	echo __('Stocks : ');
	echo $this->viewVars['depot']['Section']['name'].' : ';
	echo $this->viewVars['depot']['Depot']['name'];
}
if(@$this->viewVars['subitem']){
	echo __('Stocks : ');
	echo $this->viewVars['subitem']['Item']['name'].' : ';
	echo $this->viewVars['subitem']['Subitem']['name'];
}
echo '</h2>';
?>
<p>
<?php
if(!empty($this->params['pass'])){
	echo $paginator->options(array('url'=>array($this->params['pass']['0'].'/'.$this->params['pass']['1'])));
}
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>子品番</th>
	<th>Jan</th>
	<th>倉庫名</th>
	<th>倉庫番号</th>
	<th>数量</th>
	<th>更新日時</th>
	<th>更新者</th>
</tr>
<?php
$i = 0;
foreach ($stocks as $stock):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($stock['Subitem']['name'], array('controller'=>'subitems', 'action'=>'view/'.$stock['Subitem']['id'])); ?>
		</td>
		<td>
			<?php echo $stock['Subitem']['jan']; ?>
		</td>
		<td>
			<?php echo $html->link($stock['Depot']['name'], array('controller'=>'sections', 'action'=>'view/'.$stock['Depot']['section_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($stock['Depot']['id'], array('controller'=>'depots', 'action'=>'view/'.$stock['Depot']['id'])); ?>
		</td>
		<td>
			<?php echo $stock['Stock']['quantity']; ?>
		</td>
		<td>
			<?php echo substr($stock['Stock']['updated'], 0, 10); ?>
		</td>
		<td>
			<?php echo $stock['Stock']['updated_user']; ?>
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
<p>
検索について<br>
子品番、倉庫、それぞれ「あいまい検索」での検索になります。子品番の一部や倉庫名の一部などを入力して検索できます。<br>
子品番、倉庫、両方入力すると絞込み検索になります。<br>
</p>