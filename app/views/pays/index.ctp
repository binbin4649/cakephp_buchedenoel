<div class="pays index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('Pay List');?></h2>
<?php
$modelName = 'Pay';
echo $form->create($modelName ,array('action'=>'index'));
echo 'ID';
echo $form->text($modelName.'.id', array(
	'size'=>1
));
echo '　';
echo '工場id';
echo $form->text($modelName.'.factory_id', array(
	'size'=>1
));
echo '　';
echo '請求書番号';
echo $form->text($modelName.'.partner_no', array(
	'size'=>8
));
echo '　';
echo $form->input($modelName.'.status', array(
	'type'=>'select',
	'options'=>$payStatus,
	'label'=>__('Status', true),
	'empty'=>'(select)',
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<div id='datail'>
<a href="javascript:;" onmousedown="if(document.getElementById('in_dateil').style.display == 'none'){ document.getElementById('in_dateil').style.display = 'block'; }else{ document.getElementById('in_dateil').style.display = 'none'; }">
details</a>
<div id="in_dateil" style="display:none">
<div class="form">
<?php
echo $form->input($modelName.'.total_day_start', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>__('Total Day', true),
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo $form->input($modelName.'.total_day_end', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>'～',
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo $form->input($modelName.'.payment_day_start', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>__('Payment Day', true),
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo $form->input($modelName.'.payment_day_end', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>'～',
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo 'CSV出力';
echo $form->checkbox($modelName.'.csv');
echo $form->end();
?>
</div>
</div>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
　：未払残高：<?php echo number_format($blance_total); ?>
</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Status', true),'pay_status');?></th>
	<th><?php echo $paginator->sort('factory_id');?></th>
	<th><?php echo $paginator->sort(__('Bill No.', true),'partner_no');?></th>
	<th><?php echo $paginator->sort(__('Pay Date', true),'date');?></th>
	<th><?php echo $paginator->sort('total_day');?></th>
	<th><?php echo $paginator->sort('payment_day');?></th>
	<th><?php echo $paginator->sort('total');?></th>
</tr>
<?php
$i = 0;
foreach ($pays as $pay):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($pay['Pay']['id'], array('action'=>'view', $pay['Pay']['id'])); ?>
		</td>
		<td>
			<?php echo $payStatus[$pay['Pay']['pay_status']]; ?>
		</td>
		<td>
			<?php echo $pay['Factory']['name']; ?>
		</td>
		<td>
			<?php echo $pay['Pay']['partner_no']; ?>
		</td>
		<td>
			<?php echo $pay['Pay']['date']; ?>
		</td>
		<td>
			<?php echo $pay['Pay']['total_day']; ?>
		</td>
		<td>
			<?php echo $pay['Pay']['payment_day']; ?>
		</td>
		<td>
			<?php echo number_format($pay['Pay']['view_total']); ?>
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
<li><?php echo $addForm->switchAnchor('pays/index/close', array(), 'Tighten the document in question. Are you sure?', 'Doing Pay', null); ?></li>
</ul>
<hr>
<ul>
	<li>工場・仕入先マスタの締め日が「その他」の仕入データは、手動で締める必要があります。</li>
	<li>工場・仕入先マスタに締め日、支払日の設定がない場合は、末締め、翌々末払いとなります。</li>
</ul>