<div class="view">
<?php echo '<p>'.$html->link(__('Return Invoice No.'.$invoice['Invoice']['id'], true), array('controller'=>'invoices', 'action'=>'view/'.$invoice['Invoice']['id'])).'</p>'; ?>
	<fieldset>
 		<h3><?php __('Edit Invoice');?></h3>
	<?php
		echo $form->create('Invoice', array('controller'=>'invoices', 'action'=>'edit'));
		echo '<dl>';
		echo '<dt>'.__('Invoice No.').'</dt><dd>'.$invoice['Invoice']['id'].'　</dd>';
		echo $form->hidden('Invoice.id', array('value'=>$invoice['Invoice']['id']));
		echo '<dt>'.__('Status').'</dt><dd>';
		echo $form->input('Invoice.invoice_status', array(
			'type'=>'select',
			'label'=>false,
			'selected'=>$invoice['Invoice']['invoice_status'],
			'options'=>$invoiceStatus,
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Section').'</dt><dd>'.$invoice['Section']['name'].'　</dd>';
		echo '<dt>'.__('Billing').'</dt><dd>'.$invoice['Billing']['name'].'　</dd>';
		echo '<dt>'.__('Invoice Date').'</dt><dd>';
		echo $form->input('Invoice.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'selected'=>$invoice['Invoice']['date'],
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Collect Bill').'</dt><dd>';
		echo $form->input('Invoice.payment_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'selected'=>$invoice['Invoice']['payment_day'],
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Close Date').'</dt><dd>';
		echo $form->input('Invoice.total_day', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'selected'=>$invoice['Invoice']['total_day'],
			'div'=>false
		));
		echo '</dd>';
		echo '<dt>'.__('Previous Invoice').'</dt><dd>'.number_format($invoice['Invoice']['previous_invoice']).'　</dd>';
		echo $form->hidden('Invoice.previous_invoice', array('value'=>$invoice['Invoice']['previous_invoice']));
		echo '<dt>'.__('Previous Deposit').'</dt><dd>'.number_format($invoice['Invoice']['previous_deposit']).'　</dd>';
		echo $form->hidden('Invoice.previous_deposit', array('value'=>$invoice['Invoice']['previous_deposit']));
		echo '<dt>'.__('Balance Forward').'</dt><dd>'.number_format($invoice['Invoice']['balance_forward']).'　</dd>';
		echo $form->hidden('Invoice.balance_forward', array('value'=>$invoice['Invoice']['balance_forward']));
		echo '<dt>'.__('Month Total').'</dt><dd>'.number_format($invoice['Invoice']['month_total']).'　</dd>';
		echo $form->hidden('Invoice.month_total', array('value'=>$invoice['Invoice']['month_total']));
		echo '<dt>'.__('Adjustment').'</dt><dd>';
		echo $form->input('Invoice.adjustment', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
 			'size'=>10,
 			'value'=>$invoice['Invoice']['adjustment']
		));
		echo '</dd>';
		echo '<dt>'.__('Total').'</dt><dd>'.number_format($invoice['Invoice']['total']).'　</dd>';
		echo $form->hidden('Invoice.total', array('value'=>$invoice['Invoice']['total']));
		echo '<dt>'.__('Sales Total').'</dt><dd>'.number_format($invoice['Invoice']['sales']).'　</dd>';
		echo $form->hidden('Invoice.sales', array('value'=>$invoice['Invoice']['sales']));
		echo '<dt>'.__('Tax').'</dt><dd>'.number_format($invoice['Invoice']['tax']).'　</dd>';
		echo $form->hidden('Invoice.tax', array('value'=>$invoice['Invoice']['tax']));
		echo '<dt>'.__('Shipping').'</dt><dd>'.number_format($invoice['Invoice']['shipping']).'　</dd>';
		echo $form->hidden('Invoice.shipping', array('value'=>$invoice['Invoice']['shipping']));
		echo '<dt>'.__('Created').'</dt><dd>'.$invoice['Invoice']['created_user'].':'.$invoice['Invoice']['created'].'　</dd>';
		echo '<dt>'.__('Updated').'</dt><dd>'.$invoice['Invoice']['updated_user'].':'.$invoice['Invoice']['updated'].'　</dd>';
		if(!empty($print)) echo '<dt>'.__('File').'</dt><dd><a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a></dd>';
		echo '</dl>';
		echo $form->input('Invoice.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45,
			'value'=>$invoice['Invoice']['remark']
		));
		echo '<table class="itemDetail"><tr><th colspan="6">請求明細</th></tr><tr><th>売上番号</th><th>出荷先</th><th>売上日</th><th>合計金額</th></tr>';
		foreach($invoice['InvoiceDateil'] as $detail){
			echo '<tr>';
			echo '<td>'.$html->link($detail['sale_id'], array('controller'=>'sales', 'action'=>'view/'.$detail['sale_id'])).'</td>';
			echo '<td>'.mb_substr($detail['destination_name'], 0, 12).'</td>';
			echo '<td>'.$detail['sale_date'].'</td>';
			echo '<td>'.number_format($detail['sale_total']).'</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo $form->end(__('Submit', true));
	?>
	</fieldset>
</div>
<ul>
	<li>編集画面で今月請求額は、調整前の金額が表示されます。</li>
</ul>
<?php //pr($invoice);?>