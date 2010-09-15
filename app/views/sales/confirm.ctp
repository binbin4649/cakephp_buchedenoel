<div class="view">
	<fieldset>
 		<h3><?php __('Confirm Sale');?></h3>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Sale Type').'</dt><dd>'.$saleType[$Confirm['detail']['sale_type']].'　</dd>';
		echo '<dt>'.__('Sale Date').'</dt><dd>'.$Confirm['detail']['date']['year'].'-'.$Confirm['detail']['date']['month'].'-'.$Confirm['detail']['date']['day'].'　</dd>';
		echo '<dt>'.__('Depot').'</dt><dd>'.$Confirm['detail']['depot_id'].'</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$Confirm['detail']['events_no'].'　</dd>';
		echo '<dt>'.__('Span No.').'</dt><dd>'.$Confirm['detail']['span_no'].'　</dd>';
		echo '<dt>'.__('Remarks').'</dt><dd>'.$Confirm['detail']['remark'].'　</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($Confirm['detail']['total']).'　</dd>';
		echo '<dt>'.__('Detail Total').'</dt><dd>'.number_format($Confirm['detail']['item_price_total']).'　</dd>';
		echo '<dt>'.__('Tax').'</dt><dd>'.number_format($Confirm['detail']['tax']).'　</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($Confirm['detail']['adjustment']).'　</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>'.$Confirm['detail']['contact1_name'].'</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>'.$Confirm['detail']['contact2_name'].'　</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>'.$Confirm['detail']['contact3_name'].'　</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>'.$Confirm['detail']['contact4_name'].'　</dd>';

		echo '</dl>';
		echo '<ul>';
		echo '<li>'.$addForm->switchAnchor('sales/add_confirm', array(), 'register an sale. Are you all right?', 'Confirm Sale', null).'</li>';
		echo '<li>'.$html->link(__('Return', true), array('controller'=>'sales', 'action'=>'add')).'</li>';
		echo '</ul>';
		$total_quantity = 0;
		echo '<table class="itemDetail"><tr><th>子品番</th><th>価格</th><th>数量</th></tr>';
		foreach($Confirm['subitems'] as $detail){
			echo '<tr>';
			echo '<td>'.$detail['Subitem']['name'].'</td>';
			echo '<td>'.number_format($detail['Subitem']['price']).'</td>';
			echo '<td>'.$detail['Subitem']['qty'].'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['Subitem']['qty'];
		}
		echo '<tr><td></td><td>数量合計</td><td>'.$total_quantity.'</td></tr>';
		echo '</table>';
	?>
	</fieldset>
</div>
<?php //pr($Confirm);?>