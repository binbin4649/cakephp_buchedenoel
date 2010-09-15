<?php
class Invoice extends AppModel {

	var $name = 'Invoice';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Billing' => array(
			'className' => 'Billing',
			'foreignKey' => 'billing_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Credit' => array(
			'className' => 'Credit',
			'foreignKey' => 'invoice_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'InvoiceDateil' => array(
			'className' => 'InvoiceDateil',
			'foreignKey' => 'invoice_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	function searchOne($id){
		App::import('Model', 'Destination');
    	$DestinationModel = new Destination();
		$invoice = $this->read(null, $id);
		foreach($invoice['InvoiceDateil'] as $key=>$Dateil){
			if(!empty($Dateil['destination_id'])){
				$params = array(
					'conditions'=>array('Destination.id'=>$Dateil['destination_id']),
					'recursive'=>0
				);
				$Destination = $DestinationModel->find('first' ,$params);
				$invoice['InvoiceDateil'][$key]['destination_name'] = $Destination['Destination']['name'];
			}else{
				$invoice['InvoiceDateil'][$key]['destination_name'] = '';
			}
		}
		return $invoice;
	}

	//Billingのpayment_dayを入れる。YYYY-MM-DD形式で返す。
	function paymentDay($payment_id){
		$result = payment_day($payment_id);
		return $result;
	}

	function novelInvoice($billing_id){
		$billing_invoices = novel_invoice($billing_id);
		return $billing_invoices;
	}

	function close_sales(){
		App::import('Model', 'Sale');
    	$SaleModel = new Sale();
    	App::import('Model', 'Company');
    	$CompanyModel = new Company();
    	App::import('Model', 'Credit');
    	$CreditModel = new Credit();
    	App::import('Model', 'InvoiceDateil');
    	$InvoiceDateilModel = new InvoiceDateil();
    	//ステータス1,2のインボイスデータを全て抽出
    	$params = array(
			'conditions'=>array('or'=>array(array('Sale.sale_status'=>1), array('Sale.sale_status'=>2))),
			'recursive'=>0
		);
		$sales = $SaleModel->find('all' ,$params);
		$time_now = time();
		$invoice = array();
		foreach($sales as $sale){
			$close_year = (integer)substr($sale['Sale']['total_day'], 0, 4);
			$close_month = (integer)substr($sale['Sale']['total_day'], 5, 2);
			$close_day = (integer)substr($sale['Sale']['total_day'], 8, 2);
			$sime_stamp = mktime(23, 59, 59, $close_month, $close_day, $close_year);
			//締め日が今日の日付を過ぎていたら、次のフェーズへ
			if($sime_stamp <= $time_now){
				//1、請求先が同じで、かつ、印刷前のinvoiceを探す。
				$params = array(
					'conditions'=>array('Company.id'=>$sale['Destination']['company_id']),
					'recursive'=>0
				);
				$Company = $CompanyModel->find('first' ,$params);
				//billing_idが無い場合は、ループを1回抜ける
				if(empty($Company['Company']['billing_id'])) continue;
				$params = array(
					'conditions'=>array('and'=>array('Invoice.billing_id'=>$Company['Company']['billing_id'], 'Invoice.invoice_status'=>1)),
					'recursive'=>0
				);
				$invoice = $this->find('first' ,$params);
				if($invoice){//1、であったらそのinvoice_idを回す。金額加算。
					$invoice_id = $invoice['Invoice']['id'];
					$invoice['Invoice']['sales'] = $invoice['Invoice']['sales'] + $sale['Sale']['item_price_total'];
					$invoice['Invoice']['tax'] = $invoice['Invoice']['tax'] + $sale['Sale']['tax'];
					$invoice['Invoice']['shipping'] = $invoice['Invoice']['shipping'] + $sale['Sale']['shipping'];
					$invoice['Invoice']['adjustment'] = $invoice['Invoice']['adjustment'] + $sale['Sale']['adjustment'];
					$invoice['Invoice']['total'] = $invoice['Invoice']['total'] + $sale['Sale']['total'];
					$invoice['Invoice']['month_total'] = $invoice['Invoice']['month_total'] + $sale['Sale']['total'];
					//一番後日付の締切日を採用する
					$invoice_year = (integer)substr($invoice['Invoice']['total_day'], 0, 4);
					$invoice_month = (integer)substr($invoice['Invoice']['total_day'], 5, 2);
					$invoice_day = (integer)substr($invoice['Invoice']['total_day'], 8, 2);
					$invoice_stamp = mktime(23, 59, 59, $invoice_month, $invoice_day, $invoice_year);
					if($invoice_stamp < $sime_stamp){
						$invoice['Invoice']['total_day'] = $sale['Sale']['total_day'];
					}
					if($this->save($invoice)){
						$this->id = null;
						$invoice = array();
					}else{
						return false;
					}
				}else{//1、で探してなければinvoiceを新規保存
					$invoice['Invoice']['invoice_status'] = 1;
					$invoice['Invoice']['sales'] = $sale['Sale']['item_price_total'];
					$invoice['Invoice']['tax'] = $sale['Sale']['tax'];
					$invoice['Invoice']['shipping'] = $sale['Sale']['shipping'];
					$invoice['Invoice']['adjustment'] = $sale['Sale']['adjustment'];
					$invoice['Invoice']['total'] = $sale['Sale']['total'];
					$invoice['Invoice']['section_id'] = $sale['Depot']['section_id'];
					$invoice['Invoice']['billing_id'] = $Company['Company']['billing_id'];
					$invoice['Invoice']['payment_day'] = payment_day($Company['Billing']['payment_day']);
					$invoice['Invoice']['date'] = date('Y-m-d');
					$invoice['Invoice']['total_day'] = $sale['Sale']['total_day'];
					//invoiceがはいっておらず、かつ、請求先が同じ入金データを探す
					$params = array(
						'conditions'=>array('and'=>array(
							'Credit.invoice_id'=>0,
							'Credit.billing_id'=>$Company['Company']['billing_id'],
						)),
						'recursive'=>0
					);
					$credits = $CreditModel->find('all' ,$params);
					if($credits){//該当する入金を全部足す
						$total_credit = 0;
						foreach($credits as $credit){
							$total_credit = $total_credit + $credit['Credit']['reconcile_amount'];
						}
					}else{//該当する入金が無かったら、入金額0
						$total_credit = 0;
					}
					//前回の請求書を探す
					$billing_invoices = novel_invoice($Company['Company']['billing_id']);
					if($billing_invoices){
						$billing_invoice = array_shift($billing_invoices);
						/*
						//前回請求に対する入金を探す。入金入力時に請求書番号を指定させるタイプ
						$params = array(
							'conditions'=>array('Credit.invoice_id'=>$billing_invoice['Invoice']['id']),
							'recursive'=>0
						);
						$credits = $CreditModel->find('all' ,$params);
						//機関指定で入金を探すタイプ
						$start_day = payment_start_day($Company['Billing']['payment_day'], $sale['Sale']['total_day']);
						$params = array(
							'conditions'=>array('and'=>array(
								'Credit.date <='=>$sale['Sale']['total_day'],
								'Credit.date >='=>$start_day,
							)),
							'recursive'=>0
						);
						*/
						//入金を請求書に載せたことを、invoice_idに入れることで判断するタイプ
						$invoice['Invoice']['previous_invoice'] = $billing_invoice['Invoice']['month_total'];
						$invoice['Invoice']['balance_forward'] = $billing_invoice['Invoice']['month_total'] - $total_credit;
						$invoice['Invoice']['month_total'] = $sale['Sale']['total'] + $invoice['Invoice']['balance_forward'];
					}else{//前回のデータが無ければ0を入れて新規保存
						$invoice['Invoice']['previous_invoice'] = 0;
						if($total_credit >= 1){
							$invoice['Invoice']['balance_forward'] = 0 - $total_credit;
							$invoice['Invoice']['month_total'] = $sale['Sale']['total'] - $total_credit;
						}else{
							$invoice['Invoice']['balance_forward'] = 0;
							$invoice['Invoice']['month_total'] = $sale['Sale']['total'];
							$credits = false;
						}
					}
					$invoice['Invoice']['previous_deposit'] = $total_credit;
					if($this->save($invoice)){
						$invoice_id = $this->getInsertID();
						$this->id = null;
						$invoice = array();
						//creditに入金を請求書に載せたよ！！っていう印でinvoice_idを入れる
						if($credits){
							$credit = array();
							foreach($credits as $credit){
								if($credit['Credit']['reconcile_amount'] >= 1){
									$credit['Credit']['invoice_id'] = $invoice_id;
									$CreditModel->save($credit);
									$CreditModel->id = null;
								}
							}
						}
					}else{
						return false;
					}
				}
				//detailを追加
				$InvoiceDateil = array();
				$InvoiceDateil['InvoiceDateil']['invoice_id'] = $invoice_id;
				$InvoiceDateil['InvoiceDateil']['sale_id'] = $sale['Sale']['id'];
				$InvoiceDateil['InvoiceDateil']['sale_date'] = $sale['Sale']['date'];
				$InvoiceDateil['InvoiceDateil']['sale_total'] = $sale['Sale']['total'];
				$InvoiceDateil['InvoiceDateil']['sale_items'] = $sale['Sale']['item_price_total'];
				$InvoiceDateil['InvoiceDateil']['tax'] = $sale['Sale']['tax'];
				$InvoiceDateil['InvoiceDateil']['shipping'] = $sale['Sale']['shipping'];
				$InvoiceDateil['InvoiceDateil']['adjustment'] = $sale['Sale']['adjustment'];
				$InvoiceDateil['InvoiceDateil']['destination_id'] = $sale['Sale']['destination_id'];
				if($InvoiceDateilModel->save($InvoiceDateil)){
					$InvoiceDateilModel->id = null;
					$InvoiceDateil = array();
					$sale['Sale']['sale_status'] = 3;
					$SaleModel->save($sale);
					$SaleModel->id = null;
				}else{
					return false;
				}
			}//締め日かどうかのチェックifおわり
		}//salesのforeachおわり
		//消費税計算単位が請求単位だった場合の処理
		//インボイス明細のなかで消費税が入っていない明細があったら、それだけの商品合計を足して、消費税を計算する。
		//送料、調整は前段階のtotalで計算済み。であると見なしている。
		$params = array(
			'conditions'=>array('Invoice.invoice_status'=>1),
			'recursive'=>1
		);
		$Invoices = $this->find('all' ,$params);
		foreach($Invoices as $key=>$Invoice){
			$totalCal = array();
			$save_invoice = array();
			$totalCal['items'] = 0;
			foreach($Invoice['InvoiceDateil'] as $dateil){
				if($dateil['tax'] < 1 or empty($dateil['tax'])){
					$totalCal['items'] =  $totalCal['items'] + $dateil['sale_items'];
				}
			}
			if($totalCal['items'] > 1){//消費税が計算されていない商品金額があったら計算して、集計する
				$tax_fraction = $Invoice['Billing']['tax_fraction'];
				$tax = $totalCal['items'] * TAX_RATE / 100;
    			if($tax_fraction == '1' or empty($tax_fraction)) $tax = floor($tax);//消費税、切り捨て
    			if($tax_fraction == '2') $tax = ceil($tax);//消費税、切り上げ
    			if($tax_fraction == '3') $tax = round($tax);//消費税、四捨五入
    			//$Invoices[$key]['Invoice']['tax'] = $Invoice['Invoice']['tax'] + $tax;
    			//$Invoices[$key]['Invoice']['total'] = $Invoice['Invoice']['total'] + $tax;
    			$save_invoice['Invoice']['id'] = $Invoice['Invoice']['id'];
    			$save_invoice['Invoice']['tax'] = $Invoice['Invoice']['tax'] + $tax;
    			$save_invoice['Invoice']['total'] = $Invoice['Invoice']['total'] + $tax;
    			$save_invoice['Invoice']['month_total'] = $save_invoice['Invoice']['total'] + $Invoice['Invoice']['balance_forward'];
    			$this->save($save_invoice);
    			$this->id = null;
			}else{//請求金額を集計


			}
		}
		return true;
	}

	//締め日の計算
	function totalDay($total_id){
		$date_array = total_day($total_id);
		return $date_array;
	}

}//クラス終わり

//締め日の計算 
//8/31 $total_id から destination_id に変更
function total_day($total_id){
	/*
	App::import('Model', 'Destination');
    $DestinationModel = new Destination();
    $params = array(
		'conditions'=>array('Destination.id'=>$destination_id),
		'recursive'=>0
	);
    $Destination = $DestinationModel->find('first' ,$params);
	pr($Destination);
	exit;
	*/
	App::import('Component', 'DateCal');
   	$DateCalComponent = new DateCalComponent();
   	$result = array();
   	$this_year = date('Y');
	$this_month = date('m');
	$this_day = date('d');
	if(!empty($total_id)){
		if($total_id == 1){
			$day = $DateCalComponent->last_day($this_year, $this_month);
			$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$day);
		}elseif($total_id == 2){
			if($this_day <= 5){
				$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>5);
			}else{
				$nextdate = $DateCalComponent->next_date($this_year, $this_month);
				$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>5);
			}
		}elseif($total_id == 3){
			if($this_day <= 10){
				$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>10);
			}else{
				$nextdate = $DateCalComponent->next_date($this_year, $this_month);
				$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>10);
			}
		}elseif($total_id == 4){
			if($this_day <= 15){
				$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>15);
			}else{
				$nextdate = $DateCalComponent->next_date($this_year, $this_month);
				$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>15);
			}
		}elseif($total_id == 5){
			if($this_day <= 20){
				$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>20);
			}else{
				$nextdate = $DateCalComponent->next_date($this_year, $this_month);
				$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>20);
			}
		}elseif($total_id == 6){
			if($this_day <= 25){
				$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>25);
			}else{
				$nextdate = $DateCalComponent->next_date($this_year, $this_month);
				$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>25);
			}
		}else{
			$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$this_day);
		}
	}else{
		$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$this_day);
	}
	return $result;
}

//回収日の計算
function payment_day($payment_id){
	App::import('Component', 'DateCal');
   	$DateCalComponent = new DateCalComponent();
   	$result = array();
   	$this_year = date('Y');
	$this_month = date('m');
	$this_day = date('d');
	if(!empty($payment_id)){
		if($payment_id == 1){//当月末
			$day = $DateCalComponent->last_day($this_year, $this_month);
			$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$day);
		}elseif($payment_id == 2){//翌月末
			$nextdate = $DateCalComponent->next_date($this_year, $this_month);
			$day = $DateCalComponent->last_day($nextdate['year'], $nextdate['month']);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>$day);
		}elseif($payment_id == 3){//翌々月末
			$nextdate = $DateCalComponent->next_next_date($this_year, $this_month);
			$day = $DateCalComponent->last_day($nextdate['year'], $nextdate['month']);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>$day);
		}elseif($payment_id == 4){//翌月5日
			$nextdate = $DateCalComponent->next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>5);
		}elseif($payment_id == 5){//翌月10日
			$nextdate = $DateCalComponent->next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>10);
		}elseif($payment_id == 6){//翌月15日
			$nextdate = $DateCalComponent->next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>15);
		}elseif($payment_id == 7){//翌月20日
			$nextdate = $DateCalComponent->next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>20);
		}elseif($payment_id == 8){//翌月25日
			$nextdate = $DateCalComponent->next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>25);
		}elseif($payment_id == 9){//翌々月5日
			$nextdate = $DateCalComponent->next_next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>5);
		}elseif($payment_id == 10){//翌々月10日
			$nextdate = $DateCalComponent->next_next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>10);
		}elseif($payment_id == 11){//翌々月15日
			$nextdate = $DateCalComponent->next_next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>15);
		}elseif($payment_id == 12){//翌々月20日
			$nextdate = $DateCalComponent->next_next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>20);
		}elseif($payment_id == 13){//翌々月25日
			$nextdate = $DateCalComponent->next_next_date($this_year, $this_month);
			$result = array('year'=>$nextdate['year'], 'month'=>$nextdate['month'], 'day'=>25);
		}else{
			$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$this_day);
		}
	}else{
		$result = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$this_day);
	}
	return $result;
}

//締め日のスタート日を返す
function payment_start_day($payment_id, $payment_date){
	App::import('Component', 'DateCal');
   	$DateCalComponent = new DateCalComponent();
   	$result = array();
	$year = substr($payment_date, 0, 4);
	$month = substr($payment_date, 5, 2);
	$day = substr($payment_date, 8, 2);
	$prev = $DateCalComponent->prev_month($year, $month);
	if($payment_id == 1){
		$result = $year.'-'.$month.'-01';
	}elseif($payment_id == 2){
		$result = $prev['year'].'-'.$prev['month'].'-06';
	}elseif($payment_id == 3){
		$result = $prev['year'].'-'.$prev['month'].'-11';
	}elseif($payment_id == 4){
		$result = $prev['year'].'-'.$prev['month'].'-16';
	}elseif($payment_id == 5){
		$result = $prev['year'].'-'.$prev['month'].'-21';
	}elseif($payment_id == 6){
		$result = $prev['year'].'-'.$prev['month'].'-26';
	}else{
		$result = $payment_date;
	}
	return $result;
}

//最新のインボイスを返す
function novel_invoice($billing_id){
	App::import('Model', 'Invoice');
    $InvoiceModel = new Invoice();
    $params = array(
		'conditions'=>array('and'=>array(
			'Invoice.billing_id'=>$billing_id,
			'Invoice.invoice_status <>'=>4
		)),
		'recursive'=>0,
		'order'=>array('Invoice.created'=>'desc'),
		'limit'=>50
	);
	$billing_invoices = $InvoiceModel->find('all' ,$params);
	return $billing_invoices;
}

?>