<div class="purchases view">
<?php echo '<p>'.$addForm->switchAnchor('purchases/add/buying/'.$purchase['Purchase']['ordering_id'], array(2,3), null, 'Return', $purchase['Purchase']['purchase_status']).'</p>'; ?>
	<fieldset>
 		<h2><?php __('Add Buying Confirm');?></h2>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Status').'</dt><dd>'.$purchaseStatus[$purchase['Purchase']['purchase_status']].'　</dd>';
		echo '<dt>'.__('Invoices No').'</dt><dd>'.$purchase['Purchase']['invoices'].'　</dd>';
		echo '<dt>'.__('Factory Name').'</dt><dd>'.$purchase['Factory']['name'].'　</dd>';
		echo '<dt>'.__('Purchase Date').'</dt><dd>'.$purchase['Purchase']['date'].'　</dd>';
		echo '<dt>'.__('Purchase Total').'</dt><dd>'.number_format($purchase['Purchase']['total']).'　</dd>';
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($purchase['Purchase']['detail_total']).'　</dd>';
		echo '<dt>'.__('Total Tax').'</dt><dd>'.number_format($purchase['Purchase']['total_tax']).'　</dd>';
		echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($purchase['Purchase']['shipping']).'　</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($purchase['Purchase']['adjustment']).'　</dd>';
		echo '<dt>'.__('Remarks').'</dt><dd>'.$purchase['Purchase']['remark'].'　</dd>';
		echo '<dt>'.__('File').'</dt><dd>';
		if(!empty($print)){
			echo '<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>';
		}
		echo '　</dd>';
		echo '</dl>';
		$purchase_quantity = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>受注</th><th>倉庫:No</th><th>仕入@</th><th>仕入数</th></tr>';
		foreach($purchaseDetail as $detail){
			echo '<tr>';
			if($detail['Item']['stock_code'] == 3){
				echo '<td>'.$detail['Subitem']['name'].$html->link(' (edit)', array('controller'=>'subitems', 'action'=>'edit/'.$detail['Subitem']['id']), array('target'=>'_blank')).'</td>';
			}else{
				echo '<td>'.$detail['Subitem']['name'].'</td>';
			}
			echo '<td>'.$html->link($detail['PurchaseDetail']['order_id'], array('controller'=>'orders', 'action'=>'view/'.$detail['PurchaseDetail']['order_id'])).'</td>';
			echo '<td>'.$detail['Depot']['name'].':'.$detail['Depot']['id'].'</td>';
			echo '<td>'.number_format($detail['PurchaseDetail']['bid']).'</td>';
			echo '<td>'.$detail['PurchaseDetail']['quantity'].'</td>';
			echo '</tr>';
			$purchase_quantity = $purchase_quantity + $detail['PurchaseDetail']['quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td>数量合計</td><td>'.$purchase_quantity.'</td></tr>';
		echo '</table>';
		echo '<p>'.$addForm->switchAnchor('purchases/add_confirm/ok/', array(2,3), 'Confirm purchase. Are you sure?', 'Buying Confirm', $purchase['Purchase']['purchase_status']).'</p>';
	?>
	</fieldset>
</div>
<?php //pr($purchase); ?>