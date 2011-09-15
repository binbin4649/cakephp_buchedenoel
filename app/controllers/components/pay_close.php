<?php

class PayCloseComponent extends Object {
	var $components = array('DateCal');

	function paysClose($ac, $id){
		App::import('Model', 'Purchase');
    	$PurchaseModel = new Purchase();
    	App::import('Model', 'Factory');
    	$FactoryModel = new Factory();
    	App::import('Model', 'Pay');
    	$PayModel = new Pay();
		$params = array(
			//'conditions'=>array('Purchase.purchase_status'=>2),
			'conditions'=>array('OR'=>array(
				array('Purchase.purchase_status'=>2),
				array('Purchase.purchase_status'=>5)
				)),
			'recursive'=>0,
		);
		$Purchases = $PurchaseModel->find('all' ,$params);
		
		//20110902 ORで返品もfindできたが、途中で無効になるのかな？ 最終結果にでてこない。
		
		foreach($Purchases as $Purchase){
			$purchase_year = (integer)substr($Purchase['Purchase']['date'], 0, 4);
			$purchase_month = (integer)substr($Purchase['Purchase']['date'], 5, 2);
			$purchase_day = (integer)substr($Purchase['Purchase']['date'], 8, 2);
			$pay_jugement = false;
			switch($Purchase['Factory']['total_day']){
				case 1://毎月末締め
					$sime_day = $this->DateCal->last_day($purchase_year, $purchase_month);
					$sime_stamp = mktime(23, 59, 59, $purchase_month, $sime_day, $purchase_year);
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
				case 2://毎月5日締め
					if($purchase_day <= 5){
						$sime_stamp = mktime(23, 59, 59, $purchase_month, 5, $purchase_year);
					}else{
						$next_date = $this->DateCal->next_date($purchase_year, $purchase_month);
						$sime_stamp = mktime(23, 59, 59, $next_date['month'], 5, $next_date['year']);
					}
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
				case 3://毎月10日締め
					if($purchase_day <= 10){
						$sime_stamp = mktime(23, 59, 59, $purchase_month, 10, $purchase_year);
					}else{
						$next_date = $this->DateCal->next_date($purchase_year, $purchase_month);
						$sime_stamp = mktime(23, 59, 59, $next_date['month'], 10, $next_date['year']);
					}
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
				case 4://毎月15日締め
					if($purchase_day <= 15){
						$sime_stamp = mktime(23, 59, 59, $purchase_month, 15, $purchase_year);
					}else{
						$next_date = $this->DateCal->next_date($purchase_year, $purchase_month);
						$sime_stamp = mktime(23, 59, 59, $next_date['month'], 15, $next_date['year']);
					}
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
				case 5://毎月20日締め
					if($purchase_day <= 20){
						$sime_stamp = mktime(23, 59, 59, $purchase_month, 20, $purchase_year);
					}else{
						$next_date = $this->DateCal->next_date($purchase_year, $purchase_month);
						$sime_stamp = mktime(23, 59, 59, $next_date['month'], 20, $next_date['year']);
					}
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
				case 6://毎月25日締め
					if($purchase_day <= 25){
						$sime_stamp = mktime(23, 59, 59, $purchase_month, 25, $purchase_year);
					}else{
						$next_date = $this->DateCal->next_date($purchase_year, $purchase_month);
						$sime_stamp = mktime(23, 59, 59, $next_date['month'], 25, $next_date['year']);
					}
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
				case 99://随時
					$sime_stamp = mktime();
					$pay_jugement = true;
					break;
				default://毎月締め払い
					$sime_day = $this->DateCal->last_day($purchase_year, $purchase_month);
					$sime_stamp = mktime(23, 59, 59, $purchase_month, $sime_day, $purchase_year);
					if($sime_stamp < mktime())$pay_jugement = true;
					break;
			}
			switch($Purchase['Factory']['payment_day']){
				case 1:
					$last_day = $this->DateCal->last_day($purchase_year, $purchase_month);
					$payment_day = array('year'=>$purchase_year, 'month'=>$purchase_month, 'day'=>$last_day);
					break;
				case 2:
					$next_date = $this->DateCal->next_date($purchase_year, $purchase_month);
					$last_day = $this->DateCal->last_day($next_date['year'], $next_date['month']);
					$payment_day = array('year'=>$next_date['year'], 'month'=>$next_date['month'], 'day'=>$last_day);
					break;
				case 3:
					$next_date = $this->DateCal->next_next_date($purchase_year, $purchase_month);
					$last_day = $this->DateCal->last_day($next_date['year'], $next_date['month']);
					$payment_day = array('year'=>$next_date['year'], 'month'=>$next_date['month'], 'day'=>$last_day);
					break;
				case 98:
					$payment_day = array('year'=>date('Y',$sime_stamp), 'month'=>date('m',$sime_stamp), 'day'=>date('d',$sime_stamp));
					break;
				case 99:
					$payment_day = array('year'=>date('Y',$sime_stamp), 'month'=>date('m',$sime_stamp), 'day'=>date('d',$sime_stamp));
					break;
				default://翌々月末払い
					$next_date = $this->DateCal->next_next_date($purchase_year, $purchase_month);
					$last_day = $this->DateCal->last_day($next_date['year'], $next_date['month']);
					$payment_day = array('year'=>$next_date['year'], 'month'=>$next_date['month'], 'day'=>$last_day);
					break;
			}
			$total_day = date('Y-m-d', $sime_stamp);
			if($ac == 'doing' and $Purchase['Purchase']['id'] == $id) $pay_jugement = true;
			//if($Purchase['Purchase']['total'] < 0) $pay_jugement = false;
			if(empty($Purchase['Purchase']['total'])) $pay_jugement = false;
			if($pay_jugement){
				$params = array(
					'conditions'=>array('and'=>array(
						'Pay.factory_id'=>$Purchase['Factory']['id'],
						'Pay.pay_status'=>1
					)),
					'recursive'=>0,
				);
				$pay_check = $PayModel->find('first' ,$params);
				$pay = array();
				if($pay_check){
					//payを編集saveする
					$pay['id'] = $pay_check['Pay']['id'];
					$pay_id = $pay_check['Pay']['id'];
					$pay['total'] = $pay_check['Pay']['total'] + $Purchase['Purchase']['total'];
					$pay['tax'] = $pay_check['Pay']['tax'] + $Purchase['Purchase']['total_tax'];
					$pay['adjustment'] = $pay_check['Pay']['adjustment'] + $Purchase['Purchase']['adjustment'];
					$PayModel->save($pay);
					$PayModel->id = null;
				}else{
					//payを新規saveする
					$pay['factory_id'] = $Purchase['Factory']['id'];
					$pay['pay_status'] = 1;
					$pay['total'] = $Purchase['Purchase']['total'];
					$pay['tax'] = $Purchase['Purchase']['total_tax'];
					$pay['adjustment'] = $Purchase['Purchase']['adjustment'];
					$pay['total_day'] = $total_day;
					$pay['payment_day'] = $payment_day;
					$PayModel->save($pay);
					$PayModel->id = null;
					$pay_id = $PayModel->getInsertID();
				}
				//Purchaseにpay_idを保存し、ステータスを締め済みに変更
				//$Purchases = $PurchaseModel->find('all' ,$params);
				$purcha['Purchase']['pay_id'] = $pay_id;
				$purcha['Purchase']['id'] = $Purchase['Purchase']['id'];
				$purcha['Purchase']['purchase_status'] = 3;
				$PurchaseModel->save($purcha);
				$PurchaseModel->id = null;
			}
		}//
		//payのステータスが1のものを、全て2に変え、消費税が請求単位の計算をして保存して終了
		$params = array(
			'conditions'=>array('Pay.pay_status'=>1),
			'recursive'=>0,
		);
		$pay_checks = $PayModel->find('all' ,$params);
		foreach($pay_checks as $pay_check){
			$pay = array();
			$params = array(
				'conditions'=>array('Factory.id'=>$pay_check['Pay']['factory_id']),
				'recursive'=>0,
			);
			$factory = $FactoryModel->find('first' ,$params);
			if($factory['Factory']['tax_method'] == 4){
				$tax_fraction = $factory['Factory']['tax_fraction'];
				//請求単位にまとめて消費税を計算
				$tax = $pay_check['Pay']['total'] * TAX_RATE / 100;
    			if($tax_fraction == '1' or empty($tax_fraction)) $tax = floor($tax);//消費税、切り捨て
    			if($tax_fraction == '2') $tax = ceil($tax);//消費税、切り上げ
    			if($tax_fraction == '3') $tax = round($tax);//消費税、四捨五入
    			$pay['tax'] = $tax;
    			$pay['total'] = $pay_check['Pay']['total'] + $tax;
			}
			$pay['id'] = $pay_check['Pay']['id'];
			$pay['pay_status'] = 2;
			$PayModel->save($pay);
			$PayModel->id = null;
		}
	}

}

?>