<?php
class PrintComponent extends Object {

	var $components = array("Total", 'Selector');

    function ordering($ordering, $details, $file_name){

    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Factory');
    	$FactoryModel = new Factory();
    	App::import('Model', 'Item');
    	$ItemModel = new Item();

    	$params = array(
			'conditions'=>array('Factory.id'=>$ordering['Ordering']['factory_id']),
			'recursive'=>0,
		);
		$factory = $FactoryModel->find('first' ,$params);

    	$values = array();
    	$i = 0;
    	$all_qty = 0;
    	foreach($details as $detail){
    		//if($detail['OrderingsDetail']['ordering_quantity'] >= 1){//ここのループに入らないとsub_total配列が作られない。でもちろんマイナスだと入らない。どうする？
    		if(!empty($detail['OrderingsDetail']['ordering_quantity'])){
    			//返品伝票って何に使うのか？　返品は締めたら合算するのか？　などなど、聞いてみるか、
    			$judgement = true;
    			if(empty($detail['OrderingsDetail']['major_size']) or $detail['OrderingsDetail']['major_size'] == 'other'){
					$values[$i]['item_id'] = $detail['OrderingsDetail']['item_id'];
    				$values[$i]['other'] = $detail['OrderingsDetail']['minority_size'];
    				$values[$i]['other_qty'] = $detail['OrderingsDetail']['ordering_quantity'];
    				$values[$i]['total_qty'] = $detail['OrderingsDetail']['ordering_quantity'];
    				$values[$i]['total'] = $detail['OrderingsDetail']['ordering_quantity'] * $detail['OrderingsDetail']['bid'];
    				$values[$i]['bid'] = $detail['OrderingsDetail']['bid'];
    				$values[$i]['date'] = $detail['OrderingsDetail']['specified_date'];
    			}else{
    				foreach($values as $key=>$value){
    					if($value['item_id'] == $detail['OrderingsDetail']['item_id'] and $value['date'] == $detail['OrderingsDetail']['specified_date'] and $value['bid'] == $detail['OrderingsDetail']['bid'] and $judgement == true){
    						$size = $detail['OrderingsDetail']['major_size'];
    						if(empty($value['#1']))$value['#1'] = 0;
    						if(empty($value['#3']))$value['#3'] = 0;
    						if(empty($value['#5']))$value['#5'] = 0;
    						if(empty($value['#7']))$value['#7'] = 0;
    						if(empty($value['#9']))$value['#9'] = 0;
    						if(empty($value['#11']))$value['#11'] = 0;
    						if(empty($value['#13']))$value['#13'] = 0;
    						if(empty($value['#15']))$value['#15'] = 0;
    						if(empty($value['#17']))$value['#17'] = 0;
    						if(empty($value['#19']))$value['#19'] = 0;
    						if(empty($value['#21']))$value['#21'] = 0;
    						if(empty($value['40cm']))$value['40cm'] = 0;
    						if(empty($value['50cm']))$value['50cm'] = 0;
    						if($size == '#1')$value['#1'] = $value['#1'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#3')$value['#3'] = $value['#3'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#5')$value['#5'] = $value['#5'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#7')$value['#7'] = $value['#7'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#9')$value['#9'] = $value['#9'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#11')$value['#11'] = $value['#11'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#13')$value['#13'] = $value['#13'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#15')$value['#15'] = $value['#15'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#17')$value['#17'] = $value['#17'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#19')$value['#19'] = $value['#19'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '#21')$value['#21'] = $value['#21'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '40cm')$value['40cm'] = $value['40cm'] + $detail['OrderingsDetail']['ordering_quantity'];
    						if($size == '50cm')$value['50cm'] = $value['50cm'] + $detail['OrderingsDetail']['ordering_quantity'];
    						$value['total_qty'] = $value['total_qty'] + $detail['OrderingsDetail']['ordering_quantity'];
    						$value['total'] = $value['total'] + ($detail['OrderingsDetail']['ordering_quantity'] * $detail['OrderingsDetail']['bid']);
    						$values[$key] = $value;
    						$judgement = false;
    					}
    				}
    				if($judgement == true){
    					$values[$i]['item_id'] = $detail['OrderingsDetail']['item_id'];
    					$size = $detail['OrderingsDetail']['major_size'];
    					$values[$i][$size] = $detail['OrderingsDetail']['ordering_quantity'];
    					$values[$i]['total_qty'] = $detail['OrderingsDetail']['ordering_quantity'];
    					$values[$i]['total'] = $detail['OrderingsDetail']['ordering_quantity'] * $detail['OrderingsDetail']['bid'];
    					$values[$i]['bid'] = $detail['OrderingsDetail']['bid'];
    					$values[$i]['date'] = $detail['OrderingsDetail']['specified_date'];
    				}
    			}
    			$all_qty = $all_qty + $detail['OrderingsDetail']['ordering_quantity'];
    			$sub_total[$i]['money'] = $detail['OrderingsDetail']['bid'];
    			$sub_total[$i]['quantity'] = $detail['OrderingsDetail']['ordering_quantity'];
    			$i++;
    		}
    	}
    	$tax = $this->Total->slipTotal($sub_total, $factory['Factory']['tax_method'], $factory['Factory']['tax_fraction']);
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$total_page = count($values);
    	$total_page = ceil($total_page / 31);
    	$page_counter = 1;
    	$page = 1;
    	$orderings_type = get_orderings_type();

    	$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Catalog" xmlns:xlink="http://www.w3.org/1999/xlink">';

    	foreach($values as $value){
    		if($page_counter == 1){
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			$xml .= '<text x="100" y="200" font-size="28" fill="black" font-family="ＭＳ ゴシック">'.$factory['Factory']['name'].'　御中';
				$xml .= '<tspan x="100" dy="40">'.$factory['Factory']['charge_section'].'　'.$factory['Factory']['charge_person'].'　様</tspan>';
				$xml .= '<tspan x="100" dy="75">TEL : '.$factory['Factory']['tel'].'</tspan>';
				$xml .= '<tspan x="100" dy="33">FAX : '.$factory['Factory']['fax'].'</tspan>';
				$xml .= '<tspan x="110" dy="56">いつもお世話になっております。</tspan>';
				if($ordering['Ordering']['orderings_type'] == 90){
					$xml .= '<tspan x="110" dy="37">下記のとおりお送りしますのでご確認ください。</tspan>';
					$xml .= '<tspan x="110" dy="37">よろしくお願いいたします。</tspan>';
					$xml .= '<tspan x="110" dy="37"></tspan>';
				}else{
					$xml .= '<tspan x="110" dy="37">下記のとおり発注いたしますのでご確認ください。</tspan>';
					$xml .= '<tspan x="110" dy="37">よろしくお願いいたします。</tspan>';
					$xml .= '<tspan x="110" dy="37">尚、商品は右記住所まで発送お願いいたします。</tspan>';
				}
				$xml .= '</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="100,263 700,263"/></g>';
				if($ordering['Ordering']['orderings_type'] == 90){
					$xml .= '<text x="912" y="200" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7">仕入返品</text>';
				}else{
					$xml .= '<text x="941" y="200" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7">注文書</text>';
				}
				
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="915,220 1185,220"/><polyline points="915,228 1185,228"/></g>';
				$xml .= '<text x="1650" y="160" font-size="26" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">発注No.:　'.$ordering['Ordering']['id'].'　'.$orderings_type[$ordering['Ordering']['orderings_type']];
				$xml .= '<tspan x="1650" dy="30">日　付 :　'.$ordering['Ordering']['date'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="1450" y="280" font-size="26" fill="black" font-family="ＭＳ ゴシック">'.INC_NAME_JA;
				$xml .= '<tspan x="1450" dy="39">〒'.INC_POSTCODE.'　'.INC_ADDRESS1.'</tspan>';
				$xml .= '<tspan x="1450" dy="39">'.INC_ADDRESS2.'</tspan>';
				$xml .= '<tspan x="1450" dy="39">TEL:'.INC_TEL.'　FAX:'.INC_FAX.'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="1550" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1450,560 1850,560"/></g>';
				$xml .= '<text x="106" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">No';
				$xml .= '<tspan dx="113" y="'.$text_y.'">品番</tspan>';
				$xml .= '<tspan dx="120" y="'.$text_y.'">#1</tspan>';
				$xml .= '<tspan dx="39" y="'.$text_y.'">#3</tspan>';
				$xml .= '<tspan dx="40" y="'.$text_y.'">#5</tspan>';
				$xml .= '<tspan dx="40" y="'.$text_y.'">#7</tspan>';
				$xml .= '<tspan dx="40" y="'.$text_y.'">#9</tspan>';
				$xml .= '<tspan dx="34" y="'.$text_y.'">#11</tspan>';
				$xml .= '<tspan dx="27" y="'.$text_y.'">#13</tspan>';
				$xml .= '<tspan dx="25" y="'.$text_y.'">#15</tspan>';
				$xml .= '<tspan dx="27" y="'.$text_y.'">#17</tspan>';
				$xml .= '<tspan dx="26" y="'.$text_y.'">#19</tspan>';
				$xml .= '<tspan dx="33" y="'.$text_y.'">#21</tspan>';
				$xml .= '<tspan dx="27" y="'.$text_y.'">40c</tspan>';
				$xml .= '<tspan dx="28" y="'.$text_y.'">50c</tspan>';
				$xml .= '<tspan dx="36" y="'.$text_y.'">その他</tspan>';
				$xml .= '<tspan dx="48" y="'.$text_y.'">数量</tspan>';
				$xml .= '<tspan dx="67" y="'.$text_y.'">単価</tspan>';
				$xml .= '<tspan dx="75" y="'.$text_y.'">小計</tspan>';
				$xml .= '<tspan dx="85" y="'.$text_y.'">納期</tspan>';
				$xml .= '<tspan dx="90" y="'.$text_y.'">備考</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="255" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="395" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="460" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="525" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="590" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="655" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="720" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="785" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="850" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="915" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1045" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1110" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1175" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1240" y="'.$rect_y.'" width="110" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//その他
				$xml .= '<rect x="1350" y="'.$rect_y.'" width="115" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//数量
				$xml .= '<rect x="1465" y="'.$rect_y.'" width="120" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//単価
				$xml .= '<rect x="1585" y="'.$rect_y.'" width="135" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//金額
				$xml .= '<rect x="1720" y="'.$rect_y.'" width="130" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//納期
				$xml .= '<rect x="1850" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//備考
    		}

    		$params = array(
				'conditions'=>array('Item.id'=>$value['item_id']),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
    		$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		if(empty($value['#1']))$value['#1'] = '';
    		if(empty($value['#3']))$value['#3'] = '';
    		if(empty($value['#5']))$value['#5'] = '';
    		if(empty($value['#7']))$value['#7'] = '';
    		if(empty($value['#9']))$value['#9'] = '';
    		if(empty($value['#11']))$value['#11'] = '';
    		if(empty($value['#13']))$value['#13'] = '';
    		if(empty($value['#15']))$value['#15'] = '';
    		if(empty($value['#17']))$value['#17'] = '';
    		if(empty($value['#19']))$value['#19'] = '';
    		if(empty($value['#21']))$value['#21'] = '';
    		if(empty($value['40cm']))$value['40cm'] = '';
    		if(empty($value['50cm']))$value['50cm'] = '';
    		if(empty($value['other']))$value['other'] = '';
    		$value['date'] = substr($value['date'], 5, 5);
    		$bid = number_format($value['bid']);
    		$total = number_format($value['total']);
    		$footer_date = date('Y/m/d(D)H:i:s');

    		$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="255" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="395" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="460" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="525" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="590" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="655" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="720" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="785" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="850" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="915" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="980" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1045" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1110" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1175" y="'.$rect_y.'" width="65" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1240" y="'.$rect_y.'" width="110" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//その他
			$xml .= '<rect x="1350" y="'.$rect_y.'" width="115" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//数量
			$xml .= '<rect x="1465" y="'.$rect_y.'" width="120" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//単価
			$xml .= '<rect x="1585" y="'.$rect_y.'" width="135" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//金額
			$xml .= '<rect x="1720" y="'.$rect_y.'" width="130" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//納期
			$xml .= '<rect x="1850" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//備考

			$xml .= '<text x="110" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter.'</text>';
			$xml .= '<text x="150" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$item['Item']['name'].'</text>';//品番
			$xml .= '<text x="450" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#1'].'</text>';//#01
			$xml .= '<text x="515" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#3'].'</text>';//#03
			$xml .= '<text x="580" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#5'].'</text>';//#05
			$xml .= '<text x="645" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#7'].'</text>';//#07
			$xml .= '<text x="710" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#9'].'</text>';//#09
			$xml .= '<text x="775" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#11'].'</text>';//#11
			$xml .= '<text x="840" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#13'].'</text>';//#13
			$xml .= '<text x="905" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#15'].'</text>';//#15
			$xml .= '<text x="970" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#17'].'</text>';//#17
			$xml .= '<text x="1035" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#19'].'</text>';//#19
			$xml .= '<text x="1100" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['#21'].'</text>';//#21
			$xml .= '<text x="1165" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['40cm'].'</text>';//40
			$xml .= '<text x="1230" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['50cm'].'</text>';//50
			$xml .= '<text x="1260" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$value['other'].'</text>';//その他
			$xml .= '<text x="1455" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$value['total_qty'].'</text>';//数量
			$xml .= '<text x="1575" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$bid.'</text>';//単価
			$xml .= '<text x="1710" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$total.'</text>';//小計
			$xml .= '<text x="1755" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$value['date'].'</text>';//納期
			$xml .= '<text x="1860" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック"></text>';//備考


			if($no_counter == count($values)){
				$detail_total = number_format($tax['detail_total']);
				$taxx = number_format($tax['tax']);
				if(!empty($ordering['Ordering']['adjustment'])){
					$totalx = $tax['total'] + $ordering['Ordering']['adjustment'];
					$adjustment = number_format($ordering['Ordering']['adjustment']);
					$totalx = number_format($totalx);
				}else{
					$totalx = number_format($tax['total']);
					$adjustment = '';
				}
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1250" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1350" y="'.$rect_y.'" width="115" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1465" y="'.$rect_y.'" width="120" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1585" y="'.$rect_y.'" width="135" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1720" y="'.$rect_y.'" width="130" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1850" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="1260" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">合計</text>';
				$xml .= '<text x="1455" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$all_qty.'</text>';
				$xml .= '<text x="1710" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$detail_total.'</text>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1250" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1350" y="'.$rect_y.'" width="115" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1465" y="'.$rect_y.'" width="120" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1585" y="'.$rect_y.'" width="135" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1720" y="'.$rect_y.'" width="130" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1850" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="1260" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">消費税</text>';
				$xml .= '<text x="1710" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$taxx.'</text>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1250" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1350" y="'.$rect_y.'" width="115" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1465" y="'.$rect_y.'" width="120" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1585" y="'.$rect_y.'" width="135" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1720" y="'.$rect_y.'" width="130" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1850" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="1260" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">調整</text>';
				$xml .= '<text x="1710" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$adjustment.'</text>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1250" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1350" y="'.$rect_y.'" width="115" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1465" y="'.$rect_y.'" width="120" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1585" y="'.$rect_y.'" width="135" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1720" y="'.$rect_y.'" width="130" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1850" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="1260" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">総合計</text>';
				$xml .= '<text x="1710" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.$totalx.'</text>';

				$rect_y = $rect_y + $rect_height * 2;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="235" fill="none" stroke="#808080" stroke-width="1"/>';
				$text_yy = $text_y + 60;
				$xml .= '<text x="100" y="'.$text_yy.'" font-size="25" fill="#808080" font-family="ＭＳ ゴシック">※弊社使用欄</text>';
				$stamp_y = $text_y + 85;
				$xml .= '<rect x="115" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="295" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="475" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="655" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$stamp_line = $stamp_y + 40;
				$stamp_na1 = $stamp_y + 30;
				$stamp_na2 = $stamp_y + 10;
				$xml .= '<g stroke="#808080" stroke-width="1"><polyline points="115,'.$stamp_line.' 835,'.$stamp_line.'"/>';
				$xml .= '<polyline points="195,'.$stamp_na1.' 205,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="375,'.$stamp_na1.' 385,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="555,'.$stamp_na1.' 565,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="735,'.$stamp_na1.' 745,'.$stamp_na2.'"/>';
				$xml .= '</g>';
			}

			$page_counter++;
    		if($page_counter == 31){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Order Sheet No.'.$ordering['Ordering']['id'].'　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}

    	if($page_counter < 31 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Order Sheet No.'.$ordering['Ordering']['id'].'　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}
    	return $xml;
    }

	function purchase($Purchase, $PurchaseDetail, $file_name){
		App::import('Model', 'Factory');
    	$FactoryModel = new Factory();
    	App::import('Model', 'User');
    	$UserModel = new User();
    	$params = array(
			'conditions'=>array('Factory.id'=>$Purchase['Purchase']['factory_id']),
			'recursive'=>0,
		);
		$factory = $FactoryModel->find('first' ,$params);
		$params = array(
			'conditions'=>array('User.id'=>$Purchase['Purchase']['created_user']),
			'recursive'=>0,
		);
		$user = $UserModel->find('first' ,$params);

		//pr($user);
		//pr($factory);
		//pr($Purchase);
		//pr($PurchaseDetail);
		//exit;

		$i = 0;
		foreach($PurchaseDetail as $detail){
			$sub_total[$i]['money'] = $detail['PurchaseDetail']['bid'];
    		$sub_total[$i]['quantity'] = $detail['PurchaseDetail']['quantity'];
    		$i++;
		}

		$tax = $this->Total->slipTotal($sub_total, $factory['Factory']['tax_method'], $factory['Factory']['tax_fraction']);
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$total_page = count($PurchaseDetail);
    	$total_page = ceil($total_page / 41);
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_quantity = 0;

    	$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Catalog" xmlns:xlink="http://www.w3.org/1999/xlink">';

    	foreach($PurchaseDetail as $detail){
    	if($page_counter == 1){
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			$xml .= '<text x="100" y="200" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="40">仕入No.　　　:　'.$Purchase['Purchase']['id'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">仕入日　　　:　'.$Purchase['Purchase']['date'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">仕入担当者　:　'.$user['Section']['name'].'　'.$user['User']['name'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">商品合計　　：　'.number_format($Purchase['Purchase']['detail_total']).'</tspan>';
				$xml .= '<tspan x="110" dy="40">消費税　　　：　'.number_format($Purchase['Purchase']['total_tax']).'</tspan>';
				$xml .= '<tspan x="110" dy="40">送料　　　　：　'.number_format($Purchase['Purchase']['shipping']).'</tspan>';
				$xml .= '<tspan x="110" dy="40">調整　　　　：　'.number_format($Purchase['Purchase']['adjustment']).'</tspan>';
				$xml .= '<tspan x="110" dy="40">総合計　　　：　'.number_format($Purchase['Purchase']['total']).'</tspan>';
				$xml .= '</text>';
				//$xml .= '<g stroke="black" stroke-width="2"><polyline points="100,280 450,280"/></g>';
				$xml .= '<text x="880" y="200" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7">仕入リスト</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="840,220 1260,220"/><polyline points="840,228 1260,228"/></g>';
				$xml .= '<text x="1650" y="160" font-size="26" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				$xml .= '<tspan x="1650" dy="30">日　付 :　</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="1450" y="280" font-size="26" fill="black" font-family="ＭＳ ゴシック">工場・仕入先:';
				$xml .= '<tspan x="1450" dy="40">'.$Purchase['Factory']['name'].'</tspan>';
				if(empty($Purchase['Factory']['charge_section'])) $Purchase['Factory']['charge_section'] = '';
				if(empty($Purchase['Factory']['charge_person'])) $Purchase['Factory']['charge_person'] = '';
				$xml .= '<tspan x="1450" dy="40">'.$Purchase['Factory']['charge_section'].'　'.$Purchase['Factory']['charge_person'].'</tspan>';
				if(empty($Purchase['Factory']['tel'])) $Purchase['Factory']['tel'] = '';
				if(empty($Purchase['Factory']['fax'])) $Purchase['Factory']['fax'] = '';
				$xml .= '<tspan x="1450" dy="40">TEL : '.$Purchase['Factory']['tel'].'　FAX : '.$Purchase['Factory']['fax'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="1550" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1450,560 1850,560"/></g>';
				$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">No';
				$xml .= '<tspan x="250" y="'.$text_y.'">子品番</tspan>';
				$xml .= '<tspan x="475" y="'.$text_y.'">受注No.</tspan>';
				$xml .= '<tspan x="630" y="'.$text_y.'">発注No.</tspan>';
				$xml .= '<tspan x="815" y="'.$text_y.'">入庫倉庫：No.</tspan>';
				$xml .= '<tspan x="1065" y="'.$text_y.'">仕入単価</tspan>';
				$xml .= '<tspan x="1240" y="'.$text_y.'">数量</tspan>';
				$xml .= '<tspan x="1390" y="'.$text_y.'">小計</tspan>';
				$xml .= '<tspan x="1700" y="'.$text_y.'">備考</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//子品番
				$xml .= '<rect x="440" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//受注
				$xml .= '<rect x="590" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//発注
				$xml .= '<rect x="740" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//倉庫
				$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//仕入金額
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//数量
				$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//小計
				$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//備考
    		}

    		//本文をいれるところ
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$sub_total = $detail['PurchaseDetail']['bid'] * $detail['PurchaseDetail']['quantity'];
    		$total_quantity = $total_quantity + $detail['PurchaseDetail']['quantity'];
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="160" y="'.$text_y.'">'.$detail['Subitem']['name'].'</tspan>';
			$xml .= '<tspan x="460" y="'.$text_y.'">'.$detail['PurchaseDetail']['order_id'].'</tspan>';
			$xml .= '<tspan x="615" y="'.$text_y.'">'.$detail['PurchaseDetail']['ordering_id'].'</tspan>';
			$xml .= '<tspan x="760" y="'.$text_y.'">'.$detail['Depot']['name'].':'.$detail['Depot']['id'].'</tspan>';
			$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end">'.number_format($detail['PurchaseDetail']['bid']).'</tspan>';
			$xml .= '<tspan x="1320" y="'.$text_y.'" text-anchor="end">'.$detail['PurchaseDetail']['quantity'].'</tspan>';
			$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.number_format($sub_total).'</tspan>';
			$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//子品番
			$xml .= '<rect x="440" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//受注
			$xml .= '<rect x="590" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//発注
			$xml .= '<rect x="740" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//倉庫
			$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//仕入金額
			$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//数量
			$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//小計
			$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//備考

			if($no_counter == count($PurchaseDetail)){
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1080" y="'.$text_y.'">合計</tspan>';
				$xml .= '<tspan x="1320" y="'.$text_y.'" text-anchor="end">'.$total_quantity.'</tspan>';
				$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.number_format($Purchase['Purchase']['detail_total']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="940" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//仕入
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//数量
				$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//小計
				$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';//備考
			}

    		$page_counter++;
    		if($page_counter == 41){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Buying Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 41 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Buying Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}
    	return $xml;
	}
	
	
	function TransportOrigin($Transport){
		$xml = '';
    	//ここから
    	App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	$params = array(
			'conditions'=>array('Depot.id'=>$Transport['Transport']['out_depot']),
			'recursive'=>0,
		);
		$out_depot = $DepotModel->find('first' ,$params);
		$params = array(
			'conditions'=>array('Depot.id'=>$Transport['Transport']['in_depot']),
			'recursive'=>0,
		);
		$in_depot = $DepotModel->find('first' ,$params);
		App::import('Model', 'User');
    	$UserModel = new User();
    	$params = array(
			'conditions'=>array('User.id'=>$Transport['Transport']['created_user']),
			'recursive'=>0,
		);
		$created_user = $UserModel->find('first' ,$params);
		$params = array(
			'conditions'=>array('User.id'=>$Transport['Transport']['updated_user']),
			'recursive'=>0,
		);
		$updated_user = $UserModel->find('first' ,$params);
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($Transport['TransportDateil']);
    	$total_page = ceil($total_page / 41);
    	$transport_status = get_transport_status();
    	if(!empty($Transport['Transport']['layaway_type'])){
    		$layaway_type = get_layaway_type();
    		$layaway_name = $layaway_type[$Transport['Transport']['layaway_type']];
    	}else{
    		$layaway_name = 'none';
    	}
		$price_total = 0;
    	$total_out_qty = 0;
    	$out_depot['Section']['name'] = $CleaningComponent->sectionName($out_depot['Section']['name']);
    	$in_depot['Section']['name'] = $CleaningComponent->sectionName($in_depot['Section']['name']);
    	foreach($Transport['TransportDateil'] as $dateil){
    		if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="300" font-size="28" fill="black" font-family="ＭＳ ゴシック">【出庫】';
				$xml .= '<tspan x="100" dy="40">　部門・店舗：'.$out_depot['Section']['name'].'</tspan>';
				$xml .= '<tspan x="100" dy="40">　倉庫　　　：'.$out_depot['Depot']['name'].':'.$out_depot['Depot']['id'].'</tspan>';
				$xml .= '<tspan x="900" dy="-80">【入庫】</tspan>';
				$xml .= '<tspan x="900" dy="40">　部門・店舗：'.$in_depot['Section']['name'].'</tspan>';
				$xml .= '<tspan x="900" dy="40">　倉庫　　　：'.$in_depot['Depot']['name'].':'.$in_depot['Depot']['id'].'</tspan>';
				$xml .= '<tspan x="1500" dy="-40">作成者：'.$created_user['User']['name'].'</tspan>';
				$xml .= '<tspan x="1500" dy="40">更新者：'.$updated_user['User']['name'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="100" y="460" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="100" dy="0">【　状態　】'.$transport_status[$Transport['Transport']['transport_status']].'</tspan>';
				$xml .= '<tspan x="100" dy="40">【伝票番号】'.$Transport['Transport']['id'].'</tspan>';
				$xml .= '<tspan x="500" dy="-40">【出荷予定日】'.$Transport['Transport']['delivary_date'].'</tspan>';
				$xml .= '<tspan x="500" dy="40">【着荷希望日】'.$Transport['Transport']['arrival_date'].'</tspan>';
				$xml .= '<tspan x="900" dy="-40">【取置区分　】'.$layaway_name.'</tspan>';
				$xml .= '<tspan x="900" dy="40">【取置依頼者】'.$Transport['Transport']['layaway_user'].'</tspan>';
				$xml .= '</text>';
				//中央タイトル部
				$xml .= '<text x="910" y="205" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7">移動伝票</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="840,220 1260,220"/><polyline points="840,228 1260,228"/></g>';
				//右日付部
				$xml .= '<text x="1650" y="160" font-size="26" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				$xml .= '<tspan x="1650" dy="30">日　付 :　'.date('Y-m-d').'</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="1650" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1550,560 1950,560"/></g>';
				//表のヘッダー
				$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">No';
				$xml .= '<tspan x="250" y="'.$text_y.'">子品番</tspan>';
				$xml .= '<tspan x="475" y="'.$text_y.'"></tspan>';
				$xml .= '<tspan x="630" y="'.$text_y.'"></tspan>';
				$xml .= '<tspan x="815" y="'.$text_y.'">受注番号</tspan>';
				$xml .= '<tspan x="1065" y="'.$text_y.'">出庫数</tspan>';
				$xml .= '<tspan x="1240" y="'.$text_y.'">引当数</tspan>';
				$xml .= '<tspan x="1390" y="'.$text_y.'">金額</tspan>';
				$xml .= '<tspan x="1700" y="'.$text_y.'">備考</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="440" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="590" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="740" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}
			
			$params = array(
				'conditions'=>array('Item.id'=>$dateil['Subitem']['item_id']),
				'recursive'=>0,
				'fields'=>array('Item.price'),
			);
			$item = $ItemModel->find('first' ,$params);
			$item_price = $item['Item']['price'];
			$detail_total = $item_price * $dateil['pairing_quantity'];
			$price_total = $price_total + $detail_total;
			
    		//本文
    		$total_out_qty = $total_out_qty + $dateil['out_qty'];
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="160" y="'.$text_y.'">'.$dateil['Subitem']['name'].'</tspan>';
			$xml .= '<tspan x="460" y="'.$text_y.'"></tspan>';
			$xml .= '<tspan x="615" y="'.$text_y.'"></tspan>';
			$xml .= '<tspan x="760" y="'.$text_y.'">'.$dateil['order_id'].'</tspan>';
			$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end">'.$dateil['out_qty'].'</tspan>';
			$xml .= '<tspan x="1320" y="'.$text_y.'" text-anchor="end">'.$dateil['pairing_quantity'].'</tspan>';
			$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.number_format($detail_total).'</tspan>';
			$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="440" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="590" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="740" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($Transport['TransportDateil'])){//表のフッター出力
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="950" y="'.$text_y.'">合計</tspan>';
				$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end">'.$total_out_qty.'</tspan>';
				$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.number_format($price_total).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="940" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$Transport['Transport']['remark'];
    			//$xml .= '<tspan x="950" y="'.$text_y.'">合計</tspan>';
				//$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end">'.$total_out_qty.'</tspan>';
				//$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.number_format($price_total).'</tspan>';
				//$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$rect_height = $rect_height * 2;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				//$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				//$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				//$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				//$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				
			}
			$page_counter++;
    		if($page_counter == 41){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Transport '.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 41 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Transport '.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page>';
    	}
    	//ここまで
		return $xml;
	}
	
	function TransportBatch($transports, $file_name){
		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Transport" xmlns:xlink="http://www.w3.org/1999/xlink">';
    	foreach($transports as $Transport){
    		$xml .= $this->TransportOrigin($Transport);
    	}
		$xml .= '</pxd>';
    	return $xml;
	}
	
	function transport($Transport, $file_name){
		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Transport" xmlns:xlink="http://www.w3.org/1999/xlink">';
    	$xml .= $this->TransportOrigin($Transport);
		$xml .= '</pxd>';
    	return $xml;
	}

	function OrderPrint($order, $file_name){
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
		App::import('Model', 'Company');
    	$CompanyModel = new Company();
    	$params = array(
			'conditions'=>array('Company.id'=>$order['Destination']['company_id']),
			'recursive'=>0,
		);
		$Company = $CompanyModel->find('first' ,$params);

		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Order" xmlns:xlink="http://www.w3.org/1999/xlink">';
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($order['OrderDateil']);
    	$total_page = ceil($total_page / 37);

    	foreach($order['OrderDateil'] as $dateil){
    		if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="250" font-size="32" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="100" dy="0">会社名：'.$Company['Company']['name'].'</tspan>';
				$xml .= '<tspan x="100" dy="45">店舗名：'.$order['Destination']['name'].'　御中</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="100" y="330" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="0">'.$order['Destination']['post_code'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$order['Destination']['district'].$order['Destination']['address_one'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$order['Destination']['address_two'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">Tel:'.$order['Destination']['tel'].'</tspan>';
				$xml .= '<tspan x="430" dy="0">Fax:'.$order['Destination']['fax'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="110" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">下記の通り、御注文をお請け致しました。ご確認下さいませ。</text>';
				//中央タイトル部
				$xml .= '<text x="1100" y="170" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7" text-anchor="middle">注文請書</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="890,190 1310,190"/><polyline points="890,198 1310,198"/></g>';
				//右日付部
				$xml .= '<text x="1430" y="160" font-size="28" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				 $xml .= '<tspan x="1430" dy="0">受注番号:　'.$order['Order']['id'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">　受注日:　'.$order['Order']['date'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">先様番号:　'.$order['Order']['partners_no'].'</tspan>';
				$xml .= '</text>';
				//右テキスト部
				$xml .= '<text x="1450" y="330" font-size="26" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">';
				$xml .= '<tspan x="2000" dy="0">'.INC_NAME_JA.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_POSTCODE.INC_ADDRESS1.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_ADDRESS2.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">Tel:'.INC_TEL.'　　Fax:'.INC_FAX.'</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="1700" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1600,560 2000,560"/></g>';
				//表のヘッダー
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
				$xml .= '<tspan x="330" y="'.$text_y.'">品番</tspan>';
				$xml .= '<tspan x="590" y="'.$text_y.'">Size</tspan>';
				$xml .= '<tspan x="820" y="'.$text_y.'">刻印</tspan>';
				$xml .= '<tspan x="1065" y="'.$text_y.'">出荷予定日</tspan>';
				$xml .= '<tspan x="1200" y="'.$text_y.'">数量</tspan>';
				$xml .= '<tspan x="1335" y="'.$text_y.'">上代単価</tspan>';
				$xml .= '<tspan x="1710" y="'.$text_y.'">備考</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}

    		//本文
    		$params = array(
				'conditions'=>array('Item.id'=>$dateil['item_id']),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
			$params = array(
				'conditions'=>array('Subitem.id'=>$dateil['subitem_id']),
				'recursive'=>0,
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$size = $this->Selector->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
			$remark = '';
			if($dateil['an_quantity'] >= 1){
				$remark .= '破棄　'.$dateil['an_quantity'].'点';
			} 
			if(!empty($dateil['sub_remarks'])){
				if(!empty($remark)) $remark .= ' | ';
				$remark .= mb_substr($dateil['sub_remarks'], 0, 20);
			} 
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="160" y="'.$text_y.'">'.$item['Item']['name'].'</tspan>';
			$xml .= '<tspan x="540" y="'.$text_y.'">'.$size.'</tspan>';
			$xml .= '<tspan x="680" y="'.$text_y.'">'.$dateil['marking'].'</tspan>';
			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">'.$dateil['shipping_date'].'</tspan>';
			$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end">'.$dateil['bid_quantity'].'</tspan>';
			$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($item['Item']['price']).'</tspan>';
			$xml .= '<tspan x="1440" y="'.$text_y.'">'.$remark.'</tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($order['OrderDateil'])){//表のフッター出力
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">合計</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end">'.$no_counter.'</tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($order['Order']['price_total']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="880" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			}
			$page_counter++;
    		if($page_counter == 37){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Order Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 37 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Order Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}

    	return $xml;
	}

	function CustomOrderPrint($order, $file_name){
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();

		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Order" xmlns:xlink="http://www.w3.org/1999/xlink">';
//pr($order);
//exit;
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($order['OrderDateil']);
    	$total_page = ceil($total_page / 37);

    	$total_bid = 0;
    	$total_pairing = 0;
    	$total_ordering = 0;

    	foreach($order['OrderDateil'] as $dateil){
    		if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="250" font-size="32" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="100" dy="0">部門名：'.$order['Section']['name'].'</tspan>';
    			$xml .= '<tspan x="100" dy="45">　倉庫：'.$order['Depot']['name'].':'.$order['Depot']['id'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="100" y="330" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="0">'.$order['Section']['post_code'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$order['Section']['district'].$order['Section']['adress_one'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$order['Section']['adress_two'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">Tel:'.$order['Section']['tel'].'</tspan>';
				$xml .= '<tspan x="430" dy="0">Fax:'.$order['Section']['fax'].'</tspan>';
				$xml .= '</text>';
				//中央タイトル部
				$xml .= '<text x="1000" y="170" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7" text-anchor="middle">客注伝票</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="790,190 1210,190"/><polyline points="790,198 1210,198"/></g>';
				//右日付部
				$xml .= '<text x="1430" y="140" font-size="28" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				 $xml .= '<tspan x="1430" dy="0">受注番号:　'.$order['Order']['id'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">　受注日:　'.$order['Order']['date'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">施設番号:　'.$order['Order']['partners_no'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">イベント:　'.$order['Order']['events_no'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">スパンNo:　'.$order['Order']['span_no'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">合計金額:　'.number_format($order['Order']['total']).'</tspan>';
				$xml .= '<tspan x="1430" dy="45">担当者１:　'.$order['Order']['contact1_name'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">担当者２:　'.$order['Order']['contact2_name'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">担当者３:　'.$order['Order']['contact3_name'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">担当者４:　'.$order['Order']['contact4_name'].'</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="150" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="100,560 400,560"/></g>';
				//表のヘッダー
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
				$xml .= '<tspan x="315" y="'.$text_y.'">子品番</tspan>';
				$xml .= '<tspan x="565" y="'.$text_y.'">価格</tspan>';
				$xml .= '<tspan x="730" y="'.$text_y.'">納期</tspan>';
				$xml .= '<tspan x="910" y="'.$text_y.'">店着</tspan>';
				$xml .= '<tspan x="1090" y="'.$text_y.'">入荷</tspan>';
				$xml .= '<tspan x="1270" y="'.$text_y.'">出荷</tspan>';
				$xml .= '<tspan x="1410" y="'.$text_y.'">受注</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'">引当</tspan>';
				$xml .= '<tspan x="1610" y="'.$text_y.'">発注</tspan>';
				$xml .= '<tspan x="1830" y="'.$text_y.'">刻印</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="350" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="490" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="640" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="820" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1000" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1180" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1360" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1460" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1560" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1660" y="'.$rect_y.'" width="340" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}
    		//本文
			$params = array(
				'conditions'=>array('Subitem.id'=>$dateil['subitem_id']),
				'recursive'=>0,
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$total_bid = $total_bid + $dateil['bid_quantity'];
    		$total_pairing = $total_pairing + $dateil['pairing_quantity'];
    		$total_ordering = $total_ordering + $dateil['ordering_quantity'];
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="315" y="'.$text_y.'" text-anchor="middle">'.$subitem['Subitem']['name'].'</tspan>';
			$xml .= '<tspan x="620" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['bid']).'</tspan>';
			$xml .= '<tspan x="730" y="'.$text_y.'" text-anchor="middle">'.$dateil['specified_date'].'</tspan>';
			$xml .= '<tspan x="910" y="'.$text_y.'" text-anchor="middle">'.$dateil['store_arrival_date'].'</tspan>';
			$xml .= '<tspan x="1090" y="'.$text_y.'" text-anchor="middle">'.$dateil['stock_date'].'</tspan>';
			$xml .= '<tspan x="1270" y="'.$text_y.'" text-anchor="middle">'.$dateil['shipping_date'].'</tspan>';
			$xml .= '<tspan x="1440" y="'.$text_y.'" text-anchor="end">'.$dateil['bid_quantity'].'</tspan>';
			$xml .= '<tspan x="1540" y="'.$text_y.'" text-anchor="end">'.$dateil['pairing_quantity'].'</tspan>';
			$xml .= '<tspan x="1640" y="'.$text_y.'" text-anchor="end">'.$dateil['ordering_quantity'].'</tspan>';
			$xml .= '<tspan x="1680" y="'.$text_y.'">'.$dateil['marking'].'</tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="350" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="490" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="640" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="820" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1000" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1180" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1360" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1460" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1560" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1660" y="'.$rect_y.'" width="340" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($order['OrderDateil'])){//表のフッター出力
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="1270" y="'.$text_y.'" text-anchor="middle">合計</tspan>';
				$xml .= '<tspan x="1440" y="'.$text_y.'" text-anchor="end">'.$total_bid.'</tspan>';
				$xml .= '<tspan x="1540" y="'.$text_y.'" text-anchor="end">'.$total_pairing.'</tspan>';
				$xml .= '<tspan x="1640" y="'.$text_y.'" text-anchor="end">'.$total_ordering.'</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="350" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="490" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="640" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="820" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1000" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1180" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1360" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1460" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1560" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1660" y="'.$rect_y.'" width="340" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			}
			$page_counter++;
    		if($page_counter == 37){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Order Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 37 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Order Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}

    	return $xml;
	}

	function OrderPickList($orders, $file_name){
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
		$order_type = get_order_type();
		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] PickList" xmlns:xlink="http://www.w3.org/1999/xlink">';
		$text_y = 230;
    	$rect_y = 190;
    	$rect_height = 55;
		$footer_date = date('Y/m/d(D)H:i:s');
		$no_counter = 1;
		$page_counter = 1;
		$page_no = 1;
		$page_line = 47;
		$ws_output = false;
    	foreach($orders as $order){
    		//（卸）のみ
    		//if($order['Order']['order_type'] == 1 or $order['Order']['order_type'] == 3){
    			//$remark = '';
    			//if(!empty($order['Order']['pairing1'])) $remark = '取置番号;'.$order['Order']['pairing1'];
    			//if(!empty($order['Order']['pairing2'])) $remark .= '、'.$order['Order']['pairing2'];
    			//if(!empty($order['Order']['pairing3'])) $remark .= '、'.$order['Order']['pairing3'];
    			//if(!empty($order['Order']['pairing4'])) $remark .= '、'.$order['Order']['pairing4'];
    			//本文
    			foreach($order['OrderDateil'] as $details){
    				// (卸)のみ　っていうのをここで実現
    				if($details['order_type'] == 1 or $details['order_type'] == 3){
    					$ws_output = true;
    					$SubitemModel->unbindModel(array('belongsTo'=>array('Process', 'Material')));
    					$params = array(
							'conditions'=>array('Subitem.id'=>$details['subitem_id']),
							'recursive'=>0,
						);
						$subitem = $SubitemModel->find('first' ,$params);
						//在庫管理しない、または単品管理の場合はスキップ
						if($subitem['Item']['stock_code'] == '2' or $subitem['Item']['stock_code'] == '3') continue;
    					if($page_counter == 1){
    						$xml .= picklistHead($footer_date, $page_no, $text_y, $rect_y, $rect_height);
    					}
						if(empty($order['Destination']['name'])) $order['Destination']['name'] = '';
						if(empty($details['specified_date'])) $details['specified_date'] = '';
						$rect_y = $rect_y + $rect_height;
    					$text_y = $text_y + $rect_height;
    					$xml .= '<text x="105" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
						$xml .= '<tspan x="160" y="'.$text_y.'">'.$order_type[$details['order_type']].'</tspan>';
						$xml .= '<tspan x="385" y="'.$text_y.'" text-anchor="end">'.$order['Order']['id'].'</tspan>';
						$xml .= '<tspan x="425" y="'.$text_y.'">'.mb_substr($order['Destination']['name'], 0, 11).'</tspan>';
						$xml .= '<tspan x="725" y="'.$text_y.'">'.mb_substr($order['Depot']['name'], 0, 6).':'.$order['Depot']['id'].'</tspan>';
						$xml .= '<tspan x="955" y="'.$text_y.'">'.$subitem['Subitem']['name'].'</tspan>';
						$xml .= '<tspan x="1275" y="'.$text_y.'">'.substr($details['specified_date'], 5, 5).'</tspan>';
						$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.$details['bid_quantity'].'</tspan>';
						$xml .= '<tspan x="1510" y="'.$text_y.'">'.mb_substr($details['sub_remarks'], 0, 15).'</tspan>';
						$xml .= '</text>';
						$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="140" y="'.$rect_y.'" width="160" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="300" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="405" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="705" y="'.$rect_y.'" width="230" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="935" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="1235" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="1385" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$no_counter++;
						$page_counter++;
						//$page_line++;
    					if($page_counter > $page_line){
    						$xml .= '</svg></page>';
    						$page_counter = 1;
    						$text_y = 230;
    						$rect_y = 190;
    						$page_no++;
    						$page_line = 47;
    					}
    				}
    			}
    		//}
    	}
		if($page_counter <= $page_line and $ws_output == true){
    		$xml .= '</svg></page>';
    	}
    	//次のページ
		$text_y = 230;
    	$rect_y = 190;
    	$rect_height = 55;
		$no_counter = 1;
		$page_counter = 1;
		$page_no = 1;
		$page_line = 47;
		$retail_output = false;
    	foreach($orders as $order){
    		//（客注）のみ
    		//if($order['Order']['order_type'] == 2){
    			//$remark = '';
    			//if(!empty($order['Order']['pairing1'])) $remark = '取置番号;'.$order['Order']['pairing1'];
    			//if(!empty($order['Order']['pairing2'])) $remark .= '、'.$order['Order']['pairing2'];
    			//if(!empty($order['Order']['pairing3'])) $remark .= '、'.$order['Order']['pairing3'];
    			//if(!empty($order['Order']['pairing4'])) $remark .= '、'.$order['Order']['pairing4'];
    			//本文
    			foreach($order['OrderDateil'] as $details){
    				//（客注）のみ っていうのをここで実現
    				if($details['order_type'] != 2) continue;
    				$retail_output = true;
    				$SubitemModel->unbindModel(array('belongsTo'=>array('Process', 'Material')));
    				$params = array(
						'conditions'=>array('Subitem.id'=>$details['subitem_id']),
						'recursive'=>0,
					);
					$subitem = $SubitemModel->find('first' ,$params);
					//在庫管理しない、または単品管理の場合はスキップ
					if($subitem['Item']['stock_code'] == '2' or $subitem['Item']['stock_code'] == '3') continue;
    				if($page_counter == 1){
    					$xml .= picklistStoreHead($footer_date, $page_no, $text_y, $rect_y, $rect_height);
    				}
					if(empty($order['Destination']['name'])) $order['Destination']['name'] = '';
					if(empty($details['specified_date'])) $details['specified_date'] = '';
					$section_name = $SectionModel->cleaningName($order['Order']['section_id']);
					$depot_name = $DepotModel->getName($details['depot_id']);
					$rect_y = $rect_y + $rect_height;
    				$text_y = $text_y + $rect_height;
    				$xml .= '<text x="105" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
					$xml .= '<tspan x="160" y="'.$text_y.'">'.$order_type[$details['order_type']].'</tspan>';
					$xml .= '<tspan x="385" y="'.$text_y.'" text-anchor="end">'.$order['Order']['id'].'</tspan>';
					$xml .= '<tspan x="425" y="'.$text_y.'">'.mb_substr($section_name, 0, 11).'</tspan>';
					$xml .= '<tspan x="725" y="'.$text_y.'">'.mb_substr($depot_name, 0, 6).':'.$details['depot_id'].'</tspan>';
					
					$xml .= '<tspan x="955" y="'.$text_y.'">'.$subitem['Subitem']['name'].'</tspan>';
					$xml .= '<tspan x="1275" y="'.$text_y.'">'.substr($details['specified_date'], 5, 5).'</tspan>';
					$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end">'.$details['bid_quantity'].'</tspan>';
					$xml .= '<tspan x="1510" y="'.$text_y.'">'.mb_substr($details['sub_remarks'], 0, 18).'</tspan>';
					$xml .= '</text>';
					$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="140" y="'.$rect_y.'" width="160" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="300" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="405" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="705" y="'.$rect_y.'" width="230" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="935" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1235" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1385" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$no_counter++;
					$page_counter++;
					//$page_line++;
    				if($page_counter > $page_line){
    					$xml .= '</svg></page>';
    					$page_counter = 1;
    					$text_y = 230;
    					$rect_y = 190;
    					$page_no++;
    					$page_line = 47;
    				}
    			}
    		//}
    	}
		if($page_counter <= $page_line and $retail_output == true){
    		$xml .= '</svg></page>';
    	}
    	$xml .= '</pxd>';
    	return $xml;
	}

	function SalePrint($sale, $file_name){
		App::import('Model', 'User');
    	$UserModel = new User();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		App::import('Model', 'Company');
    	$CompanyModel = new Company();
    	if(!empty($sale['Destination']['company_id'])){
    		$params = array(
				'conditions'=>array('Company.id'=>$sale['Destination']['company_id']),
				'recursive'=>0,
			);
			$Company = $CompanyModel->find('first' ,$params);
			$params = array(
				'conditions'=>array('User.id'=>$Company['Company']['user_id']),
				'recursive'=>0,
			);
			$user = $UserModel->find('first' ,$params);
			$contact1_name = $user['User']['name'];
    	}
		$params = array(
			'conditions'=>array('User.id'=>$sale['Sale']['updated_user']),
			'recursive'=>0,
		);
		$user = $UserModel->find('first' ,$params);
		$updated_user_name = $user['User']['name'];
		$order_number = '';
		foreach($sale['Order'] as $order){
			 if(empty($order_number)){
			 	$order_number = $order['id'];
			 }else{
			 	$order_number .= '、'.$order['id'];
			 }
		}
		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.]" xmlns:xlink="http://www.w3.org/1999/xlink">';
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($sale['SalesDateil']);
    	$total_page = ceil($total_page / 35);
    	$item_total_qty = 0;
		//納品書
    	foreach($sale['SalesDateil'] as $dateil){
    	if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="250" font-size="32" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="100" dy="0">会社名：'.$Company['Company']['name'].'</tspan>';
				$xml .= '<tspan x="100" dy="45">店舗名：'.$sale['Destination']['name'].'　御中</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="100" y="330" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="0">'.$sale['Destination']['post_code'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$sale['Destination']['district'].$sale['Destination']['address_one'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$sale['Destination']['address_two'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">Tel:'.$sale['Destination']['tel'].'</tspan>';
				$xml .= '<tspan x="430" dy="0">Fax:'.$sale['Destination']['fax'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="110" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">下記の通り、商品をお届け致しました。ご確認下さいませ。</text>';
				//中央タイトル部
				$xml .= '<text x="1100" y="170" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7" text-anchor="middle">納品書</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="890,190 1310,190"/><polyline points="890,198 1310,198"/></g>';
				//右日付部
				$xml .= '<text x="1430" y="140" font-size="28" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				 $xml .= '<tspan x="1430" dy="0">　売上日:　'.$sale['Sale']['date'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">売上番号:　'.$sale['Sale']['id'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">受注番号:　'.$order_number.'</tspan>';
				$xml .= '<tspan x="1430" dy="45">先様番号:　'.$sale['Sale']['partners_no'].'</tspan>';
				$xml .= '</text>';
				//右テキスト部
				$xml .= '<text x="1450" y="330" font-size="26" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">';
				$xml .= '<tspan x="2000" dy="0">'.INC_NAME_JA.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_POSTCODE.INC_ADDRESS1.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_ADDRESS2.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">Tel:'.INC_TEL.'　　Fax:'.INC_FAX.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">担当:'.$contact1_name.'　　発行:'.$updated_user_name.'</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="1700" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1600,560 2000,560"/></g>';
				//表のヘッダー
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
				$xml .= '<tspan x="330" y="'.$text_y.'">品番</tspan>';
				$xml .= '<tspan x="590" y="'.$text_y.'">Size</tspan>';
				$xml .= '<tspan x="820" y="'.$text_y.'">刻印</tspan>';
				$xml .= '<tspan x="1065" y="'.$text_y.'">上代</tspan>';
				$xml .= '<tspan x="1200" y="'.$text_y.'">数量</tspan>';
				$xml .= '<tspan x="1335" y="'.$text_y.'">単価</tspan>';
				$xml .= '<tspan x="1710" y="'.$text_y.'">備考</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}

    		//本文
    		$params = array(
				'conditions'=>array('Item.id'=>$dateil['item_id']),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
			$item_total_qty = $item_total_qty + $dateil['bid_quantity'];
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="160" y="'.$text_y.'">'.$item['Item']['name'].'</tspan>';
			$xml .= '<tspan x="540" y="'.$text_y.'">'.$dateil['size'].'</tspan>';
			$xml .= '<tspan x="680" y="'.$text_y.'">'.$dateil['marking'].'</tspan>';
			$xml .= '<tspan x="1130" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['ex_bid']).'</tspan>';
			$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end">'.$dateil['bid_quantity'].'</tspan>';
			$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['bid']).'</tspan>';
			$xml .= '<tspan x="1440" y="'.$text_y.'">'.$dateil['sub_remarks'].'</tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($sale['SalesDateil'])){//表のフッター出力
    			/*
    			$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">商品合計</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($sale['Sale']['total']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				*/
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    			$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">消費税</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($sale['Sale']['tax']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">送料</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($sale['Sale']['shipping']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    			$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">調整</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($sale['Sale']['adjustment']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">合計</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end">'.$item_total_qty.'</tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end">'.number_format($sale['Sale']['total']).'</tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + $rect_height * 2;
				$text_y = $text_y + 110;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="100" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="120" dy="0">【備考】'.mb_substr($sale['Sale']['remark'], 0, 90).'</tspan>';
				$xml .= '<tspan x="120" dy="45">'.mb_substr($sale['Sale']['remark'], 90, 96).'</tspan>';
				$xml .= '</text>';
			}
			$page_counter++;
    		if($page_counter == 35){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Sale Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 35 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Sale Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page>';
    	}
    	//物品受領書
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($sale['SalesDateil']);
    	$total_page = ceil($total_page / 35);
    	$item_total_qty = 0;
		foreach($sale['SalesDateil'] as $dateil){
    	if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="250" font-size="32" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="100" dy="0">会社名：'.$Company['Company']['name'].'</tspan>';
				$xml .= '<tspan x="100" dy="45">店舗名：'.$sale['Destination']['name'].'　御中</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="100" y="330" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="0">'.$sale['Destination']['post_code'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$sale['Destination']['district'].$sale['Destination']['address_one'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$sale['Destination']['address_two'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">Tel:'.$sale['Destination']['tel'].'</tspan>';
				$xml .= '<tspan x="430" dy="0">Fax:'.$sale['Destination']['fax'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="110" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">下記の通り、商品をお届け致しました。ご確認下さいませ。</text>';
				//中央タイトル部
				$xml .= '<text x="1100" y="170" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7" text-anchor="middle">物品受領書</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="890,190 1310,190"/><polyline points="890,198 1310,198"/></g>';
				//右日付部
				$xml .= '<text x="1430" y="140" font-size="28" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				 $xml .= '<tspan x="1430" dy="0">　売上日:　'.$sale['Sale']['date'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">売上番号:　'.$sale['Sale']['id'].'</tspan>';
				$xml .= '<tspan x="1430" dy="45">受注番号:　'.$order_number.'</tspan>';
				$xml .= '<tspan x="1430" dy="45">先様番号:　'.$sale['Sale']['partners_no'].'</tspan>';
				$xml .= '</text>';
				//右テキスト部
				$xml .= '<text x="1450" y="330" font-size="26" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">';
				$xml .= '<tspan x="2000" dy="0">'.INC_NAME_JA.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_POSTCODE.INC_ADDRESS1.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_ADDRESS2.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">Tel:'.INC_TEL.'　　Fax:'.INC_FAX.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">担当:'.$contact1_name.'　　発行:'.$updated_user_name.'</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="1700" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1600,560 2000,560"/></g>';
				//表のヘッダー
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
				$xml .= '<tspan x="330" y="'.$text_y.'">品番</tspan>';
				$xml .= '<tspan x="590" y="'.$text_y.'">Size</tspan>';
				$xml .= '<tspan x="820" y="'.$text_y.'">刻印</tspan>';
				$xml .= '<tspan x="1065" y="'.$text_y.'"></tspan>';
				$xml .= '<tspan x="1200" y="'.$text_y.'">数量</tspan>';
				$xml .= '<tspan x="1335" y="'.$text_y.'"></tspan>';
				$xml .= '<tspan x="1710" y="'.$text_y.'">備考</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}
    		//本文
    		$params = array(
				'conditions'=>array('Item.id'=>$dateil['item_id']),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
			$item_total_qty = $item_total_qty + $dateil['bid_quantity'];

			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="160" y="'.$text_y.'">'.$item['Item']['name'].'</tspan>';
			$xml .= '<tspan x="540" y="'.$text_y.'">'.$dateil['size'].'</tspan>';
			$xml .= '<tspan x="680" y="'.$text_y.'">'.$dateil['marking'].'</tspan>';
			$xml .= '<tspan x="1130" y="'.$text_y.'" text-anchor="end"></tspan>';
			$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end">'.$dateil['bid_quantity'].'</tspan>';
			$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end"></tspan>';
			$xml .= '<tspan x="1440" y="'.$text_y.'"></tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($sale['SalesDateil'])){//表のフッター出力
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1065" y="'.$text_y.'" text-anchor="middle">合計</tspan>';
				$xml .= '<tspan x="1230" y="'.$text_y.'" text-anchor="end">'.$item_total_qty.'</tspan>';
				$xml .= '<tspan x="1400" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="380" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="520" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="660" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="980" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1150" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1250" y="'.$rect_y.'" width="170" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1420" y="'.$rect_y.'" width="580" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + $rect_height * 2;
				$text_y = $text_y + 110;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="100" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="120" dy="0">【備考】'.mb_substr($sale['Sale']['remark'], 0, 90).'</tspan>';
				$xml .= '<tspan x="120" dy="45">'.mb_substr($sale['Sale']['remark'], 90, 96).'</tspan>';
				$xml .= '</text>';
				$rect_y = $rect_y + $rect_height * 2;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="235" fill="none" stroke="#808080" stroke-width="1"/>';
				$stamp_y = $text_y + 85;
				$xml .= '<rect x="115" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="295" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="475" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="655" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$stamp_line = $stamp_y + 40;
				$stamp_na1 = $stamp_y + 30;
				$stamp_na2 = $stamp_y + 10;
				$xml .= '<g stroke="#808080" stroke-width="1"><polyline points="115,'.$stamp_line.' 835,'.$stamp_line.'"/>';
				$xml .= '<polyline points="195,'.$stamp_na1.' 205,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="375,'.$stamp_na1.' 385,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="555,'.$stamp_na1.' 565,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="735,'.$stamp_na1.' 745,'.$stamp_na2.'"/>';
				$xml .= '</g>';
			}
			$page_counter++;
    		if($page_counter == 35){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Sale Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 35 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Sale Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}

    	return $xml;
	}


	function InvoicePrint($invoice, $file_name){
		App::import('Model', 'BankAcut');
    	$BankAcutModel = new BankAcut();
		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.]" xmlns:xlink="http://www.w3.org/1999/xlink">';
//pr($invoice);
//exit;
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($invoice['InvoiceDateil']);
    	$total_page = ceil($total_page / 31);

    	$total_items = 0;
    	$total_tax = 0;
    	$total_shipping = 0;
    	$total_adjustment = 0;
    	$total_total = 0;
    	$total_credit = 0;

    	foreach($invoice['InvoiceDateil'] as $dateil){
    		if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="250" font-size="32" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="100" dy="0">'.$invoice['Billing']['name'].'　御中</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="100" y="330" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="0">'.$invoice['Billing']['post_code'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$invoice['Billing']['district'].$invoice['Billing']['address_one'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">'.$invoice['Billing']['address_two'].'</tspan>';
				$xml .= '<tspan x="110" dy="40">Tel:'.$invoice['Billing']['tel'].'</tspan>';
				$xml .= '<tspan x="430" dy="0">Fax:'.$invoice['Billing']['fax'].'</tspan>';
				$xml .= '</text>';
				$xml .= '<text x="110" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">毎度ありがとうございます。下記の通り御請求申し上げます。</text>';
				//中央タイトル部
				if($invoice['Billing']['invoice_type'] = '4'){
					$xml .= '<text x="1000" y="170" font-size="80" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7" text-anchor="middle">請求書不要！！</text>';
				}else{
					$xml .= '<text x="1000" y="170" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7" text-anchor="middle">請求書</text>';
				}
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="790,190 1210,190"/><polyline points="790,198 1210,198"/></g>';
				//右日付部
				$xml .= '<text x="1330" y="140" font-size="28" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				 $xml .= '<tspan x="1330" dy="0">請求書番号:　'.$invoice['Invoice']['id'].'</tspan>';
				$xml .= '<tspan x="1330" dy="40">発　行　日:　'.$invoice['Invoice']['date'].'</tspan>';
				$xml .= '<tspan x="1330" dy="40">締　切　日:　'.$invoice['Invoice']['total_day'].'</tspan>';
				$xml .= '<tspan x="1330" dy="40">御支払期日:　'.$invoice['Invoice']['payment_day'].'</tspan>';
				$xml .= '</text>';
				//右テキスト部
				$xml .= '<text x="1450" y="340" font-size="26" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">';
				$xml .= '<tspan x="2000" dy="0">'.INC_NAME_JA.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_POSTCODE.INC_ADDRESS1.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">'.INC_ADDRESS2.'</tspan>';
				$xml .= '<tspan x="2000" dy="40">Tel:'.INC_TEL.'　　Fax:'.INC_FAX.'</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="1700" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1600,560 2000,560"/></g>';
				//表のヘッダー
				$xml .= '<text x="205" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">前回請求額';
				$xml .= '<tspan x="416" y="'.$text_y.'">前回入金額</tspan>';
				$xml .= '<tspan x="627" y="'.$text_y.'">繰越残高</tspan>';
				$xml .= '<tspan x="838" y="'.$text_y.'">調整額</tspan>';
				$xml .= '<tspan x="1049" y="'.$text_y.'">税抜御買上額</tspan>';
				$xml .= '<tspan x="1260" y="'.$text_y.'">消費税</tspan>';
				$xml .= '<tspan x="1471" y="'.$text_y.'">送料</tspan>';
				$xml .= '<tspan x="1682" y="'.$text_y.'">御買上額合計</tspan>';
				$xml .= '<tspan x="1894" y="'.$text_y.'">今回御請求額</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="311" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="522" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="733" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="944" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1155" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1366" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1577" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1788" y="'.$rect_y.'" width="212" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
				$xml .= '<text x="291" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="end">'.number_format($invoice['Invoice']['previous_invoice']);
				$xml .= '<tspan x="502" y="'.$text_y.'">'.number_format($invoice['Invoice']['previous_deposit']).'</tspan>';
				$xml .= '<tspan x="713" y="'.$text_y.'">'.number_format($invoice['Invoice']['balance_forward']).'</tspan>';
				$xml .= '<tspan x="924" y="'.$text_y.'">'.number_format($invoice['Invoice']['adjustment']).'</tspan>';
				$xml .= '<tspan x="1135" y="'.$text_y.'">'.number_format($invoice['Invoice']['sales']).'</tspan>';
				$xml .= '<tspan x="1346" y="'.$text_y.'">'.number_format($invoice['Invoice']['tax']).'</tspan>';
				$xml .= '<tspan x="1557" y="'.$text_y.'">'.number_format($invoice['Invoice']['shipping']).'</tspan>';
				$xml .= '<tspan x="1768" y="'.$text_y.'">'.number_format($invoice['Invoice']['total']).'</tspan>';
				$xml .= '<tspan x="1980" y="'.$text_y.'">'.number_format($invoice['Invoice']['month_total']).'</tspan>';
				$xml .= '</text>';
				//$other_text = $text_y + 45;
				//$xml .= '<text x="110" y="'.$other_text.'" font-size="21" fill="#333333" font-family="ＭＳ ゴシック">';
				//$xml .= '※送料は御買上額合計に含めて計算しています。';
				//$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="311" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="522" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="733" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="944" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1155" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1366" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1577" y="'.$rect_y.'" width="211" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1788" y="'.$rect_y.'" width="212" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

				$rect_y = $rect_y + ($rect_height *2);
    			$text_y = $text_y + ($rect_height *2);
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
				$xml .= '<tspan x="227" y="'.$text_y.'">日付</tspan>';
				$xml .= '<tspan x="402" y="'.$text_y.'">伝票No.</tspan>';
				$xml .= '<tspan x="577" y="'.$text_y.'">税抜御買上額</tspan>';
				$xml .= '<tspan x="752" y="'.$text_y.'">消費税</tspan>';
				$xml .= '<tspan x="927" y="'.$text_y.'">送料</tspan>';
				$xml .= '<tspan x="1102" y="'.$text_y.'">調整</tspan>';
				$xml .= '<tspan x="1277" y="'.$text_y.'">合計金額</tspan>';
				$xml .= '<tspan x="1452" y="'.$text_y.'">入金額</tspan>';
				$xml .= '<tspan x="1770" y="'.$text_y.'">出荷先</tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="315" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="490" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="665" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="840" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1015" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1365" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1540" y="'.$rect_y.'" width="460" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}

    		//本文
    		$total_items = $total_items + $dateil['sale_items'];
    		$total_tax = $total_tax + $dateil['tax'];
    		$total_shipping = $total_shipping + $dateil['shipping'];
    		$total_adjustment = $total_adjustment + $dateil['adjustment'];
    		$total_total = $total_total + $dateil['sale_total'];
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
			$xml .= '<text x="110" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="227" y="'.$text_y.'" text-anchor="middle">'.$dateil['sale_date'].'</tspan>';
			$xml .= '<tspan x="470" y="'.$text_y.'" text-anchor="end">'.$dateil['id'].'</tspan>';
			$xml .= '<tspan x="645" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['sale_items']).'</tspan>';
			$xml .= '<tspan x="820" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['tax']).'</tspan>';
			$xml .= '<tspan x="995" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['shipping']).'</tspan>';
			$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['adjustment']).'</tspan>';
			$xml .= '<tspan x="1345" y="'.$text_y.'" text-anchor="end">'.number_format($dateil['sale_total']).'</tspan>';
			$xml .= '<tspan x="1560" y="'.$text_y.'">'.mb_substr($dateil['destination_name'], 0, 18).'</tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="315" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="490" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="665" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="840" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1015" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1190" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1365" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1540" y="'.$rect_y.'" width="460" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($invoice['InvoiceDateil'])){//表のフッター出力
    			foreach($invoice['Credit'] as $Credit){
    				if(!empty($Credit['bank_acut_id'])){
    					$params = array(
							'conditions'=>array('BankAcut.id'=>$Credit['bank_acut_id']),
							'recursive'=>0,
						);
						$BankAcut = $BankAcutModel->find('first' ,$params);
						$bank_name = $BankAcut['BankAcut']['name'];
    				}else{
    					$bank_name = '';
    				}
    				$rect_y = $rect_y + $rect_height;
    				$text_y = $text_y + $rect_height;
    				$total_credit = $total_credit + $Credit['reconcile_amount'];
    				$no_counter++;
    				$xml .= '<text x="110" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
					$xml .= '<tspan x="227" y="'.$text_y.'" text-anchor="middle">'.$Credit['date'].'</tspan>';
					$xml .= '<tspan x="1520" y="'.$text_y.'" text-anchor="end">'.number_format($Credit['reconcile_amount']).'</tspan>';
					$xml .= '<tspan x="1560" y="'.$text_y.'">'.mb_substr($bank_name, 0, 18).'</tspan>';
					$xml .= '</text>';
					$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="140" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="315" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="490" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="665" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="840" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1015" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1190" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1365" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1540" y="'.$rect_y.'" width="460" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    			}
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="110" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="227" y="'.$text_y.'" text-anchor="middle"></tspan>';
				$xml .= '<tspan x="402" y="'.$text_y.'" text-anchor="middle">合計</tspan>';
				$xml .= '<tspan x="645" y="'.$text_y.'" text-anchor="end">'.number_format($total_items).'</tspan>';
				$xml .= '<tspan x="820" y="'.$text_y.'" text-anchor="end">'.number_format($total_tax).'</tspan>';
				$xml .= '<tspan x="995" y="'.$text_y.'" text-anchor="end">'.number_format($total_shipping).'</tspan>';
				$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end">'.number_format($total_adjustment).'</tspan>';
				$xml .= '<tspan x="1345" y="'.$text_y.'" text-anchor="end">'.number_format($total_total).'</tspan>';
				$xml .= '<tspan x="1520" y="'.$text_y.'" text-anchor="end">'.number_format($total_credit).'</tspan>';
				$xml .= '<tspan x="1540" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="315" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="490" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="665" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="840" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1015" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1365" y="'.$rect_y.'" width="175" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1540" y="'.$rect_y.'" width="460" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$rect_y = $rect_y + 90;
				$text_y = $text_y + 90;
				$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="100" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="120" dy="0">【備考】'.mb_substr($invoice['Invoice']['remark'], 0, 90).'</tspan>';
				$xml .= '<tspan x="120" dy="45">'.mb_substr($invoice['Invoice']['remark'], 90, 96).'</tspan>';
				$xml .= '</text>';

				$rect_y = $rect_y + $rect_height * 2;
				//$xml .= '<rect x="100" y="'.$rect_y.'" width="1900" height="235" fill="none" stroke="#808080" stroke-width="1"/>';
				$stamp_y = $text_y + 85;
				$xml .= '<rect x="115" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="295" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="475" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="655" y="'.$stamp_y.'" width="180" height="210" fill="none" stroke="#808080" stroke-width="1"/>';
				$stamp_line = $stamp_y + 40;
				$stamp_na1 = $stamp_y + 30;
				$stamp_na2 = $stamp_y + 10;
				$xml .= '<g stroke="#808080" stroke-width="1"><polyline points="115,'.$stamp_line.' 835,'.$stamp_line.'"/>';
				$xml .= '<polyline points="195,'.$stamp_na1.' 205,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="375,'.$stamp_na1.' 385,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="555,'.$stamp_na1.' 565,'.$stamp_na2.'"/>';
				$xml .= '<polyline points="735,'.$stamp_na1.' 745,'.$stamp_na2.'"/>';
				$xml .= '</g>';
				$text_y = $text_y + 110;
				$xml .= '<text x="950" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="950" dy="0">【御振込先】</tspan>';
				$xml .= '<tspan x="950" dy="34">'.BANK1.'</tspan>';
				$xml .= '<tspan x="950" dy="34">'.BANK2.'</tspan>';
				$xml .= '<tspan x="950" dy="34">'.BANK3.'</tspan>';
				$xml .= '</text>';
			}
			$page_counter++;
    		if($page_counter == 31){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Invoice No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 31 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Invoice No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}

    	return $xml;
	}

	function RepairRequest($repairs, $file_name){
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Catalog" xmlns:xlink="http://www.w3.org/1999/xlink">';
    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	//$no_counter = 1;
    	$page_counter = 1;
    	//$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$today = date('Y-m-d');
		//$total_page = count($repairs['TransportDateil']);
    	//$total_page = ceil($total_page / 41);

    	//工場リストを作る
    	$factory_list = array();
    	foreach($repairs as $repair){
    		$factory_list[] = $repair['Factory']['id'];
    	}
    	$factory_list = array_unique($factory_list);

		foreach($factory_list as $factory_id){
			if($page_counter > 1){
				$text_y = 620;
	    		$rect_y = 580;
	    		$rect_height = 55;
	    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Repair Sheet　'.$footer_date.'</text>';
	    		$xml .= '</svg></page>';
	    		$page_counter = 1;
			}
			foreach($repairs as $repair){
				if($repair['Factory']['id'] == $factory_id){
					//要見積の場合は、備考欄に「要見積」と入れる
					$remark = '';
					if($repair['Repair']['estimate_status'] == 1) $remark = '【要見積】';
					//部門名を短くする
					$repair['Section']['name'] = $CleaningComponent->sectionName($repair['Section']['name']);
					//修理内容とお客様名に文字数制限をつける
					$repair['Repair']['repair_content'] = mb_substr($repair['Repair']['repair_content'], 0, 16);
					$repair['Repair']['customer_name'] = mb_substr($repair['Repair']['customer_name'], 0, 8);
					$repair['Repair']['control_number'] = mb_substr($repair['Repair']['control_number'], 0, 10);
					$repair['Repair']['size'] = mb_substr($repair['Repair']['size'], 0, 7);
					$repair['Section']['name'] = mb_substr($repair['Section']['name'], 0, 8);
					if($page_counter == 1){//ヘッダー出力
    					$xml .= '<page>';
    					$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    					//左テキスト部
						$xml .= '<text x="100" y="200" font-size="28" fill="black" font-family="ＭＳ ゴシック">'.$repair['Factory']['name'].'　御中';
						$xml .= '<tspan x="100" dy="40">'.$repair['Factory']['charge_section'].'　'.$repair['Factory']['charge_person'].'　様</tspan>';
						$xml .= '<tspan x="100" dy="75">TEL : '.$repair['Factory']['tel'].'</tspan>';
						$xml .= '<tspan x="100" dy="33">FAX : '.$repair['Factory']['fax'].'</tspan>';
						$xml .= '<tspan x="110" dy="56">いつもお世話になっております。</tspan>';
						$xml .= '<tspan x="110" dy="37">下記のとおり依頼いたしますのでご確認ください。</tspan>';
						$xml .= '<tspan x="110" dy="37">よろしくお願いいたします。</tspan>';
						$xml .= '<tspan x="110" dy="37">尚、商品は右記住所まで発送お願いいたします。</tspan>';
						$xml .= '</text>';
						//中央タイトル部
						$xml .= '<text x="880" y="200" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7">修理依頼書</text>';
						$xml .= '<g stroke="black" stroke-width="3"><polyline points="840,220 1260,220"/><polyline points="840,228 1260,228"/></g>';
						//右部
						$xml .= '<text x="1650" y="160" font-size="26" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
						$xml .= '<tspan x="1650" dy="30">日　付 :　'.$today.'</tspan>';
						$xml .= '</text>';
						$xml .= '<text x="1450" y="290" font-size="26" fill="black" font-family="ＭＳ ゴシック">'.INC_NAME_JA;
						$xml .= '<tspan x="1450" dy="39">〒'.INC_POSTCODE.'　'.INC_ADDRESS1.'</tspan>';
						$xml .= '<tspan x="1450" dy="39">'.INC_ADDRESS2.'</tspan>';
						$xml .= '<tspan x="1450" dy="39">TEL:'.INC_TEL.'　FAX:'.INC_FAX.'</tspan>';
						$xml .= '<tspan x="1450" dy="39">担当:'.REPAIR_PERSON.'</tspan>';
						$xml .= '</text>';
						//表のヘッダー
						$xml .= '<rect x="100" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="240" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="380" y="'.$rect_y.'" width="210" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="590" y="'.$rect_y.'" width="210" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="800" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="900" y="'.$rect_y.'" width="200" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="1100" y="'.$rect_y.'" width="400" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="1500" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<rect x="1680" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
						$xml .= '<text x="170" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">管理番号';
						$xml .= '<tspan x="310" y="'.$text_y.'">受付日</tspan>';
						$xml .= '<tspan x="485" y="'.$text_y.'">店舗名</tspan>';
						$xml .= '<tspan x="695" y="'.$text_y.'">品番</tspan>';
						$xml .= '<tspan x="850" y="'.$text_y.'">サイズ</tspan>';
						$xml .= '<tspan x="1000" y="'.$text_y.'">お客様名</tspan>';
						$xml .= '<tspan x="1280" y="'.$text_y.'">修理内容</tspan>';
						$xml .= '<tspan x="1590" y="'.$text_y.'">工場納期</tspan>';
						$xml .= '<tspan x="1820" y="'.$text_y.'">備考</tspan>';
						$xml .= '</text>';
    				}

	    			//本文
					$rect_y = $rect_y + $rect_height;
	    			$text_y = $text_y + $rect_height;
	    			$repair['Repair']['size'] = str_replace('&', '＆', $repair['Repair']['size']); //&半角&が入ると、印刷できない
	    			$repair['Repair']['customer_name'] = str_replace('&', '＆', $repair['Repair']['customer_name']);
	    			$repair['Repair']['repair_content'] = str_replace('&', '＆', $repair['Repair']['repair_content']);
	    			$xml .= '<rect x="100" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="240" y="'.$rect_y.'" width="140" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="380" y="'.$rect_y.'" width="210" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="590" y="'.$rect_y.'" width="210" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="800" y="'.$rect_y.'" width="100" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="900" y="'.$rect_y.'" width="200" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1100" y="'.$rect_y.'" width="400" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1500" y="'.$rect_y.'" width="180" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<rect x="1680" y="'.$rect_y.'" width="320" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
					$xml .= '<text x="110" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$repair['Repair']['control_number'];
					$xml .= '<tspan x="310" y="'.$text_y.'" text-anchor="middle">'.$repair['Repair']['reception_date'].'</tspan>';
					$xml .= '<tspan x="390" y="'.$text_y.'">'.$repair['Section']['name'].'</tspan>';
					$xml .= '<tspan x="600" y="'.$text_y.'">'.$repair['Item']['name'].'</tspan>';
					$xml .= '<tspan x="810" y="'.$text_y.'">'.$repair['Repair']['size'].'</tspan>';
					$xml .= '<tspan x="910" y="'.$text_y.'">'.$repair['Repair']['customer_name'].'</tspan>';
					$xml .= '<tspan x="1110" y="'.$text_y.'">'.$repair['Repair']['repair_content'].'</tspan>';
					$xml .= '<tspan x="1590" y="'.$text_y.'" text-anchor="middle">'.$repair['Repair']['factory_delivery_date'].'</tspan>';
					$xml .= '<tspan x="1690" y="'.$text_y.'">'.$remark.'</tspan>';
					$xml .= '</text>';

					$page_counter++;
	    			if($page_counter == 41){
	    				$text_y = 620;
	    				$rect_y = 580;
	    				$rect_height = 55;
	    				$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Repair Sheet 　'.$footer_date.'</text>';
	    				$xml .= '</svg></page>';
	    				$page_counter = 1;
	    				//$page++;
	    			}
	    			//$no_counter++;
				}
    		}
		}

		if($page_counter < 41 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] Repair Sheet '.$footer_date.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}

    	return $xml;
	}









































/*
	function SAMPLE($Transport, $file_name){

		$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Catalog" xmlns:xlink="http://www.w3.org/1999/xlink">';

    	$text_y = 620;
    	$rect_y = 580;
    	$rect_height = 55;
    	$no_counter = 1;
    	$page_counter = 1;
    	$page = 1;
		$footer_date = date('Y/m/d(D)H:i:s');
		$total_page = count($Transport['TransportDateil']);
    	$total_page = ceil($total_page / 41);

    	foreach($Transport['TransportDateil'] as $dateil){
    		if($page_counter == 1){//ヘッダー出力
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    			//左テキスト部
    			$xml .= '<text x="100" y="200" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="110" dy="40">左テキストサンプル</tspan>';
				$xml .= '</text>';
				//中央タイトル部
				$xml .= '<text x="880" y="200" font-size="65" fill="black" font-family="ＭＳ ゴシック" letter-spacing="7">SAMPLE</text>';
				$xml .= '<g stroke="black" stroke-width="3"><polyline points="840,220 1260,220"/><polyline points="840,228 1260,228"/></g>';
				//右日付部
				$xml .= '<text x="1650" y="160" font-size="26" fill="black" font-family="ＭＳ ゴシック" letter-spacing="-1">';
				$xml .= '<tspan x="1650" dy="30">日　付 :　</tspan>';
				$xml .= '</text>';
				//右テキスト部
				$xml .= '<text x="1450" y="280" font-size="26" fill="black" font-family="ＭＳ ゴシック">';
				$xml .= '<tspan x="1450" dy="40">右テキストサンプル</tspan>';
				$xml .= '</text>';
				//ページ表示（大）
				$xml .= '<text x="1550" y="545" font-size="35" fill="black" font-family="ＭＳ ゴシック">PAGE　'.$page.' / '.$total_page.'</text>';
				$xml .= '<g stroke="black" stroke-width="2"><polyline points="1450,560 1850,560"/></g>';
				//表のヘッダー
				$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="140" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="440" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="590" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="740" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
    		}

    		//本文
			$rect_y = $rect_y + $rect_height;
    		$text_y = $text_y + $rect_height;
    		$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">'.$no_counter;
			$xml .= '<tspan x="160" y="'.$text_y.'"></tspan>';
			$xml .= '<tspan x="460" y="'.$text_y.'"></tspan>';
			$xml .= '<tspan x="615" y="'.$text_y.'"></tspan>';
			$xml .= '<tspan x="760" y="'.$text_y.'"></tspan>';
			$xml .= '<tspan x="1170" y="'.$text_y.'" text-anchor="end"></tspan>';
			$xml .= '<tspan x="1320" y="'.$text_y.'" text-anchor="end"></tspan>';
			$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end"></tspan>';
			$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
			$xml .= '</text>';
			$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="140" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="440" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="590" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="740" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';

    		if($no_counter == count($Transport['TransportDateil'])){//表のフッター出力
				$rect_y = $rect_y + $rect_height;
    			$text_y = $text_y + $rect_height;
    			$xml .= '<text x="107" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック">';
    			$xml .= '<tspan x="1080" y="'.$text_y.'">合計</tspan>';
				$xml .= '<tspan x="1320" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1470" y="'.$text_y.'" text-anchor="end"></tspan>';
				$xml .= '<tspan x="1510" y="'.$text_y.'"></tspan>';
				$xml .= '</text>';
				$xml .= '<rect x="100" y="'.$rect_y.'" width="940" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1040" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1190" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1340" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
				$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
			}
			$page_counter++;
    		if($page_counter == 41){
    			$text_y = 620;
    			$rect_y = 580;
    			$rect_height = 55;
    			$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] SAMPLE Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$page++;
    		}
    		$no_counter++;
    	}
		if($page_counter < 41 and $page_counter > 1){
    		$xml .= '<text x="1050" y="2920" font-size="24" fill="#333333" font-family="ＭＳ ゴシック" text-anchor="middle">[THE KISS Inc.] SAMPLE Sheet No.　'.$footer_date.'　'.$page.' / '.$total_page.'</text>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}

    	return $xml;
	}
*/
}

	function picklistHead($footer_date, $page_no, $text_y, $rect_y, $rect_height){
		$xml = '<page>';
    	$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    	$xml .= '<text x="100" y="165" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
		$xml .= '<tspan x="100" dy="0">Pick List　[Wholesale]　　Date:'.$footer_date.'　　Page:'.$page_no.'　　</tspan>';
		$xml .= '</text>';
		//表のヘッダー
		$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
		$xml .= '<tspan x="220" y="'.$text_y.'">タイプ</tspan>';
		$xml .= '<tspan x="352" y="'.$text_y.'">番号</tspan>';
		$xml .= '<tspan x="555" y="'.$text_y.'">出荷先</tspan>';
		$xml .= '<tspan x="820" y="'.$text_y.'">倉庫</tspan>';
		$xml .= '<tspan x="1085" y="'.$text_y.'">子品番</tspan>';
		$xml .= '<tspan x="1310" y="'.$text_y.'">納期</tspan>';
		$xml .= '<tspan x="1437" y="'.$text_y.'">数量</tspan>';
		$xml .= '<tspan x="1750" y="'.$text_y.'">備考</tspan>';
		$xml .= '</text>';
		$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="140" y="'.$rect_y.'" width="160" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="300" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="405" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="705" y="'.$rect_y.'" width="230" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="935" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="1235" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="1385" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		return $xml;
	}

	function picklistStoreHead($footer_date, $page_no, $text_y, $rect_y, $rect_height){
		$xml = '<page>';
    	$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    	$xml .= '<text x="100" y="165" font-size="28" fill="black" font-family="ＭＳ ゴシック">';
		$xml .= '<tspan x="100" dy="0">Pick List　[Retail]　　Date:'.$footer_date.'　　Page:'.$page_no.'　　</tspan>';
		$xml .= '</text>';
		//表のヘッダー
		$xml .= '<text x="120" y="'.$text_y.'" font-size="25" fill="black" font-family="ＭＳ ゴシック" text-anchor="middle">No';
		$xml .= '<tspan x="220" y="'.$text_y.'">タイプ</tspan>';
		$xml .= '<tspan x="352" y="'.$text_y.'">番号</tspan>';
		$xml .= '<tspan x="555" y="'.$text_y.'">出荷先</tspan>';
		$xml .= '<tspan x="820" y="'.$text_y.'">倉庫</tspan>';
		$xml .= '<tspan x="1085" y="'.$text_y.'">子品番</tspan>';
		$xml .= '<tspan x="1310" y="'.$text_y.'">納期</tspan>';
		$xml .= '<tspan x="1437" y="'.$text_y.'">数量</tspan>';
		$xml .= '<tspan x="1750" y="'.$text_y.'">備考</tspan>';
		$xml .= '</text>';
		$xml .= '<rect x="100" y="'.$rect_y.'" width="40" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="140" y="'.$rect_y.'" width="160" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="300" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="405" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="705" y="'.$rect_y.'" width="230" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="935" y="'.$rect_y.'" width="300" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="1235" y="'.$rect_y.'" width="150" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="1385" y="'.$rect_y.'" width="105" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		$xml .= '<rect x="1490" y="'.$rect_y.'" width="510" height="'.$rect_height.'" fill="none" stroke="#808080" stroke-width="1"/>';
		return $xml;
	}

?>