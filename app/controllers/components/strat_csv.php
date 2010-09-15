<?php
class StratCsvComponent extends Object {

	//旧システムＮｏと売上日を受け取り、Ｎｏと期間が一致したらuser_idを返す
	function oldContact($old_no, $old_date){
		App::import('Model', 'User');
    	$UserModel = new User();
		$sale_date = strtotime($old_date);
    	if(!empty($old_no)){
    		$params = array(
				'conditions'=>array('User.old_system_no'=>$old_no),
				'recursive'=>0,
			);
			$user = $UserModel->find('first' ,$params);
			if(!empty($user['User']['old_system_start'])){
				$start_date = strtotime($user['User']['old_system_start']);
				if($start_date > $sale_date){
					$user = false;
				}
			}
			if(!$user){
				$params = array(
					'conditions'=>array('and'=>array('User.old_system_no2'=>$old_no, 'User.old_system_start2 <='=>$old_date)),
					'recursive'=>0,
				);
				$user = $UserModel->find('first' ,$params);
				if(!empty($user['User']['old_system_start2'])){
					$start_date = strtotime($user['User']['old_system_start2']);
					if($start_date > $sale_date){
						$user = false;
					}
				}
			}
			if($user){
				return $user['User']['id'];
			}
    	}
		return null;
	}

	/*
	function oldContact($old_no, $old_date){
		App::import('Model', 'User');
    	$UserModel = new User();

    	if(!empty($old_no)){
    		$params = array(
				'conditions'=>array('and'=>array('User.old_system_no'=>$old_no, 'User.old_system_start <='=>$old_date)),
				'recursive'=>0,
			);
			$user = $UserModel->find('first' ,$params);
			if(!$user){
				$params = array(
					'conditions'=>array('and'=>array('User.old_system_no2'=>$old_no, 'User.old_system_start2 <='=>$old_date)),
					'recursive'=>0,
				);
				$user = $UserModel->find('first' ,$params);
			}
			if($user){
				return $user['User']['id'];
			}
    	}
		return null;
	}
	*/

	//客注品番だった場合trueを返す
	function selectCustom($jan){
		if($jan == '9000000274006') return true;
		if($jan == '9000000261006') return true;
		if($jan == '9000000262003') return true;
		if($jan == '9000000263000') return true;
		if($jan == '9000000264007') return true;
		if($jan == '9000000266001') return true;
		if($jan == '9000000267008') return true;
		if($jan == '9000000265004') return true;
		if($jan == '9000000268005') return true;
		if($jan == '9000000269002') return true;
		if($jan == '9000000256002') return true;
		if($jan == '9000000270008') return true;
		if($jan == '9000000271005') return true;
		if($jan == '9000000272002') return true;
		if($jan == '9000000273009') return true;
		if($jan == '9000000198005') return true;
		return false;
	}

	//合計金額をほにゃららする

	function totalMoth($row, $status){
		//12/24　初期値追加。意味不明なエラーのため
		$total = 0;
		$item_price_total = 0;
		$tax = 0;
		$bid = 0;
		$bid_quantity = 0;
		$cost = 0;
		$dateil_tax = 0;
		$ex_bid = 0;
		$total_cost = 0;
		//売上金額が0だった場合、自社定価に数量を掛けて入れる
		if($row[69] == 0){
			$total = (int)$row[65] * (int)$row[63];
		}else{
			$total = (int)$row[69];
		}
		//本体価格が0だった場合、自社定価を税抜きにして、数量を掛けて入れる
		if($row[67] == 0){
			$item_price_total = (((int)$row[65] * 100) / (100 + TAX_RATE)) * (int)$row[63];
			$ex_bid = (((int)$row[65] * 100) / (100 + TAX_RATE));
		}else{
			$item_price_total = (int)$row[67] * (int)$row[63];
			$ex_bid = (int)$row[67];
		}
		//内消費税が0だった場合、自社定価から消費税を計算して、数量を掛けて入れる
		if($row[70] == 0){
			$tax = ((int)$row[65] - (((int)$row[65] * 100) / (100 + TAX_RATE))) * (int)$row[63];
		}else{
			$tax = $row[70];
		}
		//売上単価が0だった場合、自社定価を入れる
		if($row[66] == 0){
			$bid = (int)$row[65];
		}else{
			$bid = (int)$row[66];
		}
		//消費税が0だった場合、自社定価から消費税を計算して入れる
		if($row[68] == 0){
			$dateil_tax = ((int)$row[65] - (((int)$row[65] * 100) / (100 + TAX_RATE)));
		}else{
			$dateil_tax = (int)$row[68];
		}

		$bid_quantity = (int)$row[63];
		$cost = (int)$row[71];
		$total_cost = (int)$row[72];
		//赤伝の場合は、全てマイナスにする
		if($status == 4){
			$total = '-'.$total;
			$item_price_total = '-'.$item_price_total;
			$tax = '-'.$tax;
			$bid = '-'.$bid;
			$bid_quantity = '-'.$bid_quantity;
			$cost = '-'.$cost;
			$dateil_tax = '-'.$dateil_tax;
			$ex_bid = '-'.$ex_bid;
			$total_cost = '-'.$total_cost;
		}

		return array(
			'total'=>$total,
			'item_price_total'=>$item_price_total,
			'tax'=>$tax,
			'bid'=>$bid,
			'bid_quantity'=>$bid_quantity,
			'cost'=>$cost,
			'dateil_tax'=>$dateil_tax,
			'ex_bid'=>$ex_bid,
			'total_cost'=>$total_cost,
		);
	}

    function masterDump($modelname, $value){
    	$id = '';
    	App::import('Model', $modelname);
    	$model = new $modelname();
    	if(!empty($value)){
    		$params = array(
				'conditions'=>array($modelname.'.name'=>$value),
				'recursive'=>0
			);
			$result = $model->find('first' ,$params);
			if(!$result){
				$params = array(
					'conditions'=>array($modelname.'.old_name'=>$value),
					'recursive'=>0
				);
				$result = $model->find('first' ,$params);
			}
			if($result){
				$id = $result[$modelname]['id'];
			}else{
				$save_data = array($modelname=>array(
					'name'=>$value,
					'old_name'=>$value,
				));
				$model->save($save_data);
				$model->id = null;
				$id = $model->getInsertID();
			}
    	}
        return $id;
    }


    function baseRelease($id){

    	switch($id){//リリース日
			case '0':
				$itembase2 = array('year'=>'2000', 'month'=>'01', 'day'=>'01');
				break;
			case '1':
				$itembase2 = array('year'=>'2005', 'month'=>'11', 'day'=>'01');
				break;
			case '2':
				$itembase2 = array('year'=>'2000', 'month'=>'01', 'day'=>'01');
				break;
			case '3':
				$itembase2 = array('year'=>'2006', 'month'=>'03', 'day'=>'01');
				break;
			case '4':
				$itembase2 = array('year'=>'2000', 'month'=>'07', 'day'=>'01');
				break;
			case '5':
				$itembase2 = array('year'=>'2006', 'month'=>'09', 'day'=>'01');
				break;
			case '6':
				$itembase2 = array('year'=>'2007', 'month'=>'03', 'day'=>'01');
				break;
			case '7':
				$itembase2 = array('year'=>'2007', 'month'=>'07', 'day'=>'01');
				break;
			case '8':
				$itembase2 = array('year'=>'2007', 'month'=>'09', 'day'=>'01');
				break;
			case '9':
				$itembase2 = array('year'=>'2007', 'month'=>'11', 'day'=>'01');
				break;
			case '10':
				$itembase2 = array('year'=>'2008', 'month'=>'03', 'day'=>'01');
				break;
			case '11':
				$itembase2 = array('year'=>'2008', 'month'=>'07', 'day'=>'01');
				break;
			case '12':
				$itembase2 = array('year'=>'2008', 'month'=>'11', 'day'=>'01');
				break;
			case '13':
				$itembase2 = array('year'=>'2009', 'month'=>'03', 'day'=>'01');
				break;
			case '14':
				$itembase2 = array('year'=>'2009', 'month'=>'07', 'day'=>'01');
				break;
			default:
				$itembase2 = array('year'=>'2000', 'month'=>'01', 'day'=>'01');
				break;
		}
		return $itembase2;
    }

    function baseItemType($id){
   		switch($id){//アイテムタイプ　タグ
			case '22':
				$itembase3 = '99';
				break;
			case '31':
				$itembase3 = '3';
				break;
			case '15':
				$itembase3 = '4';
				break;
			case '36':
				$itembase3 = '3';
				break;
			case '35':
				$itembase3 = '3';
				break;
			case '37':
				$itembase3 = '3';
				break;
			case '38':
				$itembase3 = '3';
				break;
			case '32':
				$itembase3 = '3';
				break;
			case '39':
				$itembase3 = '3';
				break;
			case '34':
				$itembase3 = '3';
				break;
			case '7':
				$itembase3 = '11';
				break;
			case '30':
				$itembase3 = '99';
				break;
			case '40':
				$itembase3 = '3';
				break;
			case '45':
				$itembase3 = '8';
				break;
			case '27':
				$itembase3 = '9';
				break;
			case '29':
				$itembase3 = '1';
				break;
			case '43':
				$itembase3 = '4';
				break;
			case '16':
				$itembase3 = '10';
				break;
			case '18':
				$itembase3 = '3';
				break;
			case '42':
				$itembase3 = '1';
				break;
			case '3':
				$itembase3 = '2';
				break;
			case '1':
				$itembase3 = '2';
				break;
			case '4':
				$itembase3 = '2';
				break;
			case '46':
				$itembase3 = '2';
				break;
			case '20':
				$itembase3 = '2';
				break;
			case '21':
				$itembase3 = '99';
				break;
			case '17':
				$itembase3 = '5';
				break;
			case '8':
				$itembase3 = '6';
				break;
			case '44':
				$itembase3 = '4';
				break;
			case '41':
				$itembase3 = '4';
				break;
			case '28':
				$itembase3 = '1';
				break;
			case '5':
				$itembase3 = '1';
				break;
			case '2':
				$itembase3 = '1';
				break;
			case '6':
				$itembase3 = '1';
				break;
			case '23':
				$itembase3 = '1';
				break;
			case '33':
				$itembase3 = '1';
				break;
			case '19':
				$itembase3 = '1';
				break;
			case '24':
				$itembase3 = '99';
				break;
			default:
				$itembase3 = '';
				break;
		}
		return $itembase3;
    }

    function baseSex($id){
    	switch($id){
    		case 'Ladys':
    			$value = '1';
    			break;
    		case 'Mens':
    			$value = '2';
    			break;
    		default:
    			$value = '5';
    			break;
    	}
    	return $value;
    }

    function baseProcess($id){
    	switch($id){
    		case '2':
    			$value = '1';
    			break;
    		case '63':
    			$value = '3';
    			break;
    		case '65':
    			$value = '6';
    			break;
    		case '32':
    			$value = '4';
    			break;
    		case '36':
    			$value = '5';
    			break;
    		case '1':
    			$value = '2';
    			break;
    		case '64':
    			$value = '8';
    			break;
    		case '62':
    			$value = '7';
    			break;
    		case '61':
    			$value = '9';
    			break;
    		case '19':
    			$value = '10';
    			break;
    		case '33':
    			$value = '11';
    			break;
    		case '9':
    			$value = '2';
    			break;
    		case '7':
    			$value = '12';
    			break;
    		case '23':
    			$value = '13';
    			break;
    		case '21':
    			$value = '14';
    			break;
    		case '4':
    			$value = '15';
    			break;
    		case '5':
    			$value = '16';
    			break;
    		case '3':
    			$value = '17';
    			break;
    		default:
    			$value = '';
    			break;
       }
       return $value;
    }

    function baseTransApprove($foo){
    	switch($foo){
    		case '不可':
    			$value = '2';
    			break;
    		case '可':
    			$value = '1';
    			break;
    		default:
    			$value = '2';
    			break;
    	}
    	return $value;
    }

    function baseInChain($hinban, $kojou){
    	$hinban_check = true;
    	$kojou_check = true;
    	if($hinban == '---') $hinban_check = false;
    	if($hinban == '0') $hinban_check = false;
    	if(empty($hinban)) $hinban_check = false;
    	//if($hinban == 0) $check = false;
    	if($kojou == '2') $kojou_check = false;
    	if($kojou == '0') $kojou_check = false;

    	$value = '';
    	if($hinban_check) $value .= $hinban;

    	if($kojou_check){
    		switch($kojou){
    			case '4':
    				$value .= 'AGポイント';
    				break;
    			case '6':
    				$value .= 'アトリエ・オドー';
    				break;
    			case '3':
    				$value .= 'ナナコ';
    				break;
    			case '8':
    				$value .= 'ニバコレクション';
    				break;
    			case '1':
    				$value .= 'ユナイト';
    				break;
    			case '5':
    				$value .= '光彩工芸';
    				break;
    			case '7':
    				$value .= '三和精密工業';
    				break;
    		}
    	}
    	return $value;

    }

    function baseSalesStateCode($id){
    	switch($id){
    		case '17':
    			$value = '4';
    			break;
    		case '14':
    			$value = '2';
    			break;
    		case '16':
    			$value = '4';
    			break;
    		case '1':
    			$value = '1';
    			break;
    		case '20':
    			$value = '1';
    			break;
    		case '18':
    			$value = '4';
    			break;
    		case '3':
    			$value = '3';
    			break;
    		case '10':
    			$value = '5';
    			break;
    		case '9':
    			$value = '6';
    			break;
    		case '12':
    			$value = '7';
    			break;
    		case '13':
    			$value = '8';
    			break;
    		case '4':
    			$value = '9';
    			break;
    		case '19':
    			$value = '9';
    			break;
    		default:
    			$value = '10';
    			break;
    	}
    	return $value;
    }

    function baseAtelierTransApprove($foo){
    	switch($foo){
    		case '可':
    			$value = '1';
    			break;
    		case '不可':
    			$value = '2';
    			break;
    		default:
    			$value = '2';
    			break;
    	}
    	return $value;
    }

    function baseUnit($id){
    	switch($id){
    		case '4':
    			$value = '99';
    			break;
    		case '7':
    			$value = '5';
    			break;
    		case '6':
    			$value = '6';
    			break;
    		case '1':
    			$value = '1';
    			break;
    		case '5':
    			$value = '2';
    			break;
    		case '3':
    			$value = '4';
    			break;
    		case '2':
    			$value = '3';
    			break;
    		default:
    			$value = '99';
    			break;
    	}
    	return $value;
    }

    function sjSubItemName($foo, $itemname){
    	$result = false;
    	if($foo == '01')$result=true;
    	if($foo == '02')$result=true;
    	if($foo == '03')$result=true;
    	if($foo == '04')$result=true;
    	if($foo == '05')$result=true;
    	if($foo == '06')$result=true;
    	if($foo == '07')$result=true;
    	if($foo == '08')$result=true;
    	if($foo == '09')$result=true;
    	if($foo == '10')$result=true;
    	if($foo == '11')$result=true;
    	if($foo == '12')$result=true;
    	if($foo == '13')$result=true;
    	if($foo == '14')$result=true;
    	if($foo == '15')$result=true;
    	if($foo == '16')$result=true;
    	if($foo == '17')$result=true;
    	if($foo == '18')$result=true;
    	if($foo == '19')$result=true;
    	if($foo == '20')$result=true;
    	if($foo == '21')$result=true;
    	if($foo == '22')$result=true;
    	if($foo == '23')$result=true;
    	if($foo == '24')$result=true;
    	if($foo == '25')$result=true;
    	if($foo == '26')$result=true;
    	if($foo == '27')$result=true;
    	if($foo == '28')$result=true;
    	if($foo == '29')$result=true;
    	if($foo == '30')$result=true;
    	if($foo == '31')$result=true;
    	if($foo == '32')$result=true;
    	if($foo == '33')$result=true;
    	if($foo == '34')$result=true;
    	if($foo == '35')$result=true;

    	if($result){
    		$out = $itemname.'-'.$foo;
    	}else{
    		$out = $itemname;
    	}
    	return $out;
    }

    function baseBasicSize($id){
    	switch($id){
    		case '33':
    			$value = '#1～13';
    			break;
    		case '37':
    			$value = '#11～21';
    			break;
    		case '39':
    			$value = '#11～23 偶数可';
    			break;
    		case '62':
    			$value = '#17～21';
    			break;
    		case '38':
    			$value = '#5～15 偶数可';
    			break;
    		case '40':
    			$value = '#5～23 偶数可';
    			break;
    		case '42':
    			$value = '#6～14 偶数可';
    			break;
    		case '41':
    			$value = '#7～13 偶数可';
    			break;
    		case '36':
    			$value = '#7～17';
    			break;
    		case '52':
    			$value = '17.5cm';
    			break;
    		case '55':
    			$value = '17cm';
    			break;
    		case '18':
    			$value = '18cm';
    			break;
    		case '18':
    			$value = '18cm 調整可';
    			break;
    		case '43':
    			$value = '20cm';
    			break;
    		case '19':
    			$value = '21cm';
    			break;
    		case '22':
    			$value = '22cm';
    			break;
    		case '44':
    			$value = '24cm';
    			break;
    		case '53':
    			$value = '38cm';
    			break;
    		case '4':
    			$value = '40cm';
    			break;
    		case '13':
    			$value = '40cm&50cm Set';
    			break;
    		case '49':
    			$value = '40cm 調整可';
    			break;
    		case '65':
    			$value = '43cm';
    			break;
    		case '26':
    			$value = '45cm';
    			break;
    		case '51':
    			$value = '45cm 調整可';
    			break;
    		case '56':
    			$value = '48cm';
    			break;
    		case '5':
    			$value = '50cm';
    			break;
    		case '64':
    			$value = '55cm';
    			break;
    		case '66':
    			$value = '60cm';
    			break;
    		case '16':
    			$value = 'Ladysサイズ';
    			break;
    		case '15':
    			$value = 'Mサイズ';
    			break;
    		case '17':
    			$value = 'Mensサイズ';
    			break;
    		case '21':
    			$value = 'RegularSize ZIPPO';
    			break;
    		case '14':
    			$value = 'Sサイズ';
    			break;
    		case '20':
    			$value = 'SmallSize ZIPPO';
    			break;
    		case '30':
    			$value = '#1～15';
    			break;
    		case '7':
    			$value = '#1～7';
    			break;
    		case '32':
    			$value = '#11～21';
    			break;
    		case '3':
    			$value = '#13～21';
    			break;
    		case '58':
    			$value = '#14～25 偶数可';
    			break;
    		case '28':
    			$value = '#15～19';
    			break;
    		case '12':
    			$value = '#15～21';
    			break;
    		case '27':
    			$value = '#3～13';
    			break;
    		case '23':
    			$value = '#3～21';
    			break;
    		case '11':
    			$value = '#3～5';
    			break;
    		case '72':
    			$value = '#5～13';
    			break;
    		case '57':
    			$value = '#5～13 偶数可';
    			break;
    		case '2':
    			$value = '#7～13';
    			break;
    		case '59':
    			$value = '#7～13 偶数可';
    			break;
    		case '29':
    			$value = '#7～15';
    			break;
    		case '1':
    			$value = '#7～21';
    			break;
    		case '47':
    			$value = '#8～12 偶数のみ';
    			break;
    		case '60':
    			$value = '#8～13 偶数可';
    			break;
    		default:
    			$value = '';
    			break;
    	}
    	return $value;
    }

    function baseOrderSize($id){
    	switch($id){
    		case '71':
    			$value = '#1～14 偶数可';
    			break;
    		case '69':
    			$value = '#11～21 奇数のみ';
    			break;
    		case '72':
    			$value = '#2～14 偶数可';
    			break;
    		case '73':
    			$value = '#5～13 奇数のみ';
    			break;
    		case '37':
    			$value = '#1～13 奇数のみ';
    			break;
    		case '44':
    			$value = '#1～15 奇数のみ';
    			break;
    		case '52':
    			$value = '#1～15 偶数可';
    			break;
    		case '26':
    			$value = '#1～17 偶数可';
    			break;
    		case '15':
    			$value = '#1～21 偶数可';
    			break;
    		case '66':
    			$value = '#1～7 奇数のみ';
    			break;
    		case '16':
    			$value = '#1～7 偶数可';
    			break;
    		case '13':
    			$value = '#11～22 偶数可';
    			break;
    		case '65':
    			$value = '#11～23 奇数のみ';
    			break;
    		case '54':
    			$value = '#11～23 偶数可';
    			break;
    		case '43':
    			$value = '#11～25 偶数可';
    			break;
    		case '58':
    			$value = '#11～21 偶数可';
    			break;
    		case '59':
    			$value = '#11～22 偶数可';
    			break;
    		case '34':
    			$value = '#13～21 奇数のみ';
    			break;
    		case '63':
    			$value = '#13～21 偶数可';
    			break;
    		case '35':
    			$value = '#13～23 偶数可';
    			break;
    		case '42':
    			$value = '#15～19 偶数可';
    			break;
    		case '64':
    			$value = '#15～21 偶数可';
    			break;
    		case '32':
    			$value = '#15～21 奇数のみ';
    			break;
    		case '70':
    			$value = '#3～15 偶数可';
    			break;
    		case '49':
    			$value = '#3～21 偶数可';
    			break;
    		case '20':
    			$value = '#3～25 偶数可';
    			break;
    		case '75':
    			$value = '#3～27 奇数のみ';
    			break;
    		case '14':
    			$value = '#3～27 偶数可';
    			break;
    		case '6':
    			$value = '#3～29 奇数のみ';
    			break;
    		case '3':
    			$value = '#3～29 偶数可';
    			break;
    		case '2':
    			$value = '#3～30 偶数可';
    			break;
    		case '38':
    			$value = '#3～5 奇数のみ';
    			break;
    		case '19':
    			$value = '#3～5 偶数可';
    			break;
    		case '74':
    			$value = '#5～13 奇数のみ';
    			break;
    		case '12':
    			$value = '#5～14 偶数可';
    			break;
    		case '76':
    			$value = '#5～15 奇数のみ';
    			break;
    		case '36':
    			$value = '#5～15 偶数可';
    			break;
    		case '39':
    			$value = '#5～17 偶数可';
    			break;
    		case '4':
    			$value = '#5～21 奇数のみ';
    			break;
    		case '28':
    			$value = '#5～21 偶数可';
    			break;
    		case '11':
    			$value = '#5～22 偶数可';
    			break;
    		case '9':
    			$value = '#5～23 偶数可';
    			break;
    		case '41':
    			$value = '#5～23 奇数のみ';
    			break;
    		case '67':
    			$value = '#5～24 偶数可';
    			break;
    		case '18':
    			$value = '#5～25 偶数可';
    			break;
    		case '68':
    			$value = '#5～25 奇数のみ';
    			break;
    		case '40':
    			$value = '#5～27 偶数可';
    			break;
    		case '62':
    			$value = '#5～27 奇数のみ';
    			break;
    		case '56':
    			$value = '#6～13 偶数可';
    			break;
    		case '57':
    			$value = '#6～14 偶数可';
    			break;
    		case '55':
    			$value = '#6～21 偶数可';
    			break;
    		case '5':
    			$value = '#6～22 偶数可';
    			break;
    		case '30':
    			$value = '#6～23 偶数可';
    			break;
    		case '24':
    			$value = '#7～13 偶数可';
    			break;
    		case '31':
    			$value = '#7～13 奇数のみ';
    			break;
    		case '53':
    			$value = '#7～15 奇数のみ';
    			break;
    		case '25':
    			$value = '#7～15 偶数可';
    			break;
    		case '46':
    			$value = '#7～17 奇数のみ';
    			break;
    		case '22':
    			$value = '#7～17 偶数可';
    			break;
    		case '17':
    			$value = '#7～19 偶数可';
    			break;
    		case '10':
    			$value = '#7～21 奇数のみ';
    			break;
    		case '7':
    			$value = '#7～21 偶数可';
    			break;
    		case '8':
    			$value = '#7～22 偶数可';
    			break;
    		case '47':
    			$value = '#7～23 偶数可';
    			break;
    		case '61':
    			$value = '#7～23 奇数のみ';
    			break;
    		case '45':
    			$value = '#7～27 偶数可';
    			break;
    		case '50':
    			$value = '#7～28 偶数可';
    			break;
    		case '48':
    			$value = '#8～16 偶数可';
    			break;
    		case '60':
    			$value = '#9,11,17,19のみ';
    			break;
    		case '33':
    			$value = '#9～13 奇数のみ';
    			break;
    		case '21':
    			$value = '#9～13 偶数可';
    			break;
    		case '23':
    			$value = '#9～15 偶数可';
    			break;
    		default:
    			$value = '不可';
    			break;
    	}
    	return $value;
    }

function baseMajorSize($id){
    	switch($id){
    		case '#1':
    			$value = '#1';
    			break;
    		case '#3':
    			$value = '#3';
    			break;
    		case '#5':
    			$value = '#5';
    			break;
    		case '#7':
    			$value = '#7';
    			break;
    		case '#9':
    			$value = '#9';
    			break;
    		case '#11':
    			$value = '#11';
    			break;
    		case '#13':
    			$value = '#13';
    			break;
    		case '#15':
    			$value = '#15';
    			break;
    		case '#17':
    			$value = '#17';
    			break;
    		case '#19':
    			$value = '#19';
    			break;
    		case '#21':
    			$value = '#21';
    			break;
    		case '40cm':
    			$value = '40cm';
    			break;
    		case '50cm':
    			$value = '50cm';
    			break;
    		default:
    			$value = 'other';
    			break;
    	}
    	return $value;
    }

//旧の商品紹介からだせるCSVを読み込む
function sj2bsnItemCsv($path, $file_name){
	App::import('Model', 'Item');
    $ItemModel = new Item();
    App::import('Model', 'Subitem');
    $SubitemModel = new Subitem();
    App::import('Model', 'Stock');
    $StockModel = new Stock();
    
    $sj_file_stream = file_get_contents($path.$file_name);
	$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
	$sj_rename_opne = fopen($path.$file_name, 'w');
	$result = fwrite($sj_rename_opne, $sj_file_stream);
	fclose($sj_rename_opne);
    
	$sj_opne = fopen($path.$file_name, 'r');
	$csv_header = fgetcsv($sj_opne);
	
	while($sj_row = fgetcsv($sj_opne)){
		$item_remark = '';//リマーク　よく分からないものは、ココにぶち込む
		$item_secret_remark = '';//シークレットリマーク　さらによく分からないものはここへ
		//$tags = array();
		$item_stone_other = '';
		$item_stone_spec = '';
		$item_message_stamp = '';
		$item_message_stamp_ja = '';
		$item_weight = '';
		$item_demension = '';

		$subitem_jan = $sj_row[0];//JAN
		$item_title = trim($sj_row[1]);//品名
		$item_name = trim($sj_row[3]);//品番
		$subitem_sub_name = substr($sj_row[4], 1, 2);//サイズ　：3桁の数字を2桁にする
		//$subitem_size = trim($sj_row[5]);伝票印刷用に、メジャーサイズを創設
		$subitem_minority_size = '';
		$subitem_major_size = $this->baseMajorSize(trim($sj_row[5]));
		if($subitem_major_size == 'other'){
			$subitem_minority_size = trim($sj_row[5]);
		}
		//$pre_sj10 = mb_convert_kana($sj_row[10], 'K', 'UTF-8');
		//$tags[] = $this->StratCsv->masterDump('Tag', $pre_sj10);//タグのid
		$subitem_name_kana = $sj_row[12];//ルース名　半角カナ　subitemに入れる
		$sj12_zen = mb_convert_kana($subitem_name_kana, 'K', 'UTF-8');
		$item_stone_id = $this->masterDump('Stone', $sj12_zen);//ルースのid
		$item_material_id = $this->masterDump('Material', $sj_row[14]);//マテリアルのid
		$item_price = floor($sj_row[26]);//上代 切捨て整数化floor
		$subitem_cost = floor($sj_row[29]);//仕入単価
		$item_cost = floor($sj_row[32]);//在庫原価
		if($subitem_cost == 0) $subitem_cost = $item_cost;
		if(!empty($sj_row[36])){
			$pre_sj36 = mb_convert_kana($sj_row[36], 'K', 'UTF-8');
		}else{
			$pre_sj36 = '';
		}
		$item_factory_id = $this->masterDump('Factory', $pre_sj36);//工場のid
		if($sj_row[73] == 'Mauloa') $sj_row[73] = 'Kapio';//Mauloaを無理やりKapioに変える
		if($item_title == 'ハワイアン雑貨') $sj_row[73] = 'Kapio';//タイトルが「ハワイアン雑貨」だったら、ブランドを無理やりKapioに変える
		if($sj_row[36] == 'ﾕﾆｵﾝｸﾗﾌﾄ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ﾚﾉﾝ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ｱﾄﾘｴ･ｵﾄﾞｰ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ｴﾝﾄﾘｰ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ｷﾞﾝﾔｲｯﾌﾟｳﾄﾞｳ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ﾅｶｶﾞﾜｿｳｼﾝｸﾞｺｳｷﾞｮｳ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ｽﾍﾟｰｽｸﾘｴｰﾀｰ') $sj_row[73] = 'SELECT';
		if($sj_row[36] == 'ﾊﾟｳﾞｪｷｶｸ') $sj_row[73] = 'SELECT';

		$item_brand_id = $this->masterDump('Brand', $sj_row[73]);//ブランドのid
		//$subitem_name = $this->StratCsv->sjSubItemName($sj_row[4], $item_name);
		$subitem_name = $this->sjSubItemName($subitem_sub_name, $item_name);
		//$subitem_name = $item_name.'-'.$subitem_sub_name;//subitemの品番
		$params = array(
			'conditions'=>array('Item.name'=>$item_name),
			'recursive'=>0
		);
		$find_item = $ItemModel->find('first' ,$params);
		if($find_item){//あったときの処理　次にsubitemを探す
			$item_id = $find_item['Item']['id'];
			$params = array(
				'conditions'=>array('Subitem.jan'=>$subitem_jan),
				'recursive'=>0
			);
			$find_subitem = $SubitemModel->find('first' ,$params);
			if($find_subitem){
				
			}else{
				$save_subitem = array('Subitem'=>array(
					'name'=>$subitem_name,
					'item_id'=>$item_id,
					'major_size'=>$subitem_major_size,
					'minority_size'=>$subitem_minority_size,
					'name_kana'=>$subitem_name_kana,
					'jan'=>$subitem_jan,
					'cost'=>$subitem_cost,
				));
				$SubitemModel->save($save_subitem);
				$subitem_id = $SubitemModel->getInsertID();
				if($find_item['Item']['stock_code'] == '3'){
					$StockModel->Plus($subitem_id, 910, 1, 1135, 1);
				}
				$SubitemModel->id = null;
			}

		}else{//itemが無かった時の処理
			//アニバは単品管理に変える
			if($item_brand_id == 10 or $item_brand_id == 11 or $item_brand_id == 12){
				$stock_code = 3;
			}else{
				$stock_code = 1;
			}
			$save_item = array('Item'=>array(
				'name'=>$item_name,
				'stone_id'=>$item_stone_id,
				'material_id'=>$item_material_id,
				'price'=>$item_price,
				'cost'=>$item_cost,
				'factory_id'=>$item_factory_id,
				'brand_id'=>$item_brand_id,
				'title'=>$item_title,
				'stock_code'=>$stock_code,
			));
			$ItemModel->save($save_item);
			$item_id = $ItemModel->getInsertID();
			$ItemModel->id = null;
			
			$save_subitem = array('Subitem'=>array(
				'name'=>$subitem_name,
				'item_id'=>$item_id,
				'major_size'=>$subitem_major_size,
				'minority_size'=>$subitem_minority_size,
				'name_kana'=>$subitem_name_kana,
				'jan'=>$subitem_jan,
				'cost'=>$subitem_cost,
			));
			$SubitemModel->save($save_subitem);
			$subitem_id = $SubitemModel->getInsertID();
			if($stock_code == '3'){
				$StockModel->Plus($subitem_id, 910, 1, 1135, 1);
			}
			$SubitemModel->id = null;
		}
	}
	return unlink($path.$file_name);
}


}
?>