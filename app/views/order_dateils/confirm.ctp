<div class="view">
	<fieldset>
 		<h3><?php __('Input Sales Confirm');?></h3>
	<?php
		$contact1 = $Confirm['order']['contact1_name'];
		if(!empty($Confirm['order']['contact2_name'])) $contact1 .= '、'.$Confirm['order']['contact2_name'];
		$contact2 = '';
		if(!empty($Confirm['order']['contact3_name'])) $contact2 .= ''.$Confirm['order']['contact3_name'];
		if(!empty($Confirm['order']['contact4_name'])) $contact2 .= '、'.$Confirm['order']['contact4_name'];
		$pairing = '';
		if(!empty($Confirm['order']['pairing1'])) $pairing .= '、'.$Confirm['order']['pairing1'];
		if(!empty($Confirm['order']['pairing2'])) $pairing .= '、'.$Confirm['order']['pairing2'];
		if(!empty($Confirm['order']['pairing3'])) $pairing .= '、'.$Confirm['order']['pairing3'];
		if(!empty($Confirm['order']['pairing4'])) $pairing .= '、'.$Confirm['order']['pairing4'];
		if(empty($Confirm['order']['destination_name'])) $Confirm['order']['destination_name'] = '';
		if(empty($Confirm['order']['section_name'])) $Confirm['order']['section_name'] = '';
		if(empty($Confirm['order']['depot_name'])) $Confirm['order']['depot_name'] = '';
		if(empty($Confirm['order']['depot_id'])) $Confirm['order']['depot_id'] = '';
		if(empty($Confirm['order']['partners_no'])) $Confirm['order']['partners_no'] = '';
		if(empty($Confirm['order']['events_no'])) $Confirm['order']['events_no'] = '';
		if(empty($Confirm['order']['span_no'])) $Confirm['order']['span_no'] = '';
		if(empty($Confirm['order']['customers_name'])) $Confirm['order']['customers_name'] = '';
		if(empty($Confirm['order']['remark'])) $Confirm['order']['remark'] = '';
		if(empty($Confirm['order']['prev_money'])) $Confirm['order']['prev_money'] = '';
		// access_authority　が　'2'=>'Shop Staff'　だったら　store_add
		if($sorting == 2){
			$return_action = 'store_add';
		}else{
			$return_action = 'store_add';
		}
		echo '<dl>';
		if(!empty($Confirm['order']['order_status'])){
			echo '<dt>'.__('Order Type').'</dt><dd>'.$orderStatus[$Confirm['order']['order_status']].'　</dd>';
		}
		echo '<dt>'.__('Sale Date').'</dt><dd>'.$Confirm['order']['date'].'　</dd>';
		echo '<dt>'.__('Section').'</dt><dd>'.$Confirm['order']['section_name'].':'.$Confirm['order']['section_id'].'</dd>';
		echo '<dt>'.__('Destination').'</dt><dd>'.$Confirm['order']['destination_name'].'　</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$Confirm['order']['partners_no'].'　</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$Confirm['order']['events_no'].'　</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$Confirm['order']['customers_name'].'　</dd>';
		echo '<dt>'.__('Remarks').'</dt><dd>'.$Confirm['order']['remark'].'　</dd>';
		echo '<dt>'.__('Total(in tax)').'</dt><dd><b>'.number_format($Confirm['order']['total']).'　('.number_format($Confirm['order']['total_tax']).')　</b></dd>';
		echo '<dt>'.__('Shipping,Adjustment').'</dt><dd>'.number_format($Confirm['order']['shipping']).'　,　'.number_format($Confirm['order']['adjustment']).'</dd>';
		echo '<dt>'.__('Prev Money').'</dt><dd>'.number_format($Confirm['order']['prev_money']).'　</dd>';
		echo '<dt>'.__('Contact1、2').'</dt><dd>'.$contact1.'</dd>';
		echo '<dt>'.__('Contact3、4').'</dt><dd>'.$contact2.'　</dd>';
		//echo '<dt>'.__('Pairing').'</dt><dd>'.$pairing.'　</dd>';
		echo '</dl>';
		echo '<ul>';
		echo '<li>'.$addForm->switchAnchor('order_dateils/add_confirm', array(), 'register an order. Are you all right?', 'Input Sales Confirm', null).'</li>';
		echo '<li>'.$html->link(__('Return', true), array('controller'=>'order_dateils', 'action'=>$return_action)).'</li>';
		echo '</ul>';
		$total_quantity = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>価格</th><th>納期</th><th>刻印</th><th>数量</th><th>倉庫</th><th>区分</th><th>スパン</th><th>割引</th><th>調整</th><th>備考</th></tr>';
		foreach($Confirm['details'] as $detail){
			if($detail['Subitem']['order_type'] == 4 AND !empty($detail['Subitem']['major_size'])){
				if($detail['Subitem']['major_size'] == 'other'){
					$detail['Subitem']['name'] = $detail['Subitem']['name'].'('.$detail['Subitem']['minority_size'].')';
				}else{
					$detail['Subitem']['name'] = $detail['Subitem']['name'].'('.$detail['Subitem']['major_size'].')';
				}
			}
			echo '<tr>';
			echo '<td>'.$detail['Subitem']['name'].'</td>';
			echo '<td>'.number_format($detail['Item']['price']).'</td>';
			echo '<td>'.$detail['Subitem']['specified_date'].'</td>';
			echo '<td>'.$detail['Subitem']['marking'].'</td>';
			echo '<td>'.$detail['Subitem']['quantity'].'</td>';
			echo '<td>'.$detail['Subitem']['depot_id'].'</td>';
			echo '<td>'.$orderType[$detail['Subitem']['order_type']].'</td>';
			echo '<td>'.$detail['Subitem']['span_no'].'</td>';
			echo '<td>'.$detail['Subitem']['discount'].'</td>';
			echo '<td>'.$detail['Subitem']['adjustment'].'</td>';
			echo '<td>'.$detail['Subitem']['sub_remarks'].'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['Subitem']['quantity'];
		}
		echo '<tr><td>合計</td><td>'.number_format($Confirm['order']['price_total']).'</td><td></td><td></td><td>'.$total_quantity.'</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		echo '</table>';
	?>
	</fieldset>
</div>