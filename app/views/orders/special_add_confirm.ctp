<a href="javascript:history.back();">戻る</a>
<div class="itemsView">
<h5><?php __('Spacial Order Confirm') ?></h5>
	<fieldset>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Brand').'</dt><dd>'.$item['Brand']['name'].'　</dd>';
		echo '<dt>'.__('Parent Item:').'</dt><dd>'.$item['Item']['name'].'　</dd>';
		echo '<dt>'.__('Section').'</dt><dd>'.$depot['Section']['name'].'　</dd>';
		echo '<dt>'.__('Depot').'</dt><dd>'.$depot['Depot']['name'].':'.$depot['Depot']['id'].'　</dd>';
		echo '<dt>'.__('Destination').'</dt><dd>'.$confirm['Order']['destination_name'].'　</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($total).'　</dd>';
		echo '<dt>'.__('Item Total').'</dt><dd>'.number_format($item['Item']['price']).'　</dd>';
		echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($confirm['Order']['shipping']).'　</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($confirm['Order']['adjustment']).'　</dd>';
		echo '<dt>'.__('Events No.').'</dt><dd>'.$confirm['Order']['events_no'].'　</dd>';
		echo '<dt>'.__('Span No.').'</dt><dd>'.$confirm['Order']['span_no'].'　</dd>';
		echo '<dt>'.__('Order Date').'</dt><dd>'.$confirm['Order']['date']['year'].'-'.$confirm['Order']['date']['month'].'-'.$confirm['Order']['date']['day'].'　</dd>';
		echo '<dt>'.__('Specified Date').'</dt><dd>'.$confirm['OrderDateil']['specified_date']['year'].'-'.$confirm['OrderDateil']['specified_date']['month'].'-'.$confirm['OrderDateil']['specified_date']['day'].'　</dd>';
		echo '<dt>'.__('Contact1').'</dt><dd>'.$confirm['Order']['contact1_name'].'　</dd>';
		echo '<dt>'.__('Contact2').'</dt><dd>'.$confirm['Order']['contact2_name'].'　</dd>';
		echo '<dt>'.__('Contact3').'</dt><dd>'.$confirm['Order']['contact3_name'].'　</dd>';
		echo '<dt>'.__('Contact4').'</dt><dd>'.$confirm['Order']['contact4_name'].'　</dd>';
		echo '<dt>'.__('Customers Name').'</dt><dd>'.$confirm['Order']['customers_name'].'　</dd>';
		echo '<dt>'.__('Partners No.').'</dt><dd>'.$confirm['Order']['partners_no'].'　</dd>';
		echo '<dt>'.__('Major Size').'</dt><dd>'.$confirm['Subitem']['major_size'].'　</dd>';
		echo '<dt>'.__('Minority  Size').'</dt><dd>'.$confirm['Subitem']['minority_size'].'　</dd>';
		echo '<dt>'.__('Marking').'</dt><dd>'.$confirm['OrderDateil']['marking'].'　</dd>';
		if(!empty($confirm['Subitem']['process_id'])){
			echo '<dt>'.__('Process').'</dt><dd>'.$processes[$confirm['Subitem']['process_id']].'　</dd>';
		}
		if(!empty($confirm['Subitem']['material_id'])){
			echo '<dt>'.__('Material').'</dt><dd>'.$materials[$confirm['Subitem']['material_id']].'　</dd>';
		}
		echo '<dt>'.__('Carat').'</dt><dd>'.$confirm['Subitem']['carat'].'　</dd>';
		echo '<dt>'.__('Color').'</dt><dd>'.$confirm['Subitem']['color'].'　</dd>';
		echo '<dt>'.__('Clarity').'</dt><dd>'.$confirm['Subitem']['clarity'].'　</dd>';
		echo '<dt>'.__('Cut').'</dt><dd>'.$confirm['Subitem']['cut'].'　</dd>';
		echo '</dl>【受注データの備考】<br>';
		echo nl2br($confirm['Order']['remark']);
		echo '<br><br>';
		echo $html->link(__('Spacial Order Confirm', true), array('controller'=>'order_dateils', 'action'=>'store_add/special'), null, sprintf(__('Input Special Order. Are you all right?', true), null));
	?>
</fieldset>
</div>

<hr>
<?php
//pr($total);
//pr($item);
;?>