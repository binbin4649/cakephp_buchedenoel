<div class="view">
<?php echo '<p>'.$html->link(__('Invoice List', true), array('controller'=>'invoices', 'action'=>'index')).'</p>'; ?>
	<fieldset>
 		<h3><?php __('View Invoice');?></h3>
	<?php
		echo '<dl>';
		echo '<dt>'.__('Invoice No.').'</dt><dd>'.$invoice['Invoice']['id'].'　</dd>';
		echo '<dt>'.__('Status').'</dt><dd>'.$invoiceStatus[$invoice['Invoice']['invoice_status']].'　</dd>';
		echo '<dt>'.__('Section').'</dt><dd>'.$invoice['Section']['name'].'　</dd>';
		echo '<dt>'.__('Billing').'</dt><dd>'.$invoice['Billing']['name'].'　</dd>';
		echo '<dt>'.__('Invoice Date').'</dt><dd>'.$invoice['Invoice']['date'].'　</dd>';
		echo '<dt>'.__('Collect Bill').'</dt><dd>'.$invoice['Invoice']['payment_day'].'　</dd>';
		echo '<dt>'.__('Close Date').'</dt><dd>'.$invoice['Invoice']['total_day'].'　</dd>';
		echo '<dt>'.__('Previous Invoice').'</dt><dd>'.number_format($invoice['Invoice']['previous_invoice']).'　</dd>';
		echo '<dt>'.__('Previous Deposit').'</dt><dd>'.number_format($invoice['Invoice']['previous_deposit']).'　</dd>';
		echo '<dt>'.__('Balance Forward').'</dt><dd>'.number_format($invoice['Invoice']['balance_forward']).'　</dd>';
		echo '<dt>'.__('Month Total').'</dt><dd>'.number_format($invoice['Invoice']['month_total']).'　</dd>';
		echo '<dt>'.__('Adjustment').'</dt><dd>'.number_format($invoice['Invoice']['adjustment']).'　</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($invoice['Invoice']['total']).'　</dd>';
		echo '<dt>'.__('Sales Total').'</dt><dd>'.number_format($invoice['Invoice']['sales']).'　</dd>';
		echo '<dt>'.__('Tax').'</dt><dd>'.number_format($invoice['Invoice']['tax']).'　</dd>';
		echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($invoice['Invoice']['shipping']).'　</dd>';
		echo '<dt>'.__('Created').'</dt><dd>'.$invoice['Invoice']['created_user'].':'.$invoice['Invoice']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$invoice['Invoice']['updated_user'].':'.$invoice['Invoice']['updated'].'　</dd>';
		if(!empty($print)) echo '<dt>'.__('File').'</dt><dd><a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a></dd>';
		echo '<dt>'.__('Remarks').'</dt><dd>'.nl2br($invoice['Invoice']['remark']).'　</dd>';
		echo '</dl>';
		echo '<ul>';
		echo '<li>'.$html->link(__('Edit', true), array('controller'=>'invoices', 'action'=>'edit/'.$invoice['Invoice']['id'])).'</li>';
		echo '<li>'.$html->link(__('Invoice Print', true), array('controller'=>'invoices', 'action'=>'invoice_print/'.$invoice['Invoice']['id'])).'</li>';
		echo '</ul>';
		echo '<table class="itemDetail"><tr><th colspan="10">請求明細</th></tr><tr><th>売上番号</th><th>出荷先</th><th>売上日</th><th>調整</th><th>送料</th><th>消費税</th><th>商品計</th><th>合計</th></tr>';
		foreach($invoice['InvoiceDateil'] as $detail){
			echo '<tr>';
			echo '<td>'.$html->link($detail['sale_id'], array('controller'=>'sales', 'action'=>'view/'.$detail['sale_id'])).'</td>';
			echo '<td>'.mb_substr($detail['destination_name'], 0, 10).'</td>';
			echo '<td>'.$detail['sale_date'].'</td>';
			echo '<td>'.number_format($detail['adjustment']).'</td>';
			echo '<td>'.number_format($detail['shipping']).'</td>';
			echo '<td>'.number_format($detail['tax']).'</td>';
			echo '<td>'.number_format($detail['sale_items']).'</td>';
			echo '<td>'.number_format($detail['sale_total']).'</td>';
			echo '</tr>';
		}
		echo '</table>';
		if(!empty($invoice['Credit'])){//まだ。これから　9/22
			echo '<table class="itemDetail"><tr><th colspan="6">入金明細</th></tr>';
			echo '<tr><th>Id</th><th>入金日</th><th>支払方法</th><th>消込金額</th></tr>';
			foreach($invoice['Credit'] as $credit){
				echo '<tr>';
				echo '<td>'.$html->link($credit['id'], array('controller'=>'credits', 'action'=>'view/'.$credit['id'])).'</td>';
				echo '<td>'.$credit['date'].'</td>';
				echo '<td>'.$creditMethods[$credit['credit_methods']].'</td>';
				echo '<td>'.number_format($credit['reconcile_amount']).'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	?>
	</fieldset>
</div>
<?php //pr($invoice); ?>