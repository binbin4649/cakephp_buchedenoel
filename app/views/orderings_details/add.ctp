<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("scriptaculous",false);
?>
<h2><?php __('Add OrderingsDetail');?></h2>
<div class="orderingsDetails form">
	<fieldset>
 	<?php
 	//$item = $this->viewVars['item'];
 	//$user = $this->viewVars['user'];

 	echo $form->create('OrderingsDetail');
 	echo '品番：';
	echo $ajax->autocomplete('AutoItemName',"getData",array());
	echo $form->hidden('step', array('value'=>'1'));
	echo '<input type="submit" value="Enter" />　';
	echo $html->link(__('Reset', true), array('action'=>'add'));
	if(!empty($subitems)){
		$time = time()+(86400 * $item['Factory']['delivery_days']);
		$date_y = date('Y' ,$time);
		$date_m = date('m' ,$time);
		$date_d = date('d' ,$time);

		echo $form->create('OrderingsDetail');
		echo '<table class="itemVars"><tr>';
		echo '<td>'.$item['Item']['name'].' / ￥'.$item['Item']['price'].'('.$item['Item']['cost'].') / '.$item['Factory']['name'];
		if(empty($item['Factory']['name'])){
			echo '<a href="/buchedenoel/factories" target="_blank">工場</a>';
			echo $form->input('OrderingsDetail.factory_id', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
				'size'=>3
			));
		}
		
		echo '<br>倉庫';
		echo $form->input('OrderingsDetail.depot', array(
			'type'=>'select',
				'options'=>$depots,
				'div'=>false,
				'value'=>$user['Section']['default_depot'],
				'label'=>false
		));
		echo ' / 納期';
		echo $form->input('OrderingsDetail.specified_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'selected'=>array('year'=>$date_y, 'month'=>$date_m, 'day'=>$date_d),
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'div'=>false
		));
		echo ' / 発注単価';
		echo $form->input("OrderingsDetail.changecost", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>3
		));
		echo ' / 受注番号';
		echo $form->input("OrderingsDetail.order_id", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>3
		));
		echo '</td></tr><tr><td>';
		if($item['Item']['stock_code'] == 3){ //単品管理の場合は、サイズ選択なし
			foreach($subitems as $subitem){
				break;
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
		}
		echo $form->hidden('Item.stock_code', array('value'=>$item['Item']['stock_code']));
		echo $form->hidden('Section.name', array('value'=>$user['Section']['name']));
		echo $form->hidden('Subitem.labor_cost', array('value'=>$subitem['Subitem']['labor_cost']));
		echo $form->hidden('Item.price', array('value'=>$item['Item']['price']));			echo $form->hidden('Factory.id', array('value'=>$item['Factory']['id']));
		echo $form->hidden('Factory.name', array('value'=>$item['Factory']['name']));
		echo $form->hidden('step', array('value'=>'2'));
		echo '<input type="submit" value="Submit" />';
		echo '</td>';
		echo '</tr></table>';
		}
	$item_stock_code = false;
	if(!empty($details)){
		echo '<table class="itemDetail"><tr><th>小品番</th><th>工場</th><th>納期</th><th>倉庫:No</th><th>受注番号</th><th>数量</th><th>小計(上代:下代)</th><th></th></tr>';
		foreach($details as $key=>$value){
			if(empty($value['order_id'])) $value['order_id'] = '' ;
			echo '<tr>';
			echo '<td>'.$key.'</td>';
			echo '<td>'.$value['Factory']['name'].'</td>';
			echo '<td>'.$value['specified_date']['year'].'/'.$value['specified_date']['month'].'/'.$value['specified_date']['day'].'</td>';
			echo '<td>'.$value['Depot']['name'].':'.$value['Depot']['id'].'</td>';
			//上代:下代
			//echo '<td>'.number_format($value['Item']['price']).':'.number_format($value['Subitem']['cost']).'</td>';
			echo '<td>'.$value['order_id'].'</td>';
			echo '<td>'.$value['Subitem']['quantity'].'</td>';
			echo '<td>'.number_format($value['Item']['sub_total_jo']).':'.number_format($value['Item']['sub_total_ge']).'</td>';
			echo '<td>'.$html->link(__('Del', true), array('action'=>'add/del/'.$value['Subitem']['id'])).'</td>';
			echo '</tr>';
			if($value['Item']['stock_code'] == '3'){
				$item_stock_code = true;
			}
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>合計</td><td>'.$detailTotal['quantity'].'</td><td>'.number_format($detailTotal['jo']).':'.number_format($detailTotal['ge']).'</td>';
		echo '<td>'.$html->link(__('AllDelete', true), array('action'=>'add/alldel/')).'</td></tr>';
		echo '</table>';
		if($item_stock_code){ //単品管理の場合は、専用の発注リンクを表示
			echo '<p>'.$html->link(__('Be Ordering', true), array('action'=>'add/spesial/'), null, sprintf(__('The Spesial Ordering. Are you sure?', true), $detailTotal['quantity'])).'</p>';
		}else{
			echo '<p>'.$html->link(__('Basic Ordering', true), array('action'=>'add/basic/'), null, sprintf(__('The Basic Ordering. Are you sure?', true), $detailTotal['quantity'])).'　/　';
			echo $html->link(__('Custom Ordering', true), array('action'=>'add/custom/'), null, sprintf(__('The Custom Ordering. Are you sure?', true), $detailTotal['quantity'])).'</p>';
		}
//pr($details);
	}

	?>
	</fieldset>
</div>