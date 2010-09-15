<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("scriptaculous",false);
?>
<h3><?php __('Add OrderDetail');?></h3>
<div class="form">
	<fieldset>
 	<?php
 	echo $form->create('OrderDateil', array('action'=>'add'));
 	echo '<table class="itemVars"><tr><td>';
 	echo '　　区分：';
	echo $form->input('OrderDateil.order_type', array(
		'type'=>'select',
		'div'=>false,
		'options'=>$orderType,
		'label'=>false,
		'selected'=>$order_type
	));
 	echo '</td><td>';
	echo '客先注文番号：';
 	echo $form->input("OrderDateil.partners_no", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>12,
 		'value'=>$partners_no
	));
	echo $partners_no;
	echo '</td></tr><tr><td>';
	echo '　　倉庫：';
 	echo $form->input('OrderDateil.depot_id', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
 		'size'=>2,
 		'value'=>$depot['Depot']['id']
	));
	echo $depot['Section']['name'].':'.$depot['Depot']['name'];
	echo '</td><td>';
	echo '　 イベントNo.：';
	echo $form->input("OrderDateil.events_no", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>2,
		'value'=>$events_no
	));
	echo $events_no;
	echo '</td></tr><tr><td>';
	echo '　受注日：';
	echo $form->input('OrderDateil.date', array(
		'type'=>'date',
		'dateFormat'=>'YMD',
		'label'=>false,
		'minYear'=>'2009',
		'maxYear' => MAXYEAR,
		'div'=>false,
		'selected'=>$date
	));
	if(!empty($date)) echo $date['year'].':'.$date['month'].':'.$date['day'];
	echo '</td><td>';
	echo '　　スパンNo.：';
	echo $form->input("OrderDateil.span_no", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>2,
		'value'=>$span_no
	));
	echo $span_no;
	echo '</td></tr><tr><td>';
	echo '　<a href="/buchedenoel/destinations" target="_blank">出荷先</a>：';
	echo $form->input("OrderDateil.destination_id", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>3,
		'value'=>$destination['Destination']['id']
	));
	echo $destination['Destination']['name'];
	echo '</td><td>';
	echo ' 　　　　　送料：';
	echo $form->input("OrderDateil.shipping", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>2,
		'value'=>$shipping
	));
	echo $shipping;
	echo '</td></tr><tr><td>';
	echo 'お客様名：';
	echo $form->input("OrderDateil.customers_name", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>15,
		'value'=>$customers_name
	));
	echo $customers_name;
	echo '</td><td>';
	echo ' 　　　　　調整：';
	echo $form->input("OrderDateil.adjustment", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>2,
		'value'=>$adjustment
	));
	echo $adjustment;
 	echo '</td></tr></table>';
 	?>
<div id='datail'>
<a href="javascript:;" onmousedown="if(document.getElementById('in_dateil').style.display == 'none'){ document.getElementById('in_dateil').style.display = 'block'; }else{ document.getElementById('in_dateil').style.display = 'none'; }">
details</a>
<?php
echo '　　備考：';
echo $form->input("OrderDateil.remark", array(
	'type'=>'text',
	'div'=>false,
	'label'=>false,
	'size'=>50,
	'value'=>$remark
));
echo $remark;
?>
<div id="in_dateil" style="display:none">
<?php
echo '<table class="itemVars"><tr><td>';
 	echo '担当者1：';
	echo $form->input('OrderDateil.contact1', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact1['User']['id']
	));
	echo $contact1['User']['name'];
 	echo '</td><td>';
	echo '取置1：';
 	echo $form->input("OrderDateil.pairing1", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
 		'value'=>$pairing1
	));
	echo '</td></tr><tr><td>';
	echo '担当者2：';
	echo $form->input('OrderDateil.contact2', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact2['User']['id']
	));
	echo $contact2['User']['name'];
	echo '</td><td>';
	echo '取置2：';
 	echo $form->input("OrderDateil.pairing2", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
 		'value'=>$pairing2
	));
	echo '</td></tr><tr><td>';
	echo '担当者3：';
	echo $form->input('OrderDateil.contact3', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact3['User']['id']
	));
	echo $contact3['User']['name'];
	echo '</td><td>';
	echo '取置3：';
 	echo $form->input("OrderDateil.pairing3", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
 		'value'=>$pairing3
	));
	echo '</td></tr><tr><td>';
	echo '担当者4：';
	echo $form->input('OrderDateil.contact4', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact4['User']['id']
	));
	echo $contact4['User']['name'];
	echo '</td><td>';
	echo '取置4：';
 	echo $form->input("OrderDateil.pairing4", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
 		'value'=>$pairing4
	));
 	echo '</td></tr></table>';
?>
</div>
</div>
 	<?php
 	echo '品番：';
	echo $ajax->autocomplete('AutoItemName',"getData",array());
	echo $form->hidden('step', array('value'=>'1'));
	echo '<input type="submit" value="Enter" />　';
	echo $html->link(__('Reset', true), array('action'=>'add'));
	if(!empty($subitems)){
		echo $form->create('OrderDateil', array('action'=>'add'));
		echo $form->hidden('Item.name', array('value'=>$item['Item']['name']));
		echo '<table class="itemVars"><tr>';
		echo '<td>'.$item['Item']['name'].' / ￥'.$item['Item']['price'].' / '.$item['Factory']['name'];
		echo ' / 納期';
		echo $form->input('OrderDateil.specified_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'empty'=>'select',
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'div'=>false
		));
		echo ' / 刻印';
		echo $form->input("OrderDateil.marking", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>10
		));
		echo '</td></tr><tr><td>';
		foreach($subitems as $subitem){
			if(empty($subitem['Subitem']['major_size']) or $subitem['Subitem']['major_size'] == 'other'){
				if(!empty($subitem['Subitem']['minority_size'])){
					$size = $subitem['Subitem']['minority_size'];
				}
			}else{
				$size = $subitem['Subitem']['major_size'];
			}
			if(empty($size)) $size = '#';
			echo '<div class="onesize">'.$size;
			echo $form->input("subitem.".$subitem['Subitem']['id'], array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
				'size'=>1
			));
			echo '</div>';
		}
		//echo $form->hidden('Section.name', array('value'=>$user['Section']['name']));
		//echo $form->hidden('Section.id', array('value'=>$user['Section']['id']));
		echo $form->hidden('Item.price', array('value'=>$item['Item']['price']));
		echo $form->hidden('step', array('value'=>'2'));
		echo '<input type="submit" value="Submit" />';
		echo '</td>';
		echo '</tr></table>';
	}
	if(!empty($details)){
		echo '<table class="itemDetail"><tr><th>子品番</th><th>価格</th><th>納期</th><th>刻印</th><th>数量</th><th></th></tr>';
		foreach($details as $key=>$value){
			echo '<tr>';
			echo '<td>'.$value['Subitem']['name'].'</td>';
			echo '<td>'.number_format($value['Item']['price']).'</td>';
			echo '<td>'.$value['Subitem']['specified_date']['year'].'-'.$value['Subitem']['specified_date']['month'].'-'.$value['Subitem']['specified_date']['day'].'</td>';
			echo '<td>'.$value['Subitem']['marking'].'</td>';
			echo '<td>'.$value['Subitem']['quantity'].'</td>';
			echo '<td>'.$html->link(__('Del', true), array('action'=>'add/del/'.$key)).'</td>';
			echo '</tr>';
		}
		echo '<tr><td></td><td></td><td></td><td>合計</td><td></td>';
		echo '<td>'.$html->link(__('AllDelete', true), array('action'=>'add/alldel/')).'</td></tr>';
		echo '</table>';
		echo '<p>'.$html->link(__('Order Input', true), array('action'=>'add/ordering/')).'</p>';
	}


	?>
	</fieldset>
</div>

<ul>
	<li>受注倉庫が決まっていない場合は、空欄にして下さい。</li>
</ul>