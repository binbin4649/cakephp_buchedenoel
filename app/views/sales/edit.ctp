<div class="view">
<?php echo '<p>'.$html->link(__('Return View No.'.$sale['Sale']['id'], true), array('controller'=>'sales', 'action'=>'view/'.$sale['Sale']['id'])).'</p>'; ?>
	<fieldset>
 		<h3><?php __('Edit Sale');?></h3>
	<?php
		echo $form->create('Sale', array('action'=>'edit'));
		echo '<dl>';
		echo '<dt>'.__('Sale No.').'</dt><dd>'.$sale['Sale']['id'].'　</dd>';
		echo $form->hidden('Sale.id', array('value'=>$sale['Sale']['id']));
		echo '<dt>'.__('Sale Type').'</dt><dd>';
		echo $form->input('Sale.sale_type', array(
			'type'=>'select',
			'label'=>false,
			'selected'=>$sale['Sale']['sale_type'],
			'options'=>$saleType,
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$saleStatus[$sale['Sale']['sale_status']].'　</dd>';
		echo '<dt>'.__('Sale Date').'</dt><dd>';
		echo $form->input('Sale.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>MINYEAR,
			'maxYear' => MAXYEAR,
			'selected'=>$sale['Sale']['date'],
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Close Date').'</dt><dd>';
		echo $form->input('Sale.total_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>MINYEAR,
			'maxYear' => MAXYEAR,
			'selected'=>$sale['Sale']['total_day'],
			'empty'=>'select',
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Depot').'</dt><dd>';
		echo $form->input('Sale.depot_id', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>2,
 			'value'=>$sale['Sale']['depot_id']
		));
		echo $sale['Depot']['name'].'</dd>';
		echo '<dt>'.__('Destination').'</dt><dd>';
		echo $form->input('Sale.destination_id', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>2,
 			'value'=>$sale['Sale']['destination_id']
		));
		echo $sale['Destination']['name'].'</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>';
		echo $form->input('Sale.partners_no', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>15,
 			'value'=>$sale['Sale']['partners_no']
		));
		echo '</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>';
		echo $form->input('Sale.event_no', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>15,
 			'value'=>$sale['Sale']['event_no']
		));
		echo '</dd>';
		echo '<dt>'.__('Span No.').'</dt><dd>';
		echo $form->input('Sale.span_no', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>15,
 			'value'=>$sale['Sale']['span_no']
		));
		echo '</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>';
		echo $form->input('Sale.customers_name', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>20,
 			'value'=>$sale['Sale']['customers_name']
		));
		echo '</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($sale['Sale']['total']).'　</dd>';
		echo $form->hidden('Sale.total', array('value'=>$sale['Sale']['total']));
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($sale['Sale']['item_price_total']).'　</dd>';
		echo $form->hidden('Sale.item_price_total', array('value'=>$sale['Sale']['item_price_total']));
		echo '<dt>'.__('Tax').'</dt><dd>'.number_format($sale['Sale']['tax']).'　</dd>';
		echo $form->hidden('Sale.tax', array('value'=>$sale['Sale']['tax']));
		echo '<dt>'.__('Shipping').'</dt><dd>';
		echo $form->input('Sale.shipping', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$sale['Sale']['shipping']
		));
		echo '</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>';
		echo $form->input('Sale.adjustment', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$sale['Sale']['adjustment']
		));
		echo '</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>';
		echo $form->input('Sale.contact1', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$sale['Sale']['contact1']
		));
		echo $sale['Sale']['contact1_name'].'</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>';
		echo $form->input('Sale.contact2', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$sale['Sale']['contact2']
		));
		echo $sale['Sale']['contact2_name'].'</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>';
		echo $form->input('Sale.contact3', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$sale['Sale']['contact3']
		));
		echo $sale['Sale']['contact3_name'].'</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>';
		echo $form->input('Sale.contact4', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>5,
 			'value'=>$sale['Sale']['contact4']
		));
		echo $sale['Sale']['contact4_name'].'</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$sale['Sale']['created_user'].':'.$sale['Sale']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$sale['Sale']['updated_user'].':'.$sale['Sale']['updated'].'　</dd>';
		if(!empty($print)) echo '<dt>'.__('File').'</dt><dd><a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a></dd>';
		echo '</dl>';
		echo $form->input('Sale.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45,
			'value'=>$sale['Sale']['remark']
		));

		$total_quantity = 0;
		echo '<table class="itemDetail"><tr><th colspan="6">売上明細</th></tr><tr><th>子品番</th><th>売上単価</th><th>参考上代</th><th>原価</th><th>刻印</th><th>数量</th></tr>';
		foreach($sale['SalesDateil'] as $detail){
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'].'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.number_format($detail['ex_bid']).'</td>';
			echo '<td>'.number_format($detail['cost']).'</td>';
			echo '<td>'.$detail['marking'].'</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['bid_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td></tr>';
		echo '</table>';
		echo $form->end(__('Submit', true));
	?>
	</fieldset>
</div>
<hr>
<ul>
	<li>「調整」以外にマイナス入力はしないでください。たぶん可笑しくなります。</li>
</ul>