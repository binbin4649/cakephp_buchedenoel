<div class="view">
<?php echo '<li>'.$html->link(__('Return Order No.'.$order['Order']['id'], true), array('controller'=>'orders', 'action'=>'view/'.$order['Order']['id'])).'</li>';?>
	<fieldset>
 		<h3><?php __('Edit Order');?></h3>
	<?php
		echo $form->create('Order', array('action'=>'edit'));
		echo '<dl>';
		echo '<dt>'.__('Order No.').'</dt><dd>'.$order['Order']['id'].'　</dd>';
		echo $form->hidden('Order.id', array('value'=>$order['Order']['id']));
		echo '<dt>'.__('Order Type').'</dt><dd>';
		echo $form->input('Order.order_type', array(
			'type'=>'select',
			'label'=>false,
			'selected'=>$order['Order']['order_type'],
			'div'=>false,
			'options'=>$orderType
		));
		echo '</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$orderStatus[$order['Order']['order_status']].'　</dd>';
		echo '<dt>'.__('Order Date').'</dt><dd>';
		echo $form->input('Order.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'selected'=>$order['Order']['date'],
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Depot').'</dt><dd>';
		echo $form->input('Order.depot_id', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>2,
 			'value'=>$order['Depot']['id']
		));
		echo $order['Depot']['section_name'].':'.$order['Depot']['name'].':'.$order['Depot']['id'].'</dd>';
		echo '<dt>'.__('Destination').'</dt><dd>';
		echo $form->input('Order.destination_id', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>2,
 			'value'=>$order['Destination']['id']
		));
		echo $order['Destination']['name'].'　</dd>';
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
		echo $form->input('Order.events_no', array(
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
		echo $form->input('Order.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45,
			'value'=>$order['Order']['remark']
		));

		$total_quantity = 0;
		$total_pairing = 0;
		$total_ordering = 0;
		$total_sell = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>価格</th><th>納期</th><th>店着</th><th>入荷</th><th>出荷</th><th>刻印</th><th>受注</th><th>引当</th><th>発注</th><th>売上</th></tr>';
		foreach($order['OrderDateil'] as $key=>$detail){
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'];
			echo $form->hidden('OrderDateil.'.$key.'.id', array('value'=>$detail['id']));
			echo '</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.specified_date', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>5,
 				'value'=>$detail['specified_date']
			));
			echo '</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.store_arrival_date', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>5,
 				'value'=>$detail['store_arrival_date']
			));
			echo '</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.stock_date', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>5,
 				'value'=>$detail['stock_date']
			));
			echo '</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.shipping_date', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>5,
 				'value'=>$detail['shipping_date']
			));
			echo '</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.marking', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>5,
 				'value'=>$detail['marking']
			));
			echo '</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.pairing_quantity', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>1,
 				'value'=>$detail['pairing_quantity']
			));
			echo '</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.ordering_quantity', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
 				'size'=>1,
 				'value'=>$detail['ordering_quantity']
			));
			echo '</td>';
			echo '<td>'.$detail['sell_quantity'].'</td>';

			echo '</tr>';
			$total_quantity = $total_quantity + $detail['bid_quantity'];
			$total_pairing = $total_pairing + $detail['pairing_quantity'];
			$total_ordering = $total_ordering + $detail['ordering_quantity'];
			$total_sell = $total_sell + $detail['sell_quantity'];
		}
		echo '<tr><td>【一括上書き】</td><td></td><td>';
		echo $form->input('Order.specified_lump', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
		));
		echo '</td><td>';
		echo $form->input('Order.store_arrival_lump', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
		));
		echo '</td><td>';
		echo $form->input('Order.stock_lump', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
		));
		echo '</td><td>';
		echo $form->input('Order.shipping_lump', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
		));
		echo '</td><td>数量合計</td><td>'.$total_quantity.'</td><td>'.$total_pairing.'</td><td>'.$total_ordering.'</td><td>'.$total_sell.'</td></tr>';
		echo '</table>';
		echo $form->end(__('Submit', true));
	?>
	</fieldset>
</div>
<hr>
<ul>
	<li>納期、店着、入荷、出荷の日付入力は、YYYY-MM-DD、YYYYMMDD、形式の半角で入力して下さい。</li>
</ul>