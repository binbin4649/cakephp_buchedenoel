<?php echo '<p>'.$html->link(__('Return Order No.'.$order['Order']['id'], true), array('controller'=>'orders', 'action'=>'view/'.$order['Order']['id'])).'</p>';?>
<div class="itemLeftView">
<h5>Sale Data</h5>
<?php
	echo $form->create('Order', array('action'=>'sell_confirm'));
	echo '<dl>';
	echo '<dt>'.__('Sale Date').'</dt><dd>';
	echo $form->input('Sale.date', array(
		'type'=>'date',
		'dateFormat'=>'YMD',
		'label'=>false,
		'minYear'=>'2009',
		'maxYear' => MAXYEAR,
		'div'=>false
	));
	echo '</dd>';
	echo '<dt>'.__('Sale Type').'</dt><dd>';
	echo $form->input('Sale.sale_type', array(
		'type'=>'select',
		'options'=>$saleType,
		'label'=>false,
		'div'=>false,
		'selected'=>1,
	));
	echo '</dd>';
	echo '<dt>'.__('Close Date').'</dt><dd>';
	echo $form->input('Sale.total_day', array(
		'type'=>'date',
		'dateFormat'=>'YMD',
		'label'=>false,
		'minYear'=>'2009',
		'maxYear' => MAXYEAR,
		'div'=>false,
		'selected'=>$order['Order']['total_day'],
		'empty'=>array('select')
	));
	echo '</dd>';
	echo '</dl>';
	echo $form->input('Sale.remark', array(
		'type'=>'textarea',
		'label'=>__('Remarks', true),
		'rows'=>6,
		'cols'=>45
	));
?>
</div>
<div class="itemsRightview">
<h5>Order Data</h5>
	<fieldset>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Order No.').'</dt><dd>'.$order['Order']['id'].'　</dd>';
		echo $form->hidden('Order.id', array('value'=>$order['Order']['id']));
		echo '<dt>'.__('Order Type').'</dt><dd>'.$orderType[$order['Order']['order_type']].'　</dd>';
		echo $form->hidden('Order.order_type', array('value'=>$order['Order']['order_type']));
		echo '<dt>'.__('Status').'</dt><dd>'.$orderStatus[$order['Order']['order_status']].'　</dd>';
		echo $form->hidden('Order.order_status', array('value'=>$order['Order']['order_status']));
		echo '<dt>'.__('Order Date').'</dt><dd>'.$order['Order']['date'].'　</dd>';
		echo $form->hidden('Order.date', array('value'=>$order['Order']['date']));
		echo '<dt>'.__('Depot').'</dt><dd>';
		echo $form->input('Order.depot_id', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>2,
 			'value'=>$order['Depot']['id']
		));
		echo $order['Depot']['section_name'].':'.$order['Depot']['name'].':'.$order['Depot']['id'].'</dd>';
		echo $form->hidden('Order.depot_name', array('value'=>$order['Depot']['name']));
		echo $form->hidden('Order.section_name', array('value'=>$order['Depot']['section_name']));
		echo '<dt>'.__('Destination').'</dt><dd>'.$order['Destination']['name'].'　</dd>';
		echo $form->hidden('Order.destination_name', array('value'=>$order['Destination']['name']));
		echo $form->hidden('Order.destination_id', array('value'=>$order['Destination']['id']));
		echo '<dt>'.__('Partners No.').'</dt><dd>';
		echo $form->input('Order.partners_no', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>15,
 			'value'=>$order['Order']['partners_no']
		));
		echo '</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>';
		echo $form->input('Order.events_no', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>15,
 			'value'=>$order['Order']['events_no']
		));
		echo '</dd>';
		echo '<dt>'.__('Span No.').'</dt><dd>';
		echo $form->input('Order.span_no', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>15,
 			'value'=>$order['Order']['span_no']
		));
		echo '</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>';
		echo $form->input('Order.customers_name', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>20,
 			'value'=>$order['Order']['customers_name']
		));
		echo '</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($order['Order']['total']).'　</dd>';
		echo $form->hidden('Order.total', array('value'=>$order['Order']['total']));
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($order['Order']['price_total']).'　</dd>';
		echo $form->hidden('Order.price_total', array('value'=>$order['Order']['price_total']));
		echo '<dt>'.__('Tax Total').'</dt><dd>'.number_format($order['Order']['total_tax']).'　</dd>';
		echo $form->hidden('Order.total_tax', array('value'=>$order['Order']['total_tax']));
		echo '<dt>'.__('Shipping').'</dt><dd>';
		echo $form->input('Order.shipping', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>10,
 			'value'=>$order['Order']['shipping']
		));
		echo '</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>';
		echo $form->input('Order.adjustment', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>10,
 			'value'=>$order['Order']['adjustment']
		));
		echo '</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>';
		echo $form->input('Order.contact1', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['contact1']
		));
		echo $order['Order']['contact1_name'].'</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>';
		echo $form->input('Order.contact2', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['contact2']
		));
		echo $order['Order']['contact2_name'].'</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>';
		echo $form->input('Order.contact3', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['contact3']
		));
		echo $order['Order']['contact3_name'].'</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>';
		echo $form->input('Order.contact4', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['contact4']
		));
		echo $order['Order']['contact4_name'].'</dd>';
		echo '<dt>'.__('Pairing1').'</dt><dd>';
		echo $form->input('Order.pairing1', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['pairing1']
		));
		echo '</dd>';
		echo '<dt>'.__('Pairing2').'</dt><dd>';
		echo $form->input('Order.pairing2', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['pairing2']
		));
		echo '</dd>';
		echo '<dt>'.__('Pairing3').'</dt><dd>';
		echo $form->input('Order.pairing3', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['pairing3']
		));
		echo '</dd>';
		echo '<dt>'.__('Pairing4').'</dt><dd>';
		echo $form->input('Order.pairing4', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$order['Order']['pairing4']
		));
		echo '</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$order['Order']['created_user'].':'.$order['Order']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$order['Order']['updated_user'].':'.$order['Order']['updated'].'　</dd>';
		echo '</dl>';
		echo $form->hidden('Order.created_user', array('value'=>$order['Order']['created_user']));
		echo $form->hidden('Order.created', array('value'=>$order['Order']['created']));
		echo $form->hidden('Order.updated_user', array('value'=>$order['Order']['updated_user']));
		echo $form->hidden('Order.updated', array('value'=>$order['Order']['updated']));
		echo $form->hidden('Order.contact1_name', array('value'=>$order['Order']['contact1_name']));
		echo $form->hidden('Order.contact2_name', array('value'=>$order['Order']['contact2_name']));
		echo $form->hidden('Order.contact3_name', array('value'=>$order['Order']['contact3_name']));
		echo $form->hidden('Order.contact4_name', array('value'=>$order['Order']['contact4_name']));
		echo $form->input('Order.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45,
			'value'=>$order['Order']['remark']
		));
?>
</fieldset>
</div>
<div class="itemViewRelated">
<?php
		$total_quantity = 0;
		$total_pairing = 0;
		$total_ordering = 0;
		$total_sell = 0;
		$total_an = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>上代</th><th>下代</th><th>原価</th><th>納期</th><th>出荷</th><th>刻印</th><th>受注</th><th>破棄</th><th>引当</th><th>発注</th><th>売済</th><th>売上</th></tr>';
		foreach($order['OrderDateil'] as $key=>$detail){
			$p_qty = $detail['pairing_quantity'] + $detail['ordering_quantity'];
			if($p_qty >= 1){
				$sell_qty = $p_qty - $detail['sell_quantity'];
			}else{
				$sell_qty = '';
			}
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'].'</td>';
			echo '<td>'.number_format($detail['ex_bid']).'</td>';
			echo '<td>';//下代
			echo $form->input('OrderDateil.'.$key.'.bid', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>1,
 				'value'=>$detail['bid']
			));
			echo '<td>';//原価
			echo $form->input('OrderDateil.'.$key.'.cost', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>1,
 				'value'=>$detail['cost']
			));
			echo '</td>';
			echo '<td>'.substr($detail['specified_date'], 5, 5).'</td>';
			echo '<td>'.substr($detail['shipping_date'], 5, 5).'</td>';
			echo '<td>'.$detail['marking'].'</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '<td>'.$detail['an_quantity'].'</td>';
			echo '<td>'.$detail['pairing_quantity'].'</td>';
			echo '<td>'.$detail['ordering_quantity'].'</td>';
			echo '<td>'.$detail['sell_quantity'].'</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.sell_quantity', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>1,
 				'value'=>$sell_qty
			));
			echo '</td>';
			echo '</tr>';
			echo $form->hidden('OrderDateil.'.$key.'.id', array('value'=>$detail['id']));
			echo $form->hidden('OrderDateil.'.$key.'.ex_bid', array('value'=>$detail['ex_bid']));
			echo $form->hidden('OrderDateil.'.$key.'.subitem_id', array('value'=>$detail['subitem_id']));
			echo $form->hidden('OrderDateil.'.$key.'.subitem_name', array('value'=>$detail['subitem_name']));
			echo $form->hidden('OrderDateil.'.$key.'.marking', array('value'=>$detail['marking']));
			$total_quantity = $total_quantity + $detail['bid_quantity'];
			$total_an = $total_an + $detail['an_quantity'];
			$total_pairing = $total_pairing + $detail['pairing_quantity'];
			$total_ordering = $total_ordering + $detail['ordering_quantity'];
			$total_sell = $total_sell + $detail['sell_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td><td>'.$total_an.'</td><td>'.$total_pairing.'</td><td>'.$total_ordering.'</td><td>'.$total_sell.'</td><td></td></tr>';
		echo '</table>';
		echo $form->end(__('Submit', true));
	?>
</div>
<hr>
<ul>
	<li>左側が売上データ、右側が受注データで、売上の際は受注データからデータを引き継ぎ、売上データが入力されます。</li>
	<li>出荷先が入力されていて、取引先に営業担当が登録されている場合は、販売担当者1が売上のタイミングで入れ替わります。</li>
</ul>