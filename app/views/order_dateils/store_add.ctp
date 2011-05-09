<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("scriptaculous",false);
	/*
	if(empty($span_no)) $span_no = '';
	if(empty($discount)) $discount = '';
	if(empty($adjustment)) $adjustment = '';
	if(empty($sub_remarks)) $sub_remarks = '';
	*/
	if(empty($edit)){
			$edit = array(
				'Subitem'=>array('id'=>'','name'=>'','quantity'=>'','major_size'=>'','minority_size'=>'','marking'=>'',
					'specified_date'=>array('year'=>'','month'=>'','day'=>''), 'transport_detail_id'=>'',
					'discount'=>'','adjustment'=>'','depot_id'=>'','order_type'=>'','span_no'=>'','sub_remarks'=>'',),
				'Item'=>array('id'=>'','price'=>'',)
			);
		}
?>
<h3><?php __('Sell Input');?></h3>
<div class="form">
	<fieldset>
 	<?php
 	echo $form->create('OrderDateil', array('action'=>'store_add'));
 	echo '<table class="itemVars">';
 	echo '<tr><td>';
	echo '　売上日：';
	echo $form->input('OrderDateil.date', array(
		'type'=>'date',
		'dateFormat'=>'YMD',
		'label'=>false,
		'minYear'=>MINYEAR,
		'maxYear' => MAXYEAR,
		'div'=>false,
		'selected'=>$date
	));
	if(!empty($date)) echo $date['year'].':'.$date['month'].':'.$date['day'];
 	echo '</td><td>';
	echo __('Partners No.', true);
 	echo $form->input("OrderDateil.partners_no", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>6,
 		'value'=>$partners_no
	));
	echo $partners_no;
	echo '</td></tr><tr><td>';
	echo 'イベントNo';
	echo $form->input("OrderDateil.events_no", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>2,
		'value'=>$events_no
	));
	echo $events_no;
	echo '</td><td>';
	echo '担当者1：';
	echo $form->input('OrderDateil.contact1', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact1['User']['id']
	));
	echo $contact1['User']['name'];
	echo '</td></tr><tr><td>';
	echo 'お客様名';
	echo $form->input("OrderDateil.customers_name", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>15,
		'value'=>$customers_name
	));
	echo $customers_name;
	echo '</td><td>';
	echo '担当者2：';
	echo $form->input('OrderDateil.contact2', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact2['User']['id']
	));
	echo $contact2['User']['name'];
	echo '</td></tr><tr><td>';
	echo '　　備考：';
	echo $form->input("OrderDateil.remark", array(
	'type'=>'text',
	'div'=>false,
	'label'=>false,
	'size'=>45,
	'value'=>$remark
	));
	echo mb_substr($remark, 0, 5);
	echo '</td><td>';
	echo '担当者3：';
	echo $form->input('OrderDateil.contact3', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact3['User']['id']
	));
	echo $contact3['User']['name'];
	echo '</td></tr><tr><td>';
	echo '　',__('Prev Money', true).'：';
	echo $form->input("OrderDateil.prev_money", array(
	'type'=>'text',
	'div'=>false,
	'label'=>false,
	'size'=>4,
	'value'=>$prev_money
	));
	echo $prev_money;
	echo '</td><td>';
	echo '担当者4：';
	echo $form->input('OrderDateil.contact4', array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$contact4['User']['id']
	));
	echo $contact4['User']['name'];
 	echo '</td></tr><tr><td>';
 	echo '　　社販：';
 	echo $form->input('OrderDateil.order_status', array(
		'type'=>'select',
		'div'=>false,
		'label'=>false,
 		'options'=>array('0'=>'select', '6'=>'社販'),
 		
	));
	echo '</td><td>';
	
	echo '取置番号：';
	echo $form->input("OrderDateil.reserve", array(
	'type'=>'text',
	'div'=>false,
	'label'=>false,
	'size'=>4,
	));
	
	echo '</td></tr></table>';
 	echo '品番：';
	echo $ajax->autocomplete('AutoItemName',"getData",array());
	echo $form->hidden('step', array('value'=>'1'));
	echo '<input type="submit" value="Enter" />　';
	echo $html->link(__('Reset', true), array('action'=>'store_add/reset'));
	if(!empty($subitems)){
		echo $form->create('OrderDateil', array('action'=>'store_add'));
		echo $form->hidden('Item.name', array('value'=>$item['Item']['name']));
		if(!empty($edit['Subitem']['transport_detail_id'])){
			echo $form->hidden('OrderDateil.transport_detail_id', array('value'=>$edit['Subitem']['transport_detail_id']));
		}
		echo '<table class="itemVars"><tr>';
		echo '<td>'.$item['Item']['name'].' / ￥'.$item['Item']['price'].' / '.$item['Factory']['name'];
		echo ' / 納期';
		echo $form->input('OrderDateil.specified_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'empty'=>'select',
			'minYear'=> MINYEAR,
			'maxYear' => MAXYEAR,
			'div'=>false,
			'selected'=>$edit['Subitem']['specified_date']
		));
		echo ' / 刻印';
		echo $form->input("OrderDateil.marking", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>10,
		'value'=>$edit['Subitem']['marking']
		));
		//　7/15 追加分
		echo '</td></tr><tr><td>倉庫';
		if(empty($edit['Subitem']['depot_id'])){
			$selected_depot = $userSection['Section']['default_depot'];
		}else{
			$selected_depot = $edit['Subitem']['depot_id'];
		}
 		echo $form->input('OrderDateil.depot_id', array(
			'type'=>'select',
			'div'=>false,
			'label'=>false,
 			'options'=>$sectionDepot,
 			'selected'=>$selected_depot
		));
		echo '　区分';
		if($edit['Subitem']['order_type'] == '7'){
			echo '：取置';
			echo $form->hidden('OrderDateil.order_type', array('value'=>$edit['Subitem']['order_type']));
		}else{
			echo $form->input('OrderDateil.order_type', array(
				'type'=>'select',
				'div'=>false,
				'options'=>$orderType,
				'label'=>false,
				'selected'=>$edit['Subitem']['order_type']
			));
		}		
		echo '　スパン';
		echo $form->input("OrderDateil.span_no", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1,
			'maxLength'=>10,
			'value'=>$edit['Subitem']['span_no']
		));
		echo '　割引';
		echo $form->input("OrderDateil.discount", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1,
			'maxLength'=>2,
			'value'=>$edit['Subitem']['discount']
		));
		echo '　調整';
		echo $form->input("OrderDateil.adjustment", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>5,
			'maxLength'=>9,
			'value'=>$edit['Subitem']['adjustment']
		));
		echo '　備考';
		echo $form->input("OrderDateil.sub_remarks", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>10,
			'value'=>$edit['Subitem']['sub_remarks']
		));
		
		echo '<hr></td></tr><tr><td>';
		$tanpin_judge = true;
		if($item['Item']['stock_code'] == '3'){
			//echo '単品管理の商品は、商品詳細から入力して下さい。';
			
			if(empty($edit['Subitem']['id'])){
				$tanpin_judge = false;
				echo '単品管理の商品は、品番「SAMPLE」を入力して、備考に品番、サイズ等を入力して下さい。';
			}else{
				foreach($subitems as $subitem){
					if($subitem['Subitem']['id'] == $edit['Subitem']['id']){
						if(empty($subitem['Subitem']['major_size']) or $subitem['Subitem']['major_size'] == 'other'){
							if(!empty($subitem['Subitem']['minority_size'])){
								$size = $subitem['Subitem']['minority_size'];
							}
						}else{
							$size = $subitem['Subitem']['major_size'];
						}
						if($subitem['Subitem']['id'] == $edit['Subitem']['id']){
							$default_value = $edit['Subitem']['quantity'];
						}else{
							if(count($subitems) == 1){
								$default_value = 1;
							}else{
								$default_value = null;
							}
						}
						if(empty($size)) $size = '#';
						echo '<div class="onesize">'.$size;
						echo $form->input("subitem.".$subitem['Subitem']['id'], array(
							'type'=>'text',
							'div'=>false,
							'label'=>false,
							'size'=>1,
							'value'=>$default_value
						));
						echo '</div>';
					}
				}
			}
			
		}else{
			foreach($subitems as $subitem){
				if(empty($subitem['Subitem']['major_size']) or $subitem['Subitem']['major_size'] == 'other'){
					if(!empty($subitem['Subitem']['minority_size'])){
						$size = $subitem['Subitem']['minority_size'];
					}
				}else{
					$size = $subitem['Subitem']['major_size'];
				}
				if($subitem['Subitem']['id'] == $edit['Subitem']['id']){
					$default_value = $edit['Subitem']['quantity'];
				}else{
					if(count($subitems) == 1){
						$default_value = 1;
					}else{
						$default_value = null;
					}
				}
				if(empty($size)) $size = '#';
				echo '<div class="onesize">'.$size;
				echo $form->input("subitem.".$subitem['Subitem']['id'], array(
					'type'=>'text',
					'div'=>false,
					'label'=>false,
					'size'=>1,
					'value'=>$default_value
				));
				echo '</div>';
			}
		}
		
		echo $form->hidden('Item.price', array('value'=>$item['Item']['price']));
		if($tanpin_judge){ //単品管理を入力されたら、ボタンを表示しない。
			echo $form->hidden('step', array('value'=>'2'));
			echo '<input type="submit" value="Submit" />';
		}
		echo '</td>';
		echo '</tr></table>';
	}
	if(!empty($details)){
		$orderType['4'] = '特別';
		echo '<table class="itemDetail"><tr><th>子品番</th><th>価格</th><th>納期</th><th>刻印</th><th>数量</th><th>倉庫</th><th>区分</th><th>スパン</th><th>割引</th><th>調整</th><th>備考</th><th></th></tr>';
		foreach($details as $key=>$value){
			echo '<tr>';
			echo '<td>'.$value['Subitem']['name'].'</td>';
			echo '<td>'.number_format($value['Item']['price']).'</td>';
			echo '<td>'.$value['Subitem']['specified_date']['year'].'-'.$value['Subitem']['specified_date']['month'].'-'.$value['Subitem']['specified_date']['day'].'</td>';
			echo '<td>'.$value['Subitem']['marking'].'</td>';
			echo '<td>'.$value['Subitem']['quantity'].'</td>';
			echo '<td>'.$value['Subitem']['depot_id'].'</td>';
			if($value['Subitem']['order_type'] == '7'){
				echo '<td>取置</td>';
			}else{
				echo '<td>'.$orderType[$value['Subitem']['order_type']].'</td>';
			}
			
			
			
			
			echo '<td>'.$value['Subitem']['span_no'].'</td>';
			echo '<td>'.$value['Subitem']['discount'].'</td>';
			echo '<td>'.$value['Subitem']['adjustment'].'</td>';
			echo '<td>'.$value['Subitem']['sub_remarks'].'</td>';
			
			echo '<td>';
			if($value['Subitem']['order_type'] <> 4){
				echo $html->link('Edit', array('action'=>'store_add/edit/'.$key)).' | ';
			}
			echo $html->link('Del', array('action'=>'store_add/del/'.$key)).'</td>';
			echo '</tr>';
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>合計</td><td></td><td></td><td></td><td></td><td></td><td></td>';
		echo '<td>'.$html->link(__('AllDelete', true), array('action'=>'store_add/alldel/')).'</td></tr>';
		echo '</table>';
		echo '<p>'.$html->link(__('売上入力', true), array('action'=>'store_add/ordering/')).'</p>';
	}


	?>
	</fieldset>
</div>
<p>
<ul>
<li>単品管理の商品は、商品検索から検索して、特殊注文をクリックして入力する。<a href="http://e5-os214.xbit.jp/buchedenoel/memo_datas/view/1614">詳しくはこちら</a></li>
<li>どうしても品番が無い場合などは、品番「SAMPLE」で入力して、備考に品番を入力する。</li>
<li>スパン：入力できるのは半角英数字のみです。日本語、記号などは入力できません。</li>
<li>割引：割引率を1～99の整数で入力して下さい。（例）10　と入力すると10％引きの金額が表示されます。（注）端数切捨て</li>
<li>調整：入力できるのは半角数字と半角ハイフン「-」のみです。減算する場合は先頭にハイフン「-」をつけて下さい。</li>
<li>(2011.05.09)部門に所属していないと完了で登録される不具合があるらしいです。</li>
</ul>
</p>