<div class="orders index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('Sales List');?></h2>
<?php
$modelName = 'Order';
echo $form->create($modelName ,array('action'=>'store_index'));
echo '部門id';
echo $form->text($modelName.'.section', array(
	'type'=>'text',
	'size'=>1,
	'div'=>false
));
echo '　';
echo __('Customers Name');
echo $form->text($modelName.'.customers_name', array(
	'type'=>'text',
	'size'=>5,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.order_status', array(
	'type'=>'select',
	'options'=>$orderStatus,
	'label'=>'Status',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo __('Partners No.');
echo $form->text($modelName.'.partners_no', array(
	'type'=>'text',
	'size'=>6,
	'div'=>false
));
echo '<br><br>';
echo __('Item Name');
echo $form->text($modelName.'.item_word', array(
	'type'=>'text',
	'size'=>6,
	'div'=>false
));
echo '　';
echo __('Sale Date', true);
echo $form->input('Order.start_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input('Order.end_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<p>
<a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo '売上id';
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>1,
	'div'=>false
));
echo '　';
echo __('Events No.');
echo $form->text($modelName.'.events_no', array(
	'type'=>'text',
	'size'=>3,
	'div'=>false
));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV出力';
	echo $form->checkbox($modelName.'.csv');
}
?>
</div>
<?php
echo $form->end();
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo 'id';?></th>
	<th><?php echo __('Status', true);?></th>
	<th><?php echo __('Section');?></th>
	<th><?php echo __('Contact');?></th>
	<th><?php echo __('Sale Date', true);?></th>
	<th><?php echo __('Partners No.', true);?></th>
	<th><?php echo __('Total');?></th>
	
	
</tr>
<?php
$i = 0;
foreach ($orders as $order):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($order['Order']['id'], array('action'=>'store_view', $order['Order']['id'])); ?>
		</td>
		<td>
			<?php echo $orderStatus[$order['Order']['order_status']]; ?>
		</td>
		<td>
			<?php echo mb_substr($order['Depot']['section_name'], 0, 8); ?>
		</td>
		<td>
			<?php echo $order['Order']['contact1_name']; ?>
		</td>
		<td>
			<?php echo $order['Order']['date']; ?>
		</td>
		<td>
			<?php echo $order['Order']['partners_no']; ?>
		</td>
		<td>
			<?php echo number_format($order['Order']['total']); ?>
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
<hr>
<ul>
	<li>Idは受注番号、倉庫は倉庫番号、出荷先は出荷先番号での検索になります。</li>
</ul>