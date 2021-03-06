<script type="text/javascript" charset="utf-8">
//datepicker  ワンライナー
$(function($){$(".datepicker").datepicker({dateFormat:'yy-mm-dd'});});
//ラインハイライト 3ライナー
$(function(){var overcells = $("table td"),hoverClass = "hover",current_r;
overcells.hover(function(){var $this = $(this);(current_r = $this.parent().children("table td")).addClass(hoverClass);},
function(){ current_r.removeClass(hoverClass);});});
</script>
<?php 
	echo $javascript->link("jquery-1.5.1.min",false);
	echo $javascript->link("jquery-ui-1.8.14.custom.min",false);
	echo $javascript->link("ui/i18n/ui.datepicker-ja.js",false);
?>
<div class="orderDateils index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('OrderDateils');?></h2>
<?php
$modelName = 'OrderDateil';
echo $form->create($modelName ,array('action'=>'index'));
echo '売上id';
echo $form->text($modelName.'.order_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false,
));
echo '　';
echo '取置id';
echo $form->text($modelName.'.transport_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '部門id';
echo $form->text($modelName.'.section_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '品番';
echo $form->text($modelName.'.item_name', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '現売';
echo $form->checkbox($modelName.'.ordertype.6');
echo '　';
echo '特注';
echo $form->checkbox($modelName.'.ordertype.4', array('checked'=>1));
echo '　';
echo '手配';
echo $form->checkbox($modelName.'.ordertype.5');
echo '　';
echo '客注';
echo $form->checkbox($modelName.'.ordertype.2', array('checked'=>1));
echo '　';
echo '取置';
echo $form->checkbox($modelName.'.ordertype.7', array('checked'=>1));
echo '　';
echo $form->submit('Submit', array('div'=>false));
?>
<br/><br/>
<span style="margin-left:20px;">
<a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a></span>　<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
<br/>
<div id="in_exp" style="display:none">
<br/>
<?php
echo '取消非表示';
echo $form->checkbox($modelName.'.cancel_not');
echo '　';
echo 'SAMPLE非表示';
echo $form->checkbox($modelName.'.sample_not');
echo '　';
echo 'SAMPLEのみ';
echo $form->checkbox($modelName.'.sample_only');
echo '<br/><br/>';
echo '入力　';
echo $form->text($modelName.'.start_created', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '　～　';
echo $form->text($modelName.'.end_created', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '<br/><br/>';
echo '納期　';
echo $form->text($modelName.'.start_arrival', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '　～　';
echo $form->text($modelName.'.end_arrival', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '<br/><br/>';
echo '入荷　';
echo $form->text($modelName.'.start_stock', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '　～　';
echo $form->text($modelName.'.end_stock', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));

if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo '入荷一括更新';
	echo $form->text($modelName.'.new_stock_date', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'class'=>'datepicker'
	));
}
echo '　';
echo '入荷未定';
echo $form->checkbox($modelName.'.null_stock');
echo '<br/><br/>';
echo '出荷　';
echo $form->text($modelName.'.start_shipping', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '　～　';
echo $form->text($modelName.'.end_shipping', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));

if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo '出荷一括更新';
	echo $form->text($modelName.'.new_shipping_date', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'class'=>'datepicker'
	));
}
echo '　';
echo '未出荷　';
echo $form->checkbox($modelName.'.null_shipping');
echo '　';
echo 'CSV';
echo $form->checkbox($modelName.'.csv');
?>
</div>
<br/>
<table cellpadding="0" cellspacing="0">
<tr>
	<th></th>
	<th>売上</th>
	<th>取置</th>
	<th>部門</th>
	<th>品番</th>
	<th>入力</th>
	<th>納期</th>
	<th>入荷</th>
	<th>出荷</th>
	<th>数</th>
	<th>
	<?php if($addForm->opneUser(open_users(), $opneuser, 'access_authority')): ?>
	<input type="checkbox" id="checkbox_all" onclick="$('input[type=checkbox][class=something]').attr('checked', $('#checkbox_all').attr('checked'));" />
	<?php endif; ?>
	</th>
</tr>
<?php
	$qty_total = 0;
	foreach($orderDateils as $orderDateil):
?>
	<tr>
		<td>
			<?php
				$status_name = $orderStatus[$orderDateil['Order']['order_status']];
				echo mb_substr($status_name, 0, 2); 
			?>
		</td>
		<td>
			<?php
				if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
					echo $html->link($orderDateil['Order']['id'], array('controller'=>'orders', 'action'=>'view', $orderDateil['Order']['id']));
				}else{
					echo $html->link($orderDateil['Order']['id'], array('controller'=>'orders', 'action'=>'store_view', $orderDateil['Order']['id']));
				}
			?>
		</td>
		<td>
			<?php echo $html->link($orderDateil['TransportDateil']['transport_id'], array('controller'=>'transports', 'action'=>'view', $orderDateil['TransportDateil']['transport_id'])); ?>
		</td>
		<td>
			<?php echo $orderDateil['Order']['section_name'].':'.$orderDateil['Order']['section_id']; ?>
		</td>
		<td>
			<?php echo $orderDateil['Item']['name'].':'.$orderDateil['OrderDateil']['size']; ?>
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['created'], 5, 5); ?><!-- 入力 -->
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['specified_date'], 5, 5); ?><!-- 納期 -->
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['stock_date'], 5, 5); ?><!-- 入荷 -->
		</td>
		<td>
			<?php echo substr($orderDateil['OrderDateil']['shipping_date'], 5, 5); ?><!-- 出荷 -->
		</td>
		<td>
			<?php echo $orderDateil['OrderDateil']['bid_quantity']; ?>
		</td>
		<td>
			<?php 
				if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
					echo $form->checkbox('OrderDateil.updating.'.$orderDateil['OrderDateil']['id'], array('class'=>'something'));
					//echo $form->checkbox('OrderDateil.update.'.$orderDateil['OrderDateil']['id'], array('checked'=>$checkk)); 
				}
			?>
		</td>
	</tr>
<?php
	$qty_total = $qty_total + $orderDateil['OrderDateil']['bid_quantity'];
	endforeach;
?>
<tr><td colspan="8"></td><td>合計</td><td><?php echo $qty_total; ?></td><td></td></tr>
<?php echo $form->end(); ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<ul>
	<li>入力：店舗が入力をした日。</li>
	<li>納期：店舗が入力した、店着希望日。</li>
	<li>入荷：商品部から出荷する、出荷予定日。商品が入荷する日、と覚えて下さい。</li>
	<li>出荷日：商品部が実際に出荷した日。入力されている　＝　出荷した。</li>
	<li>売上は売上番号、取置は取置番号です。</li>
	<li>現売、特注などのチェックボックスはOR検索になります。</li>
	<li>出荷日一括更新は、8桁の半角数字で入力して下さい。</li>
	<li>出荷日一括更新は、チェックを外すと更新されません。検索結果の中からチェックボックスにチェックが入っているものが更新対象になります。</li>
</ul>