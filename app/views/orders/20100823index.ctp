<div class="orders index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('Orders');?></h2>
<?php
$modelName = 'Order';
echo $form->create($modelName ,array('action'=>'index'));
echo __('Id');
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo __('Depot');
echo $form->text($modelName.'.depot', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo __('Destination');
echo $form->text($modelName.'.destination', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.order_type', array(
	'type'=>'select',
	'options'=>$orderType,
	'label'=>'Type',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.order_status', array(
	'type'=>'select',
	'options'=>$orderStatus,
	'label'=>'Status',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<br><a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo __('Events No.');
echo $form->text($modelName.'.events_no', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo __('Span No.');
echo $form->text($modelName.'.span_no', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
echo '　';
echo __('Partners No.');
echo $form->text($modelName.'.partners_no', array(
	'type'=>'text',
	'size'=>6,
	'div'=>false
));
echo '　';
echo __('Customers Name');
echo $form->text($modelName.'.customers_name', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false
));
echo '<br><br>';
echo __('Order Date', true);
echo $form->input('Order.start_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input('Order.end_date', array(
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
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('order_type');?></th>
	<th><?php echo $paginator->sort('order_status');?></th>
	<th><?php echo $paginator->sort('depot_id');?></th>
	<th><?php echo $paginator->sort('destination_id');?></th>
	<th><?php echo $paginator->sort(__('Order Date', true),'date');?></th>
	<th><?php echo $paginator->sort(__('Partners No.', true),'partners_no');?></th>
	<th><?php echo $paginator->sort('total');?></th>
</tr>
<?php
$i = 0;
foreach ($orders as $order):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($order['Order']['id'], array('action'=>'view', $order['Order']['id'])); ?>
		</td>
		<td>
			<?php echo $orderType[$order['Order']['order_type']]; ?>
		</td>
		<td>
			<?php echo $orderStatus[$order['Order']['order_status']]; ?>
		</td>
		<td>
			<?php echo $order['Depot']['name'].':'.$order['Order']['depot_id']; ?>
		</td>
		<td>
			<?php echo mb_substr($order['Destination']['name'], 0, 12); ?>
		</td>
		<td>
			<?php echo $order['Order']['date']; ?>
		</td>
		<td>
			<?php echo $order['Order']['partners_no']; ?>
		</td>
		<td>
			<?php echo number_format($order['Order']['total']); ?>
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
<h4>当日出荷CSV</h4>
<ul>
	<li><?php echo $addForm->switchAnchor('orders/index/shippinglist', array(), 'Shipping List CSV output. Are you all right?', 'Today Shipping List OutPut', null); ?></li>
</ul>
<hr>
<h4>ピッキングリスト</h4>
<ul>
	<li><?php echo $html->link(__('Pick List Old', true), array('controller'=>'orders', 'action'=>'picklist')); ?></li>
	<li><?php echo $addForm->switchAnchor('orders/picklist/retail', array(), 'Reservation is in a state and outputs a list of picking for the custom order. Are you all right?', 'CustomOrder PickList OutPut', null); ?></li>
	<li><?php echo $addForm->switchAnchor('orders/picklist/ws', array(), 'Reservation is in a state and outputs a list of picking for the order. Are you all right?', 'Order PickList OutPut', null); ?></li>
</ul>
<hr>
<ul>
	<li>Idは受注番号、倉庫は倉庫番号、出荷先は出荷先番号での検索になります。</li>
</ul>