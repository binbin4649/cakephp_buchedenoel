<a href="javascript:history.back();">戻る</a>
<div class="view">
	<fieldset>
	<?php
		echo '<dl>';
		echo '<dt>売上番号</dt><dd>'.$order['Order']['id'].'　</dd>';
		//echo '<dt>'.__('Order Type').'</dt><dd>'.$orderType[$order['Order']['order_type']].'　</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$orderStatus[$order['Order']['order_status']].'　</dd>';
		echo '<dt>'.__('Order Date').'</dt><dd>'.$order['Order']['date'].'　</dd>';
		
		echo '<dt>'.__('Destination').'</dt><dd>'.$order['Destination']['name'].'　</dd>';
		echo '<dt> 出荷先ID </dt><dd>'.$order['Destination']['id'].'　</dd>';
		//echo '<dt>'.__('Depot').'</dt><dd>'.$order['Depot']['section_name'].':'.$order['Depot']['name'].':'.$order['Depot']['id'].'</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$order['Order']['partners_no'].'　</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$order['Order']['events_no'].'　</dd>';
		//echo '<dt>'.__('Span No.').'</dt><dd>'.$order['Order']['span_no'].'　</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$order['Order']['customers_name'].'　</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($order['Order']['total']).'　</dd>';
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($order['Order']['price_total']).'　</dd>';
		echo '<dt>'.__('Tax Total').'</dt><dd>'.number_format($order['Order']['total_tax']).'　</dd>';
		echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($order['Order']['shipping']).'　</dd>';
		//echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($order['Order']['adjustment']).'　</dd>';
		//echo '<dt>'.__('Prev Money').'</dt><dd>'.number_format($order['Order']['prev_money']).'　</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>'.$order['Order']['contact1_name'].'</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>'.$order['Order']['contact2_name'].'　</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>'.$order['Order']['contact3_name'].'　</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>'.$order['Order']['contact4_name'].'　</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$order['Order']['created_user'].':'.$order['Order']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$order['Order']['updated_user'].':'.$order['Order']['updated'].'　</dd>';
		if(!empty($print)) echo '<dt>'.__('Order File').'</dt><dd><a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a></dd>';
		if(!empty($print_custom)) echo '<dt>'.__('Custom Order File').'</dt><dd><a href="'.$print_custom['url'].'" target="_blank">'.$print_custom['file'].'</a></dd>';
		echo '<dt>'.__('Remarks').'</dt><dd>'.nl2br($order['Order']['remark']).'　</dd>';
		echo '</dl>';
		echo '<ul>';
		echo '<li>'.$addForm->switchAnchor('orders/delete/store/'.$order['Order']['id'], array(5), 'Sales Cancel it. Are you all right?', 'Sales Cancel', $order['Order']['order_status']).'</li>';
		echo '<li>'.$addForm->switchAnchor('orders/edit/'.$order['Order']['id'], array(4, 5), null, 'Edit', $order['Order']['order_status']).'</li>';
		echo '<li>'.$addForm->switchAnchor('orders/order_print/'.$order['Order']['id'], array(4, 5), null, 'Orders Print', $order['Order']['order_status']).'</li>';
		echo '<li>'.$addForm->switchAnchor('orders/customorder_print/'.$order['Order']['id'], array(4, 5), null, 'CustomOrder Print', $order['Order']['order_status']).'</li>';
		echo '<li>'.$addForm->switchAnchor('orders/sell/'.$order['Order']['id'], array(4, 5), null, 'Shipping Input', $order['Order']['order_status']).'</li>';
		echo '</ul>';
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo $html->link('PL印刷済みを未完に戻す', array('controller'=>'orders', 'action'=>'return_pl/'.$order['Order']['id']));
		}
		$total_quantity = 0;
		$total_pairing = 0;
		$total_ordering = 0;
		$total_sell = 0;
		$total_an = 0;
		echo '<table class="itemDetail"><tr><th colspan="12">受注明細</th></tr>';
		echo '<tr><th>子品番</th><th>価格</th><th>納期</th><th>店着</th><th>入荷</th><th>出荷</th><th>刻印</th><th>売上</th><th>破棄</th><th>引当</th><th>発注</th><th>済</th></tr>';
		
		foreach($order['OrderDateil'] as $detail){
			$dump_meseage = '';
			if(!empty($detail['depot_id'])) $dump_meseage .= '倉庫：'.$detail['depot_id'].' / ';
			if(!empty($detail['order_type'])) $dump_meseage .= '区分：'.$orderType[$detail['order_type']].' / ';
			if(!empty($detail['span_no'])) $dump_meseage .= 'スパン：'.$detail['span_no'].' / ';
			if(!empty($detail['discount'])) $dump_meseage .= '割引：'.$detail['discount'].' / ';
			if(!empty($detail['adjustment'])) $dump_meseage .= '調整：'.$detail['adjustment'].' / ';
			if(!empty($detail['sub_remarks'])) $dump_meseage .= '備考：'.$detail['sub_remarks'].' / ';
			
			echo '<tr>';
			echo '<td>'.$html->link($detail['subitem_name'], array('controller'=>'subitems', 'action'=>'view/'.$detail['subitem_id'])).'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.substr($detail['specified_date'], 5, 5).'</td>';
			echo '<td>'.substr($detail['store_arrival_date'], 5, 5).'</td>';
			echo '<td>'.substr($detail['stock_date'], 5, 5).'</td>';
			echo '<td>'.substr($detail['shipping_date'], 5, 5).'</td>';
			echo '<td>'.$detail['marking'].'</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '<td>'.$detail['an_quantity'].'</td>';
			echo '<td>'.$detail['pairing_quantity'].'</td>';
			echo '<td>'.$detail['ordering_quantity'].'</td>';
			echo '<td>'.$detail['sell_quantity'].'</td>';
			echo '</tr>';
			echo '<tr id="under-table">';
			echo '<td colspan="12">'.$dump_meseage.'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['bid_quantity'];
			$total_an = $total_an + $detail['an_quantity'];
			$total_pairing = $total_pairing + $detail['pairing_quantity'];
			$total_ordering = $total_ordering + $detail['ordering_quantity'];
			$total_sell = $total_sell + $detail['sell_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td><td>'.$total_an.'</td><td>'.$total_pairing.'</td><td>'.$total_ordering.'</td><td>'.$total_sell.'</td></tr>';
		echo '</table>';
/*
20110818
なんか全然関係ないのが出てるから、とりあえず非表示にした。

		//発注明細があれば表示
		if(!empty($order['OrderingsDetail'])){
			echo '<hr>';
			echo '<table class="itemDetail"><tr><th colspan="4">発注明細</th></tr>';
			echo '<tr><th>子品番</th><th>数量</th><th>発注日</th></tr>';
			foreach($order['OrderingsDetail'] as $orderings){
				echo '<tr>';
				echo '<td>'.$html->link($orderings['subitem_name'], array('controller'=>'subitems', 'action'=>'view/'.$orderings['subitem_id'])).'</td>';
				echo '<td>'.$orderings['ordering_quantity'].'</td>';
				echo '<td>'.$orderings['created_after'].'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}

		//仕入明細があれば表示
		if(!empty($order['PurchaseDetail'])){
			echo '<table class="itemDetail"><tr><th colspan="5">仕入明細</th></tr>';
			echo '<tr><th>子品番</th><th>数量</th><th>仕入日</th><th>仕入倉庫</th></tr>';
			foreach($order['PurchaseDetail'] as $purchase){
				echo '<tr>';
				echo '<td>'.$html->link($purchase['subitem_name'], array('controller'=>'subitems', 'action'=>'view/'.$purchase['subitem_id'])).'</td>';
				echo '<td>'.$purchase['quantity'].'</td>';
				echo '<td>'.$purchase['created_after'].'</td>';
				echo '<td>'.$html->link($purchase['depot_name'], array('controller'=>'depots', 'action'=>'view/'.$purchase['depot'])).'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		
		//売上データがあれば表示
		if(!empty($order['Sale'])){
			echo '<table class="itemDetail"><tr><th colspan="4">売上データ</th></tr>';
			echo '<tr><th>Id</th><th>売上日</th><th>商品合計</th></tr>';
			foreach($order['Sale'] as $sale){
				echo '<tr>';
				echo '<td>'.$html->link($sale['id'], array('controller'=>'sales', 'action'=>'view/'.$sale['id'])).'</td>';
				echo '<td>'.$sale['date'].'</td>';
				echo '<td>'.number_format($sale['item_price_total']).'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
*/
	?>
	</fieldset>
</div>