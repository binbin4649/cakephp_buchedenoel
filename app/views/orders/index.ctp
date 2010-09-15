<div class="orders index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('Sales List');?></h2>
<?php
$modelName = 'Order';
echo $form->create($modelName ,array('action'=>'index'));
echo '取引先id';
echo $form->text($modelName.'.company_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '出荷先id';
echo $form->text($modelName.'.destination_id', array(
	'type'=>'text',
	'size'=>2,
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
echo __('Partners No.');
echo $form->text($modelName.'.partners_no', array(
	'type'=>'text',
	'size'=>6,
	'div'=>false
));
echo '<br><br>';
echo __('Item Name');
echo $form->text($modelName.'.item_word', array(
	'type'=>'text',
	'size'=>6,
	'div'=>false
));
echo '　';
echo __('Sale Date', true);
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
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<p>
<a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo '売上id';
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>1,
	'div'=>false
));
echo '　';
echo __('Events No.');
echo $form->text($modelName.'.events_no', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV出力';
	echo $form->checkbox($modelName.'.csv');
}
?>
</div>
<?php
echo $form->end();
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>id</th>
	<th>部門</th>
	<th><?php echo __('Status', true);?></th>
	<th>取引先</th>
	<th>出荷先</th>
	<th><?php echo __('Sale Date', true);?></th>
	<th><?php echo __('Partners No.', true);?></th>
	<th><?php echo __('Total');?></th>
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
			<?php echo mb_substr($order['Depot']['section_name'], 0, 8); ?>
		</td>
		<td>
			<?php echo $orderStatus[$order['Order']['order_status']]; ?>
		</td>
		<td>
			<?php echo mb_substr($order['Destination']['company_name'], 0, 10); ?>
		</td>
		<td>
			<?php echo mb_substr($order['Destination']['name'], 0, 10); ?>
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