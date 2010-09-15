<div class="purchases view">
<p><?php echo $html->link(__('List Purchases', true), array('controller'=> 'purchases', 'action'=>'index')); ?> </p>
	<fieldset>
 		<h2><?php __('Purchase View');?></h2>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Purchase No.').'</dt><dd>'.$purchase['Purchase']['id'].'　</dd>';
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
		echo '<dt>'.__('Created User').'</dt><dd>'.$purchase['Purchase']['created_user'].':'.$purchase['Purchase']['created'].'</dd>';
		echo '<dt>'.__('Updated User').'</dt><dd>'.$purchase['Purchase']['updated_user'].':'.$purchase['Purchase']['updated'].'</dd>';
		echo '</dl>';
		echo '<ul>';
		echo '<li>'.$addForm->switchAnchor('purchases/edit/'.$purchase['Purchase']['id'], array(), null, 'Edit Purchase', null).'</li>';
		echo '<li>'.$addForm->switchAnchor('pays/index/doing/'.$purchase['Purchase']['id'], array(3, 4), 'Tighten by hand. Are you sure?', 'Tightening process manually', $purchase['Purchase']['purchase_status']).'</li>';
		echo '</ul>';
		$purchase_quantity = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>受注</th><th>倉庫:No</th><th>仕入@</th><th>仕入数</th></tr>';
		foreach($purchase['PurchaseDetail'] as $detail){
			echo '<tr>';
			if($detail['stock_code'] == 3){
				echo '<td>'.$detail['subitem_name'].$html->link(' (edit)', array('controller'=>'subitems', 'action'=>'edit/'.$detail['subitem_id']), array('target'=>'_blank')).'</td>';
			}else{
				echo '<td>'.$detail['subitem_name'].'</td>';
			}
			echo '<td>'.$html->link($detail['order_id'], array('controller'=>'orders', 'action'=>'view/'.$detail['order_id'])).'</td>';
			echo '<td>'.$detail['depot_name'].':'.$detail['depot'].'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.$detail['quantity'].'</td>';
			echo '</tr>';
			$purchase_quantity = $purchase_quantity + $detail['quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td>数量合計</td><td>'.$purchase_quantity.'</td></tr>';
		echo '</table>';
	?>
	</fieldset>
</div>
<?php //pr($purchase); ?>