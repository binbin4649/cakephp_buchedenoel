<?php
class SalesController extends AppController {
	var $name = 'Sales';
	var $uses = array('Sale', 'SalesDateil', 'Subitem', 'OrdersSale', 'Order', 'OrderDateil', 'Stock', 'Depot', 'Item', 'Destination');
	var $components = array('Selector', 'Print', 'Total',  'StratCsv');

	function index() {
		$modelName = 'Sale';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['depot'])){
				$this->data[$modelName]['depot'] = mb_convert_kana($this->data[$modelName]['depot'], 'a', 'UTF-8');
				$this->data[$modelName]['depot'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['depot']);//半角数字以外削除
				$conditions[] = array('and'=>array('Depot.id'=>$this->data[$modelName]['depot']));
				//$conditions[] = array('and'=>array('Depot.name LIKE'=>'%'.$this->data[$modelName]['depot'].'%'));
			}
			if(!empty($this->data[$modelName]['destination'])){
				$conditions[] = array('and'=>array('Destination.id'=>$this->data[$modelName]['destination']));
			}
			if(!empty($this->data[$modelName]['sale_type'])){
				$conditions[] = array('and'=>array('Sale.sale_type'=>$this->data[$modelName]['sale_type']));
			}
			if(!empty($this->data[$modelName]['sale_status'])){
				$conditions[] = array('and'=>array('Sale.sale_status'=>$this->data[$modelName]['sale_status']));
			}
			if(!empty($this->data[$modelName]['id'])){
				$this->data[$modelName]['id'] = mb_convert_kana($this->data[$modelName]['id'], 'a', 'UTF-8');
				$this->data[$modelName]['id'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['id']);//半角数字以外削除
				$conditions[] = array('and'=>array('Sale.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['start_date']['year']) and !empty($this->data[$modelName]['start_date']['month']) and !empty($this->data[$modelName]['start_date']['day'])){
				$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'];
				$conditions[] = array('and'=>array('Sale.date >='=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_date']['year']) and !empty($this->data[$modelName]['end_date']['month']) and !empty($this->data[$modelName]['end_date']['day'])){
				$end_date = $this->data[$modelName]['end_date']['year'].'-'.$this->data[$modelName]['end_date']['month'].'-'.$this->data[$modelName]['end_date']['day'];
				$conditions[] = array('and'=>array('Sale.date <='=>$end_date));
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>100,
				'order'=>array('Sale.created'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>array('and'=>array('Sale.sale_status <>'=>7, 'Sale.destination_id <>'=>null)),
				'limit'=>100,
				'order'=>array('Sale.created'=>'desc')
			);
		}
		$this->Sale->recursive = 0;
		$sale = $this->paginate();
		$total_total = 0;
		foreach($sale as $value){
			$total_total = $total_total + $value['Sale']['total'];
		}
		$this->set('sales', $sale);
		$sale_type = get_sale_type();
		$order_type = get_order_type();
		$sale_status = get_sale_status();
		$this->set(compact('sale_type', 'order_type', 'sale_status', 'total_total'));
	}

	function store_index() {
		$modelName = 'Sale';
		$conditions = array();
		if (!empty($this->data)) {
			if(!empty($this->data[$modelName]['depot'])){
				$this->data[$modelName]['depot'] = mb_convert_kana($this->data[$modelName]['depot'], 'a', 'UTF-8');
				$this->data[$modelName]['depot'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['depot']);//半角数字以外削除
				$conditions[] = array('and'=>array('Depot.id'=>$this->data[$modelName]['depot']));
			}
			//$conditions[] = array('and'=>array('Depot.name LIKE'=>'%'.$this->data[$modelName]['depot'].'%'));
			if(!empty($this->data[$modelName]['contact1'])){
				$conditions[] = array('and'=>array('Sale.contact1'=>$this->data[$modelName]['contact1']));
			}
			if(!empty($this->data[$modelName]['sale_status'])){
				$conditions[] = array('and'=>array('Sale.sale_status'=>$this->data[$modelName]['sale_status']));
			}
			if(!empty($this->data[$modelName]['id'])){
				$this->data[$modelName]['id'] = mb_convert_kana($this->data[$modelName]['id'], 'a', 'UTF-8');
				$this->data[$modelName]['id'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['id']);//半角数字以外削除
				$conditions[] = array('and'=>array('Sale.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['start_date']['year']) and !empty($this->data[$modelName]['start_date']['month']) and !empty($this->data[$modelName]['start_date']['day'])){
				$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'];
				$conditions[] = array('and'=>array('Sale.date >='=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_date']['year']) and !empty($this->data[$modelName]['end_date']['month']) and !empty($this->data[$modelName]['end_date']['day'])){
				$end_date = $this->data[$modelName]['end_date']['year'].'-'.$this->data[$modelName]['end_date']['month'].'-'.$this->data[$modelName]['end_date']['day'];
				$conditions[] = array('and'=>array('Sale.date <='=>$end_date));
			}
			$conditions[] = array('and'=>array('Sale.sale_type <>'=>1));
		}else{
			$this->data[$modelName]['start_date']['year'] = date('Y');
			$this->data[$modelName]['start_date']['month'] = date('m');
			$this->data[$modelName]['start_date']['day'] = date('d');
			$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'];
			$conditions[] = array('and'=>array('Sale.date >='=>$start_date));
			//部門のデフォルト倉庫を入れる
			$params = array(
				'conditions'=>array('Section.id'=>$this->Auth->user('section_id')),
				'recursive'=>0,
			);
			$userSection = $this->Section->find('first' ,$params);
			if(!empty($userSection['Section']['default_depot'])){
				$this->data[$modelName]['depot'] = $userSection['Section']['default_depot'];
				$conditions[] = array('and'=>array('Sale.depot_id'=>$userSection['Section']['default_depot']));
			}
			$conditions[] = array('and'=>array('Sale.sale_type <>'=>1, 'Sale.destination_id'=>null));
		}
		$this->Sale->recursive = 0;
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>100,
			'order'=>array('Sale.created'=>'desc'),
		);
		$sale = $this->paginate();

		$total_total = 0;
		foreach($sale as $key=>$value){
			if($value['Sale']['sale_type'] != 3){
				$total_total = $total_total + $value['Sale']['total'];
			}
			$params = array(
				'conditions'=>array('User.id'=>$value['Sale']['contact1']),
				'recursive'=>0,
			);
			$sale[$key]['User'] = $this->User->find('first' ,$params);
		}
		$this->set('sales', $sale);
		$sale_type = get_sale_type();
		$order_type = get_order_type();
		$sale_status = get_sale_status();
		$this->set(compact('sale_type', 'order_type', 'sale_status', 'total_total'));
	}

	function red($id = null){
		if(!empty($this->data)){
			$id = $this->data['Sale']['id'];
			$front_sale = $this->Sale->searchOne($id);
			//マイナス金額のSaleを今日の日付で登録する
			$Sale = $front_sale;
			$Sale['Sale']['sale_status'] = 4;
			//$Sale['Sale']['date'] = date('Y-m-d');
			$Sale['Sale']['date'] = $this->data['Sale']['date'];
			$Sale['Sale']['total'] = '-'.$Sale['Sale']['total'];
			$Sale['Sale']['item_price_total'] = '-'.$Sale['Sale']['item_price_total'];
			if($Sale['Sale']['tax'] > 0) $Sale['Sale']['tax'] = '-'.$Sale['Sale']['tax'];
			if($Sale['Sale']['shipping'] > 0) $Sale['Sale']['shipping'] = '-'.$Sale['Sale']['shipping'];
			if($Sale['Sale']['adjustment'] > 0) $Sale['Sale']['adjustment'] = '-'.$Sale['Sale']['adjustment'];
			if($Sale['Sale']['adjustment'] < 0) $Sale['Sale']['adjustment'] = str_replace('-', '', $Sale['Sale']['adjustment']);
			if(!empty($Sale['Sale']['total_day'])) $Sale['Sale']['total_day'] = '';
			$Sale['Sale']['created_user'] = $this->Auth->user('id');
			$Sale['Sale']['return_id'] = $Sale['Sale']['id'];
			$Sale['Sale']['id'] = '';
			if($this->Sale->save($Sale)){
				$sale_id = $this->Sale->getInsertID();
				$this->Sales->id = null;
				//請求前の売上は取消に変える
				if($front_sale['Sale']['sale_status'] == 1 or $front_sale['Sale']['sale_status'] == 2){
					$back_sale['Sale']['id'] = $Sale['Sale']['return_id'];
					$back_sale['Sale']['return_id'] = $sale_id;
					$back_sale['Sale']['sale_status'] = 5;
					$this->Sale->save($back_sale);
				}else{//請求前以外の場合はステータスは変えずに、赤伝のIDだけ登録する
					$back_sale['Sale']['id'] = $Sale['Sale']['return_id'];
					$back_sale['Sale']['return_id'] = $sale_id;
					$this->Sale->save($back_sale);
				}
			}else{
				$this->Session->setFlash('ERROR:sales_controller 140');
				$this->redirect(array('action'=>'view/'.$id));
			}
			$SalesDateil = array();
			foreach($Sale['SalesDateil'] as $dateil){
				$SalesDateil['SalesDateil'] = $dateil;
				$SalesDateil['SalesDateil']['sale_id'] = $sale_id;
				$SalesDateil['SalesDateil']['bid'] = '-'.$SalesDateil['SalesDateil']['bid'];
				$SalesDateil['SalesDateil']['bid_quantity'] = '-'.$SalesDateil['SalesDateil']['bid_quantity'];
				if($SalesDateil['SalesDateil']['cost'] > 0) $SalesDateil['SalesDateil']['cost'] = '-'.$SalesDateil['SalesDateil']['cost'];
				if($SalesDateil['SalesDateil']['tax'] > 0) $SalesDateil['SalesDateil']['tax'] = '-'.$SalesDateil['SalesDateil']['tax'];
				if($SalesDateil['SalesDateil']['ex_bid'] > 0) $SalesDateil['SalesDateil']['ex_bid'] = '-'.$SalesDateil['SalesDateil']['ex_bid'];
				$SalesDateil['SalesDateil']['created_user'] = $this->Auth->user('id');
				$SalesDateil['SalesDateil']['id'] = '';
				if($this->SalesDateil->save($SalesDateil)){
					$this->SalesDateil->id = null;
					//Stock->Plus　ステータスを赤伝で
					$this->Stock->Plus($dateil['subitem_id'], $Sale['Sale']['depot_id'], $dateil['bid_quantity'], $this->Auth->user('id'), 5);
					$SalesDateil = array();
				}else{
					$this->Session->setFlash('ERROR:sales_controller 158');
					$this->redirect(array('action'=>'view/'.$id));
				}
			}
			$this->Session->setFlash('赤伝を登録しました。');
			$this->redirect(array('action'=>'view/'.$sale_id));
		}
		if($id != null){
			$this->set('sale', $this->Sale->searchOne($id));
			$sale_type = get_sale_type();
			$order_type = get_order_type();
			$sale_status = get_sale_status();
			$this->set(compact('sale_type', 'order_type', 'sale_status'));
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Sale.', true));
			$this->redirect(array('action'=>'index'));
		}
		$view = $this->Sale->searchOne($id);
		$this->set('sale', $view);
		$sale_type = get_sale_type();
		$order_type = get_order_type();
		$sale_status = get_sale_status();
		$this->set(compact('sale_type', 'order_type', 'sale_status'));
		if(!empty($view['Sale']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/sale-print/'.$view['Sale']['print_file'].'.php';
			$print_out['file'] = $view['Sale']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
	}

	function sale_print($id = null){
		$params = array(
			'conditions'=>array('Sale.id'=>$id),
			'recursive'=>1,
		);
		$sale = $this->Sale->find('first' ,$params);
		$sale['Sale']['updated_user'] = $this->Auth->user('id');
		$file_name = 'sale_print'.$id.'-'.date('Ymd-His');
		$path = WWW_ROOT.'/files/sale-print/';
		$print_xml = $this->Print->SalePrint($sale, $file_name);
		file_put_contents($path.$file_name.'.php', $print_xml);
		$sale['Sale']['id'] = $id;
		$sale['Sale']['print_file'] = $file_name;
		$sale['Sale']['sale_status'] = 2;
		$this->Sale->save($sale);
		$this->redirect(array('action'=>'view/'.$id));
	}

	function add($ac = null , $id = null) {
		if($this->Session->check('SaleJan.detail.depot')){
			$depot_id = $this->Session->read('SaleJan.detail.depot');
		}elseif(!empty($this->data['Sale']['depot'])){
			$depot_id = $this->data['Sale']['depot'];
		}
		if(!empty($this->params['form']['input1'])){
			$params = array(
				'conditions'=>array('Subitem.jan'=>$this->params['form']['input1']),
				'recursive'=>0
			);
			$this->Subitem->unbindModel(array('belongsTo'=>array('Process', 'Material')));
			$subitem = $this->Subitem->find('first' ,$params);
			if($subitem){
				$subitem_id = $subitem['Subitem']['id'];
				$plus_flag = true;
				if($this->Session->check('SaleJan.subitems')){
					$session_reader = $this->Session->read('SaleJan.subitems');
					foreach($session_reader as $key=>$value){
						if($key == $subitem_id){
							$quantity = $value['Subitem']['qty'] + 1;
							$plus_flag = false;
						}
					}
				}else{
					$quantity = 1;
				}
				if($plus_flag) $quantity = 1;
				if($this->Stock->stockConfirm($subitem_id, $depot_id, $quantity)){
					$tax = $this->Total->single_tax($subitem['Item']['price'], $subitem_id);
					$subitem['Subitem']['price'] = $subitem['Item']['price'] + $tax;
					$subitem['Subitem']['depot'] = $depot_id;
					$subitem['Subitem']['qty'] = $quantity;
					$this->Session->write("SaleJan.subitems.".$subitem_id, $subitem);
					$this->Session->write("SaleJan.detail.depot", $depot_id);
				}else{
					$this->Session->setFlash('指定倉庫に在庫がありません。');
				}
			}else{
				$this->Session->setFlash('そんなJANコードはありません。');
			}
		}
		if($ac == 'del'){
			$this->Session->delete("SaleJan.subitems.".$id);
		}
		if($ac == 'reset'){
			$this->Session->delete("SaleJan");
		}
		if(!empty($this->data['SaleDateil'])){
			$SaleDateil = $this->data['SaleDateil'];
			$session_reader = $this->Session->read('SaleJan');
			$session = Set::merge($SaleDateil, $session_reader['subitems']);
			$this->Session->write("SaleJan", $session);
			$this->redirect(array('controller'=>'order_dateils', 'action'=>'store_add/addsale'));
		}
		
		if($this->Session->check('SaleJan.subitems')){
			$session_reader = $this->Session->read('SaleJan.subitems');
			$this->set('subitems',$session_reader);
			if($this->Session->check('SaleJan.detail.depot')){
				$this->data['Sale']['depot'] = $this->Session->read('SaleJan.detail.depot');
			}
		}

		if(!empty($this->data['Sale']['depot'])){
			$this->Session->write("SaleJan.detail.depot", $this->data['Sale']['depot']);
			$section['Section']['out_depot'] = $this->data['Sale']['depot'];
		}else{
			$params = array(
				'conditions'=>array('Section.id'=>$this->Auth->user('section_id')),
				'recursive'=>0
			);
			$section = $this->Section->find('first' ,$params);
		}
		$params = array(
			'conditions'=>array('Depot.section_id'=>$this->Auth->user('section_id')),
			'recursive'=>0
		);
		$section_depots = $this->Depot->find('list' ,$params);
		$sale_type = get_sale_type();
		$this->set(compact('section', 'section_depots', 'sale_type'));
	}

	function confirm(){
		if($this->Session->check('SaleJan')){
			$session_reader = $this->Session->read('SaleJan');
			$session_reader['detail']['depot_id'] = $session_reader ['detail']['depot'];
			//合計金額を計算する
			$total = 0;
			$item_price_total = 0;
			$tax_total = 0;
			foreach($session_reader['subitems'] as $key=>$value){
				$tax = $this->Total->single_tax($value['Item']['price'], $value['Subitem']['id']);
				$single_price = $value['Item']['price'] + $tax;
				$total = $total + ($single_price * $value['Subitem']['qty']);
				$tax_total = $tax_total + ($tax * $value['Subitem']['qty']);
				$item_price_total = $item_price_total + ($value['Item']['price'] * $value['Subitem']['qty']);
			}
			$adjustment = mb_convert_kana($session_reader['detail']['adjustment'], "a");
			$adjustment = str_replace('－', '-', $adjustment);
			$adjustment = str_replace('ー', '-', $adjustment);
			$session_reader['detail']['adjustment'] = str_replace('‐', '-', $adjustment);
			$session_reader['detail']['total'] = $total + $adjustment;
			$session_reader['detail']['item_price_total'] = $item_price_total;
			$session_reader['detail']['tax'] = $tax_total;
			//１円以下の売上は入力できない
			if($session_reader['detail']['total'] <= 1){
				$this->Session->setFlash('１円以下の売上は入力できません。');
				$this->redirect(array('action'=>'add'));
			}
			//担当者の名前を入れる
			if(!empty($session_reader['detail']['contact1'])){
				$params = array(
					'conditions'=>array('User.id'=>$session_reader['detail']['contact1']),
					'recursive'=>0,
				);
				$user = $this->User->find('first' ,$params);
				$session_reader['detail']['contact1_name'] = $user['User']['name'];
			}else{
				$session_reader['detail']['contact1_name'] = $this->Auth->user('name');
				$session_reader['detail']['contact1'] = $this->Auth->user('id');
			}
			if(!empty($session_reader['detail']['contact2'])){
				$params = array(
					'conditions'=>array('User.id'=>$session_reader['detail']['contact2']),
					'recursive'=>0,
				);
				$user = $this->User->find('first' ,$params);
				$session_reader['detail']['contact2_name'] = $user['User']['name'];
			}else{
				$session_reader['detail']['contact2_name'] = '';
				$session_reader['detail']['contact2'] = '';
			}
			if(!empty($session_reader['detail']['contact3'])){
				$params = array(
					'conditions'=>array('User.id'=>$session_reader['detail']['contact3']),
					'recursive'=>0,
				);
				$user = $this->User->find('first' ,$params);
				$session_reader['detail']['contact3_name'] = $user['User']['name'];
			}else{
				$session_reader['detail']['contact3_name'] = '';
				$session_reader['detail']['contact3'] = '';
			}
			if(!empty($session_reader['detail']['contact4'])){
				$params = array(
					'conditions'=>array('User.id'=>$session_reader['detail']['contact4']),
					'recursive'=>0,
				);
				$user = $this->User->find('first' ,$params);
				$session_reader['detail']['contact4_name'] = $user['User']['name'];
			}else{
				$session_reader['detail']['contact4_name'] = '';
				$session_reader['detail']['contact4'] = '';
			}
			$this->Session->delete("SaleJan");
			$this->Session->write("SaleJan", $session_reader);
			$this->set('Confirm',$session_reader);
			$sale_type = get_sale_type();
			$this->set(compact('sale_type'));
		}
	}

	function add_confirm(){
		if($this->Session->check('SaleJan')){
			$Sale = array();
			$SalesDateil = array();
			$session_reader = $this->Session->read('SaleJan');
			$this->Session->delete("SaleJan");
			foreach($session_reader['subitems'] as $value){
				if(!$this->Stock->stockConfirm($value['Subitem']['id'], $value['Subitem']['depot'], $value['Subitem']['qty'])){
					$this->Session->setFlash('在庫不足により中止しました。先に売り上げられたか、移動されたんだと思います。');
					$this->redirect(array('action'=>'add'));
				}
			}
			$Sale['Sale'] = $session_reader['detail'];
			$Sale['Sale']['sale_status'] = 7;
			$Sale['Sale']['created_user'] = $this->Auth->user('id');
			if(empty($Sale['Sale']['adjustment'])) $Sale['Sale']['adjustment'] = 0;
			if($this->Sale->save($Sale)){
				$sale_id = $this->Sale->getInsertID();
			}else{
				$this->Session->setFlash('ERROR:sales_controller 255');
				$this->redirect(array('action'=>'add'));
			}
			foreach($session_reader['subitems'] as $value){
				$SalesDateil['SalesDateil']['sale_id'] = $sale_id;
				$SalesDateil['SalesDateil']['item_id'] = $value['Item']['id'];
				$SalesDateil['SalesDateil']['subitem_id'] = $value['Subitem']['id'];
				$size = $this->Selector->sizeSelector($value['Subitem']['major_size'], $value['Subitem']['minority_size']);
				$SalesDateil['SalesDateil']['size'] = $size;
				$SalesDateil['SalesDateil']['bid'] = $value['Item']['price'];
				$SalesDateil['SalesDateil']['bid_quantity'] = $value['Subitem']['qty'];
				$cost = $this->Selector->costSelector($value['Item']['id'], $value['Subitem']['cost']);
				$SalesDateil['SalesDateil']['cost'] = $cost;
				$tax = $this->Total->single_tax($value['Item']['price'], $value['Subitem']['id']);
				$SalesDateil['SalesDateil']['tax'] = $tax;
				if($this->Stock->Mimus($value['Subitem']['id'], $value['Subitem']['depot'], $value['Subitem']['qty'], $this->Auth->user('id'), 1)){
					if($this->SalesDateil->save($SalesDateil)){
						$this->SalesDateil->id = null;
						$SalesDateil = array();
					}else{
						$this->Session->setFlash('ERROR:sales_controller 271');
						$this->redirect(array('action'=>'add'));
					}
				}else{
					$this->Session->setFlash('在庫不足により処理を中断しました。先に売り上げられたか、移動されたんだと思います。');
					$this->redirect(array('action'=>'add'));
				}
			}
			$this->Session->setFlash('【売上番号】：'.$sale_id);
			$this->redirect(array('action'=>'add'));
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Sale', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Sale']['total'] = $this->data['Sale']['item_price_total'] + $this->data['Sale']['tax'] + $this->data['Sale']['shipping'] + $this->data['Sale']['adjustment'];
			if ($this->Sale->save($this->data)) {
				$this->Session->setFlash(__('The Sale has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Sale']['id']));
			} else {
				$this->Session->setFlash(__('The Sale could not be saved. Please, try again.', true));
			}
		}
		$this->set('sale', $this->Sale->searchOne($id));

		$sale_type = get_sale_type();
		$order_type = get_order_type();
		$sale_status = get_sale_status();
		$this->set(compact('sale_type', 'order_type', 'sale_status'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Sale', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Sale->del($id)) {
			$this->Session->setFlash(__('Sale deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function orders(){
		if($this->Session->check('Order')){
			$Sale = array();
			$session_read = $this->Session->read('Order');
			$Sale['Sale'] = $session_read['confirm']['Sale'];
			//$Sale['Sale']['total_day'] = $session_read['confirm']['Sale']['total_day']['year'].'-'.$session_read['confirm']['Sale']['total_day']['month'].'-'.$session_read['confirm']['Sale']['total_day']['day'];
			$Sale['Sale']['sale_status'] = 1;
			$Sale['Sale']['total_day'] = $session_read['confirm']['Sale']['total_day'];
			$Sale['Sale']['depot_id'] = $session_read['confirm']['Order']['depot_id'];
			$Sale['Sale']['destination_id'] = $session_read['confirm']['Order']['destination_id'];
			$Sale['Sale']['events_no'] = $session_read['confirm']['Order']['events_no'];
			$Sale['Sale']['span_no'] = $session_read['confirm']['Order']['span_no'];
			$Sale['Sale']['contact1'] = $session_read['confirm']['Order']['contact1'];
			$Sale['Sale']['contact2'] = $session_read['confirm']['Order']['contact2'];
			$Sale['Sale']['contact3'] = $session_read['confirm']['Order']['contact3'];
			$Sale['Sale']['contact4'] = $session_read['confirm']['Order']['contact4'];
			$Sale['Sale']['customers_name'] = $session_read['confirm']['Order']['customers_name'];
			$Sale['Sale']['partners_no'] = $session_read['confirm']['Order']['partners_no'];
			$Sale['Sale']['shipping'] = $session_read['confirm']['Order']['shipping'];
			$Sale['Sale']['adjustment'] = $session_read['confirm']['Order']['adjustment'];
			if($session_read['confirm']['Sale']['tax'] == 'By Monthly Bill') $session_read['confirm']['Sale']['tax'] = 0;
			$session_read['confirm']['Sale']['total'] = $session_read['confirm']['Sale']['item_price_total'] + $session_read['confirm']['Sale']['tax'] + $Sale['Sale']['shipping'] + $Sale['Sale']['adjustment'];
			if($this->Sale->save($Sale)){
				$sale_id = $this->Sale->getInsertID();
				$OrdersSale['OrdersSale']['order_id'] = $session_read['confirm']['Order']['id'];
				$OrdersSale['OrdersSale']['sale_id'] = $sale_id;
				$this->OrdersSale->save($OrdersSale);
				$ordersale_id = $this->OrdersSale->getInsertID();
				/*
				$Order = array();
				$Order['Order']['id'] = $session_read['confirm']['Order']['id'];
				$Order['Order']['order_status'] = 4;
				$this->Order->save();
				$this->Order->id = null;
				*/
			}else{
				$this->Session->setFlash(__('ERROR:sales_controller 89', true));
				$this->redirect(array('controller'=>'orders', 'action'=>'sell/'.$session_read['confirm']['Order']['id']));
			}
			$SalesDateil = array();
			$OrderDateil = array();
			foreach($session_read['confirm']['OrderDateil'] as $value){
				if($this->Stock->Mimus($value['subitem_id'], $Sale['Sale']['depot_id'], $value['sell_quantity'], $this->Auth->user('id'), 1)){
					$params = array(
						'conditions'=>array('Subitem.id'=>$value['subitem_id']),
						'recursive'=>0,
					);
					$subitem = $this->Subitem->find('first' ,$params);
					$size = $this->Selector->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
					$SalesDateil['SalesDateil']['sale_id'] = $sale_id;
					$SalesDateil['SalesDateil']['item_id'] = $subitem['Subitem']['item_id'];
					$SalesDateil['SalesDateil']['subitem_id'] = $value['subitem_id'];
					$SalesDateil['SalesDateil']['size'] = $size;
					$SalesDateil['SalesDateil']['bid'] = $value['bid'];
					$SalesDateil['SalesDateil']['bid_quantity'] = $value['sell_quantity'];
					$SalesDateil['SalesDateil']['cost'] = $value['cost'];
					$SalesDateil['SalesDateil']['marking'] = $value['marking'];
					$SalesDateil['SalesDateil']['ex_bid'] = $value['ex_bid'];
					if($this->SalesDateil->save($SalesDateil)){
						$this->SalesDateil->id = null;
						$params = array(
							'conditions'=>array('OrderDateil.id'=>$value['id']),
							'recursive'=>0,
						);
						$OrderDateil = $this->OrderDateil->find('first' ,$params);
						$OrderDateil['OrderDateil']['sell_quantity'] = $value['sell_quantity'] + $OrderDateil['OrderDateil']['sell_quantity'];
						$this->OrderDateil->save($OrderDateil);
						$this->OrderDateil->id = null;
						$SalesDateil = array();
						$OrderDateil = array();
					}else{
						$this->OrdersSale->del($ordersale_id);
						$this->Sale->del($sale_id);
						$this->Session->setFlash(__('ERROR:sales_controller 112', true));
						$this->redirect(array('controller'=>'orders', 'action'=>'sell/'.$session_read['confirm']['Order']['id']));
					}
				}else{
					$this->OrdersSale->del($ordersale_id);
					$this->Sale->del($sale_id);
					$this->Session->setFlash(__('指定倉庫に在庫がありませんでした。売上処理を中断しました。', true));
					$this->redirect(array('controller'=>'orders', 'action'=>'sell/'.$session_read['confirm']['Order']['id']));
				}
			}
			$this->Order->finish_juge($session_read['confirm']['Order']['id']);
			$this->Session->setFlash(__('input sales.', true));
			$this->redirect(array('action'=>'view/'.$sale_id));

		}
	}

	function store_orders(){
		if($this->Session->check('Order')){
			$Sale = array();
			$session_read = $this->Session->read('Order');
			foreach($session_read['confirm']['OrderDateil'] as $value){
				if(!$this->Stock->stockConfirm($value['subitem_id'], $value['depot_id'], $value['sell_quantity'])){
					$this->Session->setFlash('在庫不足により中止しました。先に売り上げられたか、移動されたんだと思います。');
					$this->redirect(array('controller'=>'orders', 'action'=>'store_sell/'.$session_read['confirm']['Order']['id']));
				}
			}
			$Sale['Sale'] = $session_read['confirm']['Sale'];
			$Sale['Sale']['sale_status'] = 7;
			$Sale['Sale']['sale_type'] = 2;
			//$Sale['Sale']['depot_id'] = $session_read['confirm']['Order']['depot_id'];
			$Sale['Sale']['section_id'] = $session_read['confirm']['Order']['section_id'];
			$Sale['Sale']['events_no'] = $session_read['confirm']['Order']['events_no'];
			$Sale['Sale']['span_no'] = $session_read['confirm']['Order']['span_no'];
			$Sale['Sale']['contact1'] = $session_read['confirm']['Order']['contact1'];
			$Sale['Sale']['contact2'] = $session_read['confirm']['Order']['contact2'];
			$Sale['Sale']['contact3'] = $session_read['confirm']['Order']['contact3'];
			$Sale['Sale']['contact4'] = $session_read['confirm']['Order']['contact4'];
			$Sale['Sale']['customers_name'] = $session_read['confirm']['Order']['customers_name'];
			$Sale['Sale']['partners_no'] = $session_read['confirm']['Order']['partners_no'];
			$session_read['confirm']['Sale']['total'] = $session_read['confirm']['Sale']['item_price_total'] + $session_read['confirm']['Sale']['tax'];
			if($this->Sale->save($Sale)){
				$sale_id = $this->Sale->getInsertID();
				$OrdersSale['OrdersSale']['order_id'] = $session_read['confirm']['Order']['id'];
				$OrdersSale['OrdersSale']['sale_id'] = $sale_id;
				$this->OrdersSale->save($OrdersSale);
				$ordersale_id = $this->OrdersSale->getInsertID();
			}else{
				$this->Session->setFlash(__('ERROR:sales_controller 575', true));
				$this->redirect(array('controller'=>'orders', 'action'=>'store_sell/'.$session_read['confirm']['Order']['id']));
			}
			$SalesDateil = array();
			$OrderDateil = array();
			foreach($session_read['confirm']['OrderDateil'] as $value){
				if($this->Stock->Mimus($value['subitem_id'], $Sale['Sale']['depot_id'], $value['sell_quantity'], $this->Auth->user('id'), 1)){
					$params = array(
						'conditions'=>array('Subitem.id'=>$value['subitem_id']),
						'recursive'=>0,
					);
					$subitem = $this->Subitem->find('first' ,$params);
					$size = $this->Selector->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
					$cost = $this->Selector->costSelector($subitem['Subitem']['item_id'], $subitem['Subitem']['cost']);
					$SalesDateil['SalesDateil']['sale_id'] = $sale_id;
					$SalesDateil['SalesDateil']['item_id'] = $subitem['Subitem']['item_id'];
					$SalesDateil['SalesDateil']['subitem_id'] = $value['subitem_id'];
					$SalesDateil['SalesDateil']['size'] = $size;
					$SalesDateil['SalesDateil']['bid'] = $value['bid'];
					$SalesDateil['SalesDateil']['bid_quantity'] = $value['sell_quantity'];
					$SalesDateil['SalesDateil']['cost'] = $cost;
					$SalesDateil['SalesDateil']['marking'] = $value['marking'];
					$SalesDateil['SalesDateil']['ex_bid'] = $value['ex_bid'];
					if($this->SalesDateil->save($SalesDateil)){
						$this->SalesDateil->id = null;
						$params = array(
							'conditions'=>array('OrderDateil.id'=>$value['id']),
							'recursive'=>0,
						);
						$OrderDateil = $this->OrderDateil->find('first' ,$params);
						$OrderDateil['OrderDateil']['sell_quantity'] = $value['sell_quantity'] + $OrderDateil['OrderDateil']['sell_quantity'];
						$this->OrderDateil->save($OrderDateil);
						$this->OrderDateil->id = null;
						$SalesDateil = array();
						$OrderDateil = array();
					}else{
						$this->OrdersSale->del($ordersale_id);
						$this->Sale->del($sale_id);
						$this->Session->setFlash(__('ERROR:sales_controller 613', true));
						$this->redirect(array('controller'=>'store_orders', 'action'=>'sell/'.$session_read['confirm']['Order']['id']));
					}
				}else{
					$this->OrdersSale->del($ordersale_id);
					$this->Sale->del($sale_id);
					$this->Session->setFlash(__('指定倉庫に在庫がありませんでした。売上処理を中断しました。', true));
					$this->redirect(array('controller'=>'store_orders', 'action'=>'sell/'.$session_read['confirm']['Order']['id']));
				}
			}
			$this->Order->finish_juge($session_read['confirm']['Order']['id']);
			$this->Session->setFlash(__('input sales.', true));
			$this->redirect(array('action'=>'view/'.$sale_id));
		}
	}

	function csv_update(){
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		if (!empty($this->data['Sale']['upload_file']['tmp_name'])) {
			$file_name = date('Ymd-His').'sale.csv';
			if($this->data['Sale']['upload_file']['size'] > 10000000){
				$this->Session->setFlash(__('ファイルサイズが500KBを超えています。分割して再度アップロードして下さい。', true));
			}else{
				rename($this->data['Sale']['upload_file']['tmp_name'], WWW_ROOT.DS.'files/prepare/'.$file_name);
				$result = $SalesCsvComponent->inSales($file_name);
				if($result){
					$this->Session->setFlash(__('売上を登録しました。:'.$result, true));
				}else{
					$this->Session->setFlash(__('登録が途中で中断された可能性があります。', true));
				}
			}
		}
	}





/*
	function csv_update(){
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		if (!empty($this->data['Sale']['upload_file']['tmp_name'])) {
			$file_name = date('Ymd-His').'sale.csv';
			if($this->data['Sale']['upload_file']['size'] > 550000){
				$this->Session->setFlash(__('ファイルサイズが500KBを超えています。分割して再度アップロードして下さい。', true));
			}else{
				rename($this->data['Sale']['upload_file']['tmp_name'], WWW_ROOT.DS.'files/prepare/'.$file_name);
				$this->Session->setFlash(__('登録を予約しました。10～30分後を目安に確認してみて下さい。', true));
			}
		}
	}
*/

}
?>