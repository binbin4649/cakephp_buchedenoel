<?php echo '<p>'.$html->link(__('Return Order No.'.$confirm['Order']['id'], true), array('controller'=>'orders', 'action'=>'sell/'.$confirm['Order']['id'])).'</p>';?>
<div class="itemLeftView">
<h5>Sale Data</h5>
<?php
	$sale_date = $confirm['Sale']['date']['year'].'-'.$confirm['Sale']['date']['month'].'-'.$confirm['Sale']['date']['day'];
	$total_day = $confirm['Sale']['total_day']['year'].'-'.$confirm['Sale']['total_day']['month'].'-'.$confirm['Sale']['total_day']['day'];
	echo '<dl>';
	echo '<dt>'.__('Sale Date').'</dt><dd>'.$sale_date.'　</dd>';
	echo '<dt>'.__('Sale Type').'</dt><dd>'.$saleType[$confirm['Sale']['sale_type']].'　</dd>';
	echo '<dt>'.__('Close Date').'</dt><dd>'.$total_day.'　</dd>';
	echo '<dt>'.__('Total').'</dt><dd>'.number_format($confirm['Sale']['total']).'　</dd>';
	echo '<dt>'.__('Item Total').'</dt><dd>'.number_format($confirm['Sale']['item_price_total']).'　</dd>';
	echo '<dt>'.__('Tax').'</dt><dd>'.number_format($confirm['Sale']['tax']).'　</dd>';
	echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($confirm['Order']['shipping']).'　</dd>';
	echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($confirm['Order']['adjustment']).'　</dd>';
	echo '<dt>'.__('Sales Price Total').'</dt><dd>'.number_format($confirm['Sale']['ex_total']).'　</dd>';
	echo '</dl>【売上データの備考】<br>';
	echo nl2br($confirm['Sale']['remark']);
?>
</div>
<div class="itemsRightview">
<h5>Order Data</h5>
	<fieldset>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Order No.').'</dt><dd>'.$confirm['Order']['id'].'　</dd>';
		echo '<dt>'.__('Order Type').'</dt><dd>'.$orderType[$confirm['Order']['order_type']].'　</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$orderStatus[$confirm['Order']['order_status']].'　</dd>';
		echo '<dt>'.__('Order Date').'</dt><dd>'.$confirm['Order']['date'].'　</dd>';
		echo '<dt>'.__('Depot').'</dt><dd>'.$confirm['Order']['section_name'].':'.$confirm['Order']['depot_name'].':'.$confirm['Order']['depot_id'].'</dd>';
		echo '<dt>'.__('Destination').'</dt><dd>'.$confirm['Order']['destination_name'].'　</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$confirm['Order']['partners_no'].'　</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$confirm['Order']['events_no'].'　</dd>';
		echo '<dt>'.__('Span No.').'</dt><dd>'.$confirm['Order']['span_no'].'　</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$confirm['Order']['customers_name'].'　</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>'.$confirm['Order']['contact1_name'].'　</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>'.$confirm['Order']['contact2_name'].'　</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>'.$confirm['Order']['contact3_name'].'　</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>'.$confirm['Order']['contact4_name'].'　</dd>';
		echo '<dt>'.__('Pairing1').'</dt><dd>'.$confirm['Order']['pairing1'].'　</dd>';
		echo '<dt>'.__('Pairing2').'</dt><dd>'.$confirm['Order']['pairing2'].'　</dd>';
		echo '<dt>'.__('Pairing3').'</dt><dd>'.$confirm['Order']['pairing3'].'　</dd>';
		echo '<dt>'.__('Pairing4').'</dt><dd>'.$confirm['Order']['pairing4'].'　</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$confirm['Order']['created_user'].':'.$confirm['Order']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$confirm['Order']['updated_user'].':'.$confirm['Order']['updated'].'　</dd>';
		echo '</dl>【受注データの備考】<br>';
		echo nl2br($confirm['Order']['remark']);
?>
</fieldset>
</div>
<div class="itemViewRelated">
<?php
		$total_quantity = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>上代</th><th>下代</th><th>原価</th><th>刻印</th><th>数量</th></tr>';
		foreach($confirm['OrderDateil'] as $key=>$detail){
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'].'</td>';
			echo '<td>'.number_format($detail['ex_bid']).'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.number_format($detail['cost']).'</td>';
			echo '<td>'.$detail['marking'].'</td>';
			echo '<td>'.$detail['sell_quantity'].'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['sell_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td></tr>';
		echo '</table>';
	?>
<ul>
	<li><?php echo $html->link(__('Input Sales Confirm', true), array('controller'=>'sales', 'action'=>'orders'), null, sprintf(__('input sales. Are you all right?', true), null)); ?></li>
</ul>
</div>
<hr>
