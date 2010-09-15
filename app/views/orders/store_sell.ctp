<?php echo '<p>'.$html->link(__('Return Order No.'.$order['Order']['id'], true), array('controller'=>'orders', 'action'=>'store_view/'.$order['Order']['id'])).'</p>';?>
<div class="itemsRightview">
<h5><?php echo __('Pass Input'); ?></h5>
	<fieldset>
	<?php
		echo $form->create('Order', array('action'=>'store_sell_confirm'));
		echo '<dl>';
		echo '<dt>'.__('Sale No.').'</dt><dd>'.$order['Order']['id'].'　</dd>';
		echo $form->hidden('Order.id', array('value'=>$order['Order']['id']));
		echo '<dt>'.__('Status').'</dt><dd>'.$orderStatus[$order['Order']['order_status']].'　</dd>';
		echo $form->hidden('Order.order_status', array('value'=>$order['Order']['order_status']));
		echo '<dt>'.__('Sale Date').'</dt><dd>'.$order['Order']['date'].'　</dd>';
		echo $form->hidden('Order.date', array('value'=>$order['Order']['date']));
		//echo '<dt>'.__('Section').'</dt><dd>'.$order['Depot']['section_name'].':'.$order['Order']['section_id'].'　</dd>';
		echo '<dt>'.__('Section').'</dt><dd>'.$order['Order']['section_id'].'　</dd>';
		//echo $form->hidden('Order.depot_name', array('value'=>$order['Depot']['name']));
		//echo $form->hidden('Order.section_name', array('value'=>$order['Depot']['section_name']));
		echo $form->hidden('Order.section_id', array('value'=>$order['Order']['section_id']));
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$order['Order']['partners_no'].'　</dd>';
		echo $form->hidden('Order.partners_no', array('value'=>$order['Order']['partners_no']));
		echo '<dt>'.__('Events No.').'</dt><dd>'.$order['Order']['events_no'].'　</dd>';
		echo $form->hidden('Order.events_no', array('value'=>$order['Order']['events_no']));
		//echo '<dt>'.__('Span No.').'</dt><dd>'.$order['Order']['span_no'].'　</dd>';
		//echo $form->hidden('Order.span_no', array('value'=>$order['Order']['span_no']));
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$order['Order']['customers_name'].'　</dd>';
		echo $form->hidden('Order.customers_name', array('value'=>$order['Order']['customers_name']));
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($order['Order']['total']).'　</dd>';
		echo $form->hidden('Order.total', array('value'=>$order['Order']['total']));
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($order['Order']['price_total']).'　</dd>';
		echo $form->hidden('Order.price_total', array('value'=>$order['Order']['price_total']));
		echo '<dt>'.__('Tax Total').'</dt><dd>'.number_format($order['Order']['total_tax']).'　</dd>';
		echo $form->hidden('Order.total_tax', array('value'=>$order['Order']['total_tax']));
		echo '<dt>'.__('Prev Money').'</dt><dd>'.$order['Order']['prev_money'].'　</dd>';
		echo $form->hidden('Order.prev_money', array('value'=>$order['Order']['prev_money']));
		echo '<dt>'.__('Contact1').'</dt><dd>'.$order['Order']['contact1_name'].'　</dd>';
		echo $form->hidden('Order.contact1', array('value'=>$order['Order']['contact1']));
		echo '<dt>'.__('Contact2').'</dt><dd>'.$order['Order']['contact2_name'].'　</dd>';
		echo $form->hidden('Order.contact2', array('value'=>$order['Order']['contact2']));
		echo '<dt>'.__('Contact3').'</dt><dd>'.$order['Order']['contact3_name'].'　</dd>';
		echo $form->hidden('Order.contact3', array('value'=>$order['Order']['contact3']));
		echo '<dt>'.__('Contact4').'</dt><dd>'.$order['Order']['contact4_name'].'　</dd>';
		echo $form->hidden('Order.contact4', array('value'=>$order['Order']['contact4']));
		
		
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
		echo '<dt>'.__('Remarks').'</dt><dd>'.$order['Order']['remark'].'　</dd>';
		echo $form->hidden('Order.remark', array('value'=>$order['Order']['remark']));
		
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
		echo '<table class="itemDetail"><tr><th>子品番</th><th>上代</th><th>納期</th><th>出荷</th><th>倉庫</th><th>売上</th><th>破棄</th><th>引当</th><th>発注</th><th>完了</th>';
		echo '<th>お渡し</th></tr>';
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
			echo '<td>'.substr($detail['specified_date'], 5, 5).'</td>';
			echo '<td>'.substr($detail['shipping_date'], 5, 5).'</td>';
			echo '<td>';
			echo $form->input('OrderDateil.'.$key.'.depot_id', array(
			'type'=>'select',
				'options'=>$sectionDepots,
				'div'=>false,
				'value'=>$detail['depot_id'],
				'label'=>false
			));
			echo '</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '<td>'.$detail['an_quantity'].'</td>';
			echo '<td>'.$detail['pairing_quantity'].'</td>';
			echo '<td>'.$detail['ordering_quantity'].'</td>';
			echo '<td>'.$detail['sell_quantity'].'</td>';
			echo '<td>';
			$qty_diff = $detail['bid_quantity'] - $detail['sell_quantity'];
			if($qty_diff > 0){
				//order_type 4 だったら、JANの入力枠を表示
				if($detail['order_type'] == 4){
					echo $form->input('OrderDateil.'.$key.'.subitem_jan', array(
						'type'=>'text',
						'div'=>false,
						'label'=>false,
 						'size'=>10,
 						'value'=>'JAN入力'
					));
				}else{
					echo $form->input('OrderDateil.'.$key.'.sell_quantity', array(
						'type'=>'text',
						'div'=>false,
						'label'=>false,
 						'size'=>1,
 						'value'=>$sell_qty
					));
				}
				
			}
			
			echo '</td>';
			echo '</tr>';
			if(empty($detail['span_no'])) $detail['span_no'] = '';
			if(empty($detail['discount'])) $detail['discount'] = '';
			if(empty($detail['adjustment'])) $detail['adjustment'] = '';
			if(empty($detail['sub_remarks'])) $detail['sub_remarks'] = '';
			
			echo $form->hidden('OrderDateil.'.$key.'.id', array('value'=>$detail['id']));
			echo $form->hidden('OrderDateil.'.$key.'.ex_bid', array('value'=>$detail['ex_bid']));
			echo $form->hidden('OrderDateil.'.$key.'.bid', array('value'=>$detail['bid']));
			echo $form->hidden('OrderDateil.'.$key.'.subitem_id', array('value'=>$detail['subitem_id']));
			echo $form->hidden('OrderDateil.'.$key.'.subitem_name', array('value'=>$detail['subitem_name']));
			echo $form->hidden('OrderDateil.'.$key.'.marking', array('value'=>$detail['marking']));
			echo $form->hidden('OrderDateil.'.$key.'.span_no', array('value'=>$detail['span_no']));
			echo $form->hidden('OrderDateil.'.$key.'.discount', array('value'=>$detail['discount']));
			echo $form->hidden('OrderDateil.'.$key.'.adjustment', array('value'=>$detail['adjustment']));
			echo $form->hidden('OrderDateil.'.$key.'.sub_remarks', array('value'=>$detail['sub_remarks']));
			echo $form->hidden('OrderDateil.'.$key.'.bid_quantity', array('value'=>$detail['bid_quantity']));
			echo $form->hidden('OrderDateil.'.$key.'.before_sell_quantity', array('value'=>$detail['sell_quantity']));
			
			$total_quantity = $total_quantity + $detail['bid_quantity'];
			$total_an = $total_an + $detail['an_quantity'];
			$total_pairing = $total_pairing + $detail['pairing_quantity'];
			$total_ordering = $total_ordering + $detail['ordering_quantity'];
			$total_sell = $total_sell + $detail['sell_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td><td>'.$total_an.'</td><td>'.$total_pairing.'</td><td>'.$total_ordering.'</td><td>'.$total_sell.'</td><td></td></tr>';
		echo '</table>';
		echo $form->end(__('Submit', true));
	?>
</div>
<hr>