<?php echo '<p>'.$html->link(__('Return Order No.'.$confirm['Order']['id'], true), array('controller'=>'orders', 'action'=>'sell/'.$confirm['Order']['id'])).'</p>';?>
<div class="itemsRightview">
<h5>Order Data</h5>
	<fieldset>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Order No.').'</dt><dd>'.$confirm['Order']['id'].'　</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$orderStatus[$confirm['Order']['order_status']].'　</dd>';
		echo '<dt>'.__('Order Date').'</dt><dd>'.$confirm['Order']['date'].'　</dd>';
		echo '<dt>'.__('Section').'</dt><dd>'.$confirm['Order']['section_id'].'</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$confirm['Order']['partners_no'].'　</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$confirm['Order']['events_no'].'　</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$confirm['Order']['customers_name'].'　</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>'.$confirm['Order']['contact1_name'].'　</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>'.$confirm['Order']['contact2_name'].'　</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>'.$confirm['Order']['contact3_name'].'　</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>'.$confirm['Order']['contact4_name'].'　</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$confirm['Order']['created_user'].':'.$confirm['Order']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$confirm['Order']['updated_user'].':'.$confirm['Order']['updated'].'　</dd>';
		echo '</dl>【受注データの備考】<br>';
		echo nl2br($confirm['Order']['remark']);
?>
</fieldset>
</div>
<div class="itemViewRelated">
<?php
		$total_bid = 0;
		$total_before_sell = 0;
		$total_sell = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>価格</th><th>売上</th><th>完了</th><th>お渡し</th></tr>';
		foreach($confirm['OrderDateil'] as $key=>$detail){
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'].'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '<td>'.$detail['before_sell_quantity'].'</td>';
			if(!empty($detail['subitem_jan'])){
				echo '<td>'.$detail['subitem_jan'].'</td>';
				$detail['sell_quantity'] = 1;
			}else{
				echo '<td>'.$detail['sell_quantity'].'</td>';
			}
			
			echo '</tr>';
			$total_bid = $total_bid + $detail['bid_quantity'];
			$total_before_sell = $total_before_sell + $detail['before_sell_quantity'];
			$total_sell = $total_sell + $detail['sell_quantity'];
		}
		echo '<tr><td></td><td>数量合計</td><td>'.$total_bid.'</td><td>'.$total_before_sell.'</td><td>'.$total_sell.'</td></tr>';
		echo '</table>';
	?>
<ul>
	<li><?php echo $html->link('お渡し入力確認', array('controller'=>'orders', 'action'=>'store_orders'), null, sprintf(__('input sales. Are you all right?', true), null)); ?></li>
</ul>
</div>
<hr>
<ul>
<li>売上：売り上げた数量</li>
<li>完了：お渡しが完了した分</li>
<li>お渡し：商品を入庫して、今回お渡しする分</li>
</ul>