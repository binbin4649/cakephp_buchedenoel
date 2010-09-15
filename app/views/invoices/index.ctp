<div class="invoices index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('Invoices');?></h2>
<?php
$modelName = 'Invoice';
echo $form->create($modelName ,array('action'=>'index'));
echo __('Id');
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>4,
	'div'=>false
));
echo '　';
echo __('Billing');
echo $form->text($modelName.'.billing_id', array(
	'type'=>'text',
	'size'=>4,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.invoice_status', array(
	'type'=>'select',
	'options'=>$invoiceStatus,
	'label'=>__('Status', true),
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<br></br><a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo __('Invoice Date', true);
echo $form->input($modelName.'.start_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '<br><br>';
echo __('Collect Bill', true);
echo $form->input($modelName.'.start_payment_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_payment_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '<br><br>';
echo __('Close Date', true);
echo $form->input($modelName.'.start_total_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_total_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '　　';
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV出力';
	echo $form->checkbox($modelName.'.csv');
}
echo $form->end();
?>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort(__('Status', true),'invoice_status');?></th>
	<th><?php echo $paginator->sort('billing_id');?></th>
	<th><?php echo $paginator->sort(__('Invoice Date', true), 'date');?></th>
	<th><?php echo $paginator->sort('balance_forward');?></th>
	<th><?php echo $paginator->sort('Invoice Type');?></th>
	<th><?php echo $paginator->sort('month_total');?></th>
</tr>
<?php
$i = 0;
foreach ($invoices as $invoice):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($invoice['Invoice']['id'], array('action'=>'view', $invoice['Invoice']['id'])); ?>
		</td>
		<td>
			<?php echo $invoiceStatus[$invoice['Invoice']['invoice_status']]; ?>
		</td>
		<td>
			<?php echo mb_substr($invoice['Billing']['name'], 0, 10); ?>
		</td>
		<td>
			<?php echo $invoice['Invoice']['date']; ?>
		</td>
		<td>
			<?php echo $invoice['Invoice']['balance_forward']; ?>
		</td>
		<td>
			<?php if(!empty($invoice['Billing']['invoice_type'])) echo $invoiceType[$invoice['Billing']['invoice_type']]; ?>
		</td>
		<td>
			<?php echo number_format($invoice['Invoice']['month_total']); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $addForm->switchAnchor('invoices/add', array(), 'close the sales that I close it, and was over a day. Are you all right?', 'Close Sales', null); ?></li>
	</ul>
</div>
<?php //pr($invoice);?>
<ul>
	<li>売上データの中から、締日が過ぎている売上を、請求先毎にまとめ請求データを作る。</li>
	<li>Idは請求書番号、請求先は請求先システム番号で検索。</li>
</ul>