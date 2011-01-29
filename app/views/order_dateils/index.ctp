<div class="orderDateils index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('OrderDateils');?></h2>
<?php
$modelName = 'OrderDateil';
echo $form->create($modelName ,array('action'=>'index'));
echo '売上id';
echo $form->text($modelName.'.order_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '取置id';
echo $form->text($modelName.'.transport_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '部門id';
echo $form->text($modelName.'.section_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '品番';
echo $form->text($modelName.'.item_name', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '現売';
echo $form->checkbox($modelName.'.ordertype.6');
echo '　';
echo '特注';
echo $form->checkbox($modelName.'.ordertype.4');
echo '　';
echo '手配';
echo $form->checkbox($modelName.'.ordertype.5');
echo '　';
echo '客注';
echo $form->checkbox($modelName.'.ordertype.2');
echo '　';
echo '取置';
echo $form->checkbox($modelName.'.ordertype.7');
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<br/><br/>
<span style="margin-left:20px;">
<a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a></span>　<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
<br/>
<div id="in_exp" style="display:none">
<?php
echo '入力日';
echo $form->input($modelName.'.start_created', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_created', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '<br/><br/>';
echo '店着日';
echo $form->input($modelName.'.start_arrival', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_arrival', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '<br/><br/>';
echo '出荷日';
echo $form->input($modelName.'.start_shipping', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_shipping', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV出力';
	echo $form->checkbox($modelName.'.csv');
}
echo $form->end();
?>
</div>
<br/>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>売上</th>
	<th>取置</th>
	<th>部門</th>
	<th>品番</th>
	<th>入力日</th>
	<th>店着日</th>
	<th>出荷日</th>
</tr>
<?php foreach($orderDateils as $orderDateil): ?>
	<tr>
		<td>
			<?php echo $html->link($orderDateil['Order']['id'], array('controller'=>'orders', 'action'=>'view', $orderDateil['Order']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($orderDateil['TransportDateil']['transport_id'], array('controller'=>'transports', 'action'=>'view', $orderDateil['TransportDateil']['transport_id'])); ?>
		</td>
		<td>
			<?php echo $orderDateil['Order']['section_name']; ?>
		</td>
		<td>
			<?php echo $orderDateil['Item']['name']; ?>
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['created'], 0, 10); ?><!-- 入力日 -->
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['store_arrival_date'], 0, 10); ?><!-- 店着日 -->
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['shipping_date'], 0, 10); ?><!-- 出荷日 -->
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
	<li>入力日：店舗が入力した日。</li>
	<li>店着日：店舗が入力した、店着希望日。</li>
	<li>出荷日：商品部が出荷した日</li>
	<li>売上は売上番号、取置は取置番号です。</li>
</ul>
