<?php
if(!empty($print)){
	echo '<br>カタログ出力(6x6)：<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>';
}
if(!empty($print2)){
	echo '<br>カタログ出力(2x8)：<a href="'.$print2['url'].'" target="_blank">'.$print2['file'].'</a>';
}
if(!empty($csv)){
	echo '<br>商品CSV：<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。';
}
?>
<div class="items index">
<h2><?php __('List Items');?></h2>
<?php
echo $form->create('Item' ,array('action'=>'index'));
echo __('Item Name', true);
echo $form->text('Item.word');
echo $form->submit('Seach', array('div'=>false));
//echo $form->end();
?>
<div id='datail'>
<a href="javascript:;" onmousedown="if(document.getElementById('in_dateil').style.display == 'none'){ document.getElementById('in_dateil').style.display = 'block'; }else{ document.getElementById('in_dateil').style.display = 'none'; }">
details</a>
<div id="in_dateil" style="display:none">
<div class="form">
<?php
//var_dump($this->data['Tag']['Tag']);
//echo $form->create('Item' ,array('action'=>'index'));
echo $form->input('Item.jan', array(
	'type'=>'text',
	'label'=>__('Jan', true),
));
echo $form->input('Item.message_stamp', array(
	'type'=>'text',
	'label'=>__('Message Stamp', true),
));
echo $form->input('Item.brand_id', array(
	'type'=>'select',
	'options'=>$brands,
	'label'=>__('Brand', true),
	'empty'=>'(select)'
));
echo $form->input('Item.itemproperty', array(
	'type'=>'select',
	'options'=>$itemproperty,
	'div'=>true,
	'label'=>__('Item Property', true),
	'empty'=>'(select)'
));
echo $form->input('Item.itemtype', array(
	'type'=>'select',
	'options'=>$itemtype,
	'div'=>true,
	'label'=>__('Item Type', true),
	'empty'=>'(select)'
));
echo $form->input('Item.factory_id', array(
	'type'=>'select',
	'options'=>$factories,
	'label'=>__('Factory', true),
	'empty'=>'(select)'
));
echo $form->input('Item.sales_state_code_id', array(
	'label'=>__('Sales State', true),
	'empty'=>'(select)'
));
echo $form->input('Item.process_id', array(
	'label'=>__('Process', true),
	'empty'=>'(select)'
));
echo $form->input('Item.material_id', array(
	'label'=>__('Material', true),
	'empty'=>'(select)'
));
echo $form->input('Item.stone_id', array(
	'label'=>__('Stone', true),
	'empty'=>'(select)'
));
echo $form->input('Item.stock_code', array(
	'type'=>'select',
	'options'=>$stockCode,
	'div'=>true,
	'label'=>__('Stock Code', true),
	'empty'=>'(select)'
));
echo $form->input('Item.cutom_order_approve', array(
	'type'=>'select',
	'options'=>$cutomOrderApprove,
	'div'=>true,
	'label'=>__('Custom Order App', true),
	'empty'=>'(select)'
));
echo $form->input('Item.trans_approve', array(
	'type'=>'select',
	'options'=>$transApprove,
	'div'=>true,
	'label'=>__('Trans Approve', true),
	'empty'=>'(select)'
));
echo $form->input('Item.sales_sum_code', array(
	'type'=>'select',
	'options'=>$salesSumCode,
	'div'=>true,
	'label'=>__('Sales Sum Code', true),
	'empty'=>'(select)'
));
echo $form->input('Item.release_day_start', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>__('Release', true),
	'minYear'=>'2000',
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo $form->input('Item.release_day_end', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>'～',
	'minYear'=>'2000',
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo $form->input('Item.order_end_day_start', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>__('Order End', true),
	'minYear'=>'2000',
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));
echo $form->input('Item.order_end_day_end', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>'～',
	'minYear'=>'2000',
	'maxYear' => MAXYEAR,
	'empty'=>'(select)'
));

if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo $form->input('Item.order_approve', array(
		'type'=>'select',
		'options'=>$orderApprove,
		'div'=>true,
		'label'=>__('Order Approve', true),
		'empty'=>'(select)'
	));
	echo $form->input('Item.atelier_trans_approve', array(
		'type'=>'select',
		'options'=>$atelierTransApprove,
		'div'=>true,
		'label'=>__('Atelier Trans App', true),
		'empty'=>'(select)'
	));
	echo $form->input('Item.percent_code', array(
		'type'=>'select',
		'options'=>$percentCode,
		'div'=>true,
		'label'=>__('Percent Code', true),
		'empty'=>'(select)'
	));
}

$checked = array();
if(!empty($this->data['Tag']['Tag'])){
	foreach($this->data['Tag']['Tag'] as $tag_id){
		$checked[] = array('id'=>$tag_id);
	}
}
echo $addForm->tagTagTable($this->viewVars['tags'], $checked);
echo $form->hidden('Item.dateil', array('value'=>'1'));
echo $form->submit('Submit', array('div'=>false));
echo '<table class="tagtag"><tr><th colspan="2">Out Put</th></tr><tr><td>';
echo $form->input('Item.print1',array(
	'type'=>'checkbox',
	'label'=>'Item Catalog 6x6',
));
echo '</td><td>';
echo $form->input('Item.print2',array(
	'type'=>'checkbox',
	'label'=>'Item Catalog 2x8',
));
echo '</td></tr><tr><td>';
echo $form->input('Item.csv',array(
	'type'=>'checkbox',
	'label'=>'Item CSV',
));
echo '</td><td></td></tr></table>';
echo $form->end();
?>
</div>
</div>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th></th>
	<th><?php echo $paginator->sort(__('Item Name', true), 'name');?></th>
	<th><?php echo $paginator->sort(__('Brand', true), 'brand_id');?></th>
	<th><?php echo $paginator->sort(__('Factory', true), 'factory_id');?></th>
	<th><?php echo $paginator->sort(__('Price', true), 'price');?></th>
	<th><?php echo $paginator->sort(__('Sales State', true), 'sales_state_code_id');?></th>
	<th><?php echo $paginator->sort(__('Updated', true), 'updated');?></th>
	<th>在庫</th>
</tr>
<?php
$i = 0;
foreach ($items as $item):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr id="item-index">
		<td>
			<?php echo $html->link($html->image('/img/itemimage/'.$item['Item']['itemimage_id'].'.jpg', array('width'=>75, 'height'=>75, 'border'=>'0')), array('action'=>'view', $item['Item']['id']), array('escape'=>false)); ?>
		</td>
		<td>
			<?php echo $html->link($item['Item']['name'], array('action'=>'view', $item['Item']['id']), array('target'=>'_blank')); ?>
			<br>
			<?php echo mb_substr($item['Item']['title'], 0, 10); ?>
		</td>
		<td>
			<?php echo $item['Brand']['name']; ?>
		</td>
		<td>
			<?php echo $item['Factory']['name']; ?>
		</td>
		<td>
			<?php echo number_format($item['Item']['price']); ?>
		</td>
		<td>
			<?php echo $item['SalesStateCode']['name']; ?>
		</td>
		<td>
			<?php echo substr($item['Item']['updated'], 0, 10); ?>
		</td>
		<td>
			<?php echo $html->link('在庫', array('controller'=>'stocks', 'action'=>'item_index', $item['Item']['id']), array()); ?>
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
<ul>
	<li>画像をクリックすると同じウンドウ内に表示され、品番をクリックすると別ウインドウに表示されます。</li>
	<li>印刷制限：1回の出力で約10ページ、360商品が限度です。</li>
	<li>デフォルトの並び順は、更新順です。</li>
	<li>品番検索は、カンマ区切りで複数キーワードをOR検索できます。カンマは半角で入力してください。</li>
</ul>