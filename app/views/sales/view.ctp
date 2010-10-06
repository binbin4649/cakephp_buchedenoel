<div class="view">
	<fieldset>
 		<h3><?php __('View Sale');?></h3>
	<?php
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			$order_view_action = 'view';
			$cost_title = '原価';
			$ex_bid_title = '参考上代';
		}else{
			$order_view_action = 'store_view';
			$cost_title = '';
			$ex_bid_title = '';
		}
		echo '<dl>';
		echo '<dt>'.__('Sale No.').'</dt><dd>'.$sale['Sale']['id'].'　</dd>';
		echo '<dt>'.__('Sale Type').'</dt><dd>'.$saleType[$sale['Sale']['sale_type']].'　</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$saleStatus[$sale['Sale']['sale_status']].'　</dd>';
		echo '<dt>'.__('Sale Date').'</dt><dd>'.$sale['Sale']['date'].'　</dd>';
		echo '<dt>'.__('Close Date').'</dt><dd>'.$sale['Sale']['total_day'].'　</dd>';
		echo '<dt>'.__('Depot').'</dt><dd>'.$sale['Depot']['name'].':'.$sale['Depot']['id'].'</dd>';
		echo '<dt>'.__('Destination').'</dt><dd>'.$html->link($sale['Destination']['name'], array('controller'=>'destinations', 'action'=>'view/'.$sale['Destination']['id'])).'　</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$sale['Sale']['partners_no'].'　</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$sale['Sale']['event_no'].'　</dd>';
		echo '<dt>'.__('Span No.').'</dt><dd>'.$sale['Sale']['span_no'].'　</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$sale['Sale']['customers_name'].'　</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($sale['Sale']['total']).'　</dd>';
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($sale['Sale']['item_price_total']).'　</dd>';
		echo '<dt>'.__('Tax').'</dt><dd>'.number_format($sale['Sale']['tax']).'　</dd>';
		echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($sale['Sale']['shipping']).'　</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($sale['Sale']['adjustment']).'　</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>'.$sale['Sale']['contact1_name'].'</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>'.$sale['Sale']['contact2_name'].'　</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>'.$sale['Sale']['contact3_name'].'　</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>'.$sale['Sale']['contact4_name'].'　</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$sale['Sale']['created_user'].':'.$sale['Sale']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$sale['Sale']['updated_user'].':'.$sale['Sale']['updated'].'　</dd>';
		if(!empty($sale['Sale']['return_id'])) echo '<dt>'.__('Return Sales').'</dt><dd>'.$html->link($sale['Sale']['return_id'], array('controller'=>'sales', 'action'=>'view/'.$sale['Sale']['return_id'])).'　</dd>';
		if(!empty($print)) echo '<dt>'.__('File').'</dt><dd><a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a></dd>';
		echo '<dt>'.__('Remarks').'</dt><dd>'.nl2br($sale['Sale']['remark']).'　</dd>';
		echo '</dl>';
		echo '<ul>';
		echo '<li>'.$addForm->switchAnchor('sales/edit/'.$sale['Sale']['id'], array(3, 4, 5, 7), null, 'Edit', $sale['Sale']['sale_status']).'</li>';
		echo '<li>'.$addForm->switchAnchor('sales/sale_print/'.$sale['Sale']['id'], array(3, 4, 5, 7), null, 'Sales Print', $sale['Sale']['sale_status']).'</li>';
		if(empty($sale['Sale']['return_id']) and $sale['Depot']['section_id'] == $loginUser['User']['section_id']){
			echo '<li>'.$addForm->switchAnchor('sales/red/'.$sale['Sale']['id'], array(4), null, 'Return Sales', $sale['Sale']['sale_status']).'</li>';
		}elseif($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo '<li>'.$addForm->switchAnchor('sales/red/'.$sale['Sale']['id'], array(4), null, 'Return Sales', $sale['Sale']['sale_status']).'</li>';
		}
		echo '</ul>';
		$total_quantity = 0;
		echo '<table class="itemDetail"><tr><th colspan="6">売上明細</th></tr><tr><th>子品番</th><th>売上単価</th><th>'.$ex_bid_title.'</th><th>備考</th><th>刻印</th><th>数量</th></tr>';
		foreach($sale['SalesDateil'] as $detail){
			if($addForm->opneUser(open_users(), $opneuser, 'access_authority') == false){
				$detail['cost'] = '';
				$detail['ex_bid'] = '';
			}
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'].'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.number_format($detail['ex_bid']).'</td>';
			echo '<td>'.$detail['sub_remarks'].'</td>';
			echo '<td>'.$detail['marking'].'</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['bid_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td></tr>';
		echo '</table>';
		if(!empty($sale['Order'])){
			echo '<table class="itemDetail"><tr><th colspan="6">受注データ</th></tr>';
			echo '<tr><th>Id</th><th>受注タイプ</th><th>倉庫</th><th>受注日</th><th>商品合計</th><th>更新日</th></tr>';
			foreach($sale['Order'] as $order){
				$order_type = '';
				if(!empty($order['order_type'])) $order_type = $orderType[$order['order_type']];
				echo '<tr>';
				echo '<td>'.$html->link($order['id'], array('controller'=>'orders', 'action'=>$order_view_action.'/'.$order['id'])).'</td>';
				echo '<td>'.$order_type.'</td>';
				echo '<td>'.$order['depot_id'].'</td>';
				echo '<td>'.$order['date'].'</td>';
				echo '<td>'.number_format($order['price_total']).'</td>';
				echo '<td>'.substr($order['updated'], 0, 10).'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	?>
	</fieldset>
</div>
<hr>
<ul>
	<li>赤伝を登録すると、売上と同じ金額をそのままマイナスにした売上が、状態「赤伝」で登録され、実質的に相殺されます。</li>
	<li>赤伝を登録すると、在庫は売り上げた倉庫に自動的に戻ります。</li>
</ul>