<?php
class OrdersController extends AppController {

	var $name = 'Orders';
	var $helpers = array('AddForm', 'Time');
	var $uses = array('Order', 'OrderDateil', 'Company', 'Item', 'Destination', 'Depot', 'Stock', 'Invoice', 'Process', 'Material', 'Subitem', 'Sale');
	var $components = array('Print', 'DateCal', 'Total', 'JanCode', 'Selector', 'OutputCsv', 'Cleaning');

	function index($ac = null) {
		if($ac != 'shippinglist') $ac = 'index';
		$this->store_index($ac);
	}

	function store_index($ac = null) {
		$modelName = 'Order';
		$conditions = array();
		if (!empty($this->data)) {
			if(!empty($this->data[$modelName]['company_id'])){
				$params = array(
					'conditions'=>array('Destination.company_id'=>$this->data[$modelName]['company_id']),
					'recursive'=>0,
					'fields'=>array('Destination.id'),
				);
				$Destinations = $this->Destination->find('all' ,$params);
				foreach($Destinations as $Destination){
					$conditions['or'][] = array('Order.destination_id'=>$Destination['Destination']['id']);
				}
			}
			if(!empty($this->data[$modelName]['destination_id'])){
				$conditions[] = array('and'=>array('Order.destination_id'=>$this->data[$modelName]['destination_id']));
			}
			
			if(!empty($this->data[$modelName]['events_no'])){
				$conditions[] = array('and'=>array('Order.events_no'=>$this->data[$modelName]['events_no']));
			}
			if(!empty($this->data[$modelName]['partners_no'])){
				$conditions[] = array('and'=>array('Order.partners_no LIKE'=>'%'.$this->data[$modelName]['partners_no'].'%'));
			}
			if(!empty($this->data[$modelName]['customers_name'])){
				$customers_name = trim($this->data[$modelName]['customers_name']);
				$conditions[] = array('and'=>array('Order.customers_name LIKE'=>'%'.$customers_name.'%'));
			}
			if(!empty($this->data[$modelName]['section'])){
				$conditions[] = array('and'=>array('Order.section_id'=>$this->data[$modelName]['section']));
			}
			if(!empty($this->data[$modelName]['order_status'])){
				$conditions[] = array('and'=>array('Order.order_status'=>$this->data[$modelName]['order_status']));
			}
			if(!empty($this->data[$modelName]['id'])){
				$conditions[] = array('and'=>array('Order.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['start_date']['year']) and !empty($this->data[$modelName]['start_date']['month']) and !empty($this->data[$modelName]['start_date']['day'])){
				$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'];
				$conditions[] = array('and'=>array('Order.date >='=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_date']['year']) and !empty($this->data[$modelName]['end_date']['month']) and !empty($this->data[$modelName]['end_date']['day'])){
				$end_date = $this->data[$modelName]['end_date']['year'].'-'.$this->data[$modelName]['end_date']['month'].'-'.$this->data[$modelName]['end_date']['day'];
				$conditions[] = array('and'=>array('Order.date <='=>$end_date));
			}
			if(!empty($this->data[$modelName]['id'])){
				$conditions[] = array('and'=>array('Order.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['item_word'])){
				$params = array(
					'conditions'=>array('Item.name LIKE'=>'%'.$this->data[$modelName]['item_word'].'%'),
					'recursive'=>0,
					'fields'=>array('Item.id'),
				);
				$items = $this->Item->find('all' ,$params);
				foreach($items as $item){
					$params = array(
						'conditions'=>array('OrderDateil.item_id'=>$item['Item']['id']),
						'recursive'=>0,
						'fields'=>array('OrderDateil.order_id'),
					);
					$OrderDateils = $this->OrderDateil->find('all' ,$params);
					foreach($OrderDateils as $OrderDateil){
						//$conditions[] = array('or'=>array('Order.id'=>$OrderDateil['OrderDateil']['order_id']));
						$conditions['or'][] = array('Order.id'=>$OrderDateil['OrderDateil']['order_id']);
					}
				}
			}
			if(empty($this->data[$modelName]['csv'])) $this->data[$modelName]['csv'] = 0;
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'limit'=>5000,
					'order'=>array('Order.created'=>'desc')
				);
				$orders = $this->Order->find('all' ,$params);
				$output_csv = $this->OutputCsv->orders($orders);
				$file_name = 'orders_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
		}else{
			$this->data[$modelName]['start_date']['year'] = date('Y');
			$this->data[$modelName]['start_date']['month'] = date('m');
			$this->data[$modelName]['start_date']['day'] = date('d');
			$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'];
			$conditions[] = array('and'=>array('Order.date >='=>$start_date));
			$conditions[] = array('and'=>array('Order.order_status <>'=>5));
			if($ac == 'index'){
				$conditions[] = array('and'=>array('Order.destination_id <>'=>null));
			}else{
				$this->data[$modelName]['section'] = $this->Auth->user('section_id');
				$conditions[] = array('and'=>array('Order.section_id'=>$this->Auth->user('section_id')));
				$conditions[] = array('and'=>array('Order.destination_id'=>null));
			}
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>25,
			'order'=>array('Order.created'=>'desc')
		);
		$this->Order->recursive = 0;
		$orders = $this->paginate();
		//一覧表示の際に、余計なものを外して、ちょっと軽くする
		foreach($orders as $key=>$order){
			$orders[$key]['Depot']['section_name'] = $this->Section->cleaningName($order['Order']['section_id']);
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact1']),
				'recursive'=>0,
			);
			$user = $this->User->find('first' ,$params);
			$orders[$key]['Order']['contact1_name'] = $user['User']['name'];
			$orders[$key]['Destination']['company_name'] = '';
			if(!empty($order['Destination']['id'])){
				$orders[$key]['Destination']['name'] = $this->Cleaning->factoryName($order['Destination']['name']);
				$params = array(
					'conditions'=>array('Company.id'=>$order['Destination']['company_id']),
					'recursive'=>0,
					'fields'=>array('Company.name'),
				);
				$company = $this->Company->find('first' ,$params);
				$orders[$key]['Destination']['company_name']  = $this->Cleaning->factoryName($company['Company']['name']);
			}
		}
		$this->set('orders', $orders);
		$order_status = get_order_status();
		$order_type = get_order_type();
		$this->set(compact('order_type', 'order_status'));
		if($ac == 'shippinglist'){
			$today = date('Y-m-d');
			$conditions = array();
			$conditions[] = array('OrderDateil.shipping_date'=>$today);
			$params = array(
				'conditions'=>$conditions,
				'limit'=>5000,
				'order'=>array('OrderDateil.created'=>'desc')
			);
			$dateil = $this->OrderDateil->find('all' ,$params);
			$output_csv = $this->OutputCsv->shippinglist($dateil);
			$file_name = 'shipping_list_csv'.date('Ymd-His').'.csv';
			$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
			$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output_csv);
			$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
			$output['name'] = $file_name;
			$this->set('csv', $output);
		}
	}
	
	function return_pl($order_id = null){
		if ($order_id == null) {
			$this->Session->setFlash(__('Invalid Order.', true));
			$this->redirect(array('controller'=>'orders', 'action'=>'index'));
		}
		$this->Order->create();
		$order['Order']['id'] = $order_id;
		$order['Order']['order_status'] = '1';
		$this->Order->save($order);
		$this->redirect(array('controller'=>'orders', 'action'=>'store_view/'.$order_id));
	}
	

	function picklist($ac = null){
		$path = WWW_ROOT.'/files/order-picklist/';
		$output_start = false;
		$conditions = array();
		if($ac == 'ws'){
			//$conditions[] = array('Order.order_status'=>1);
			//$conditions[] = array('Order.destination_id <>'=>NULL);
			$conditions = array('Order.order_status'=>1, 'Order.destination_id <>'=>NULL);
			$output_start = true;
		}
		if($ac == 'retail'){
			//$conditions[] = array('Order.order_status'=>1);
			//$conditions[] = array('Order.destination_id'=>NULL);
			$conditions = array('Order.order_status'=>1, 'Order.destination_id'=>NULL);
			$output_start = true;
		}
		if($output_start){
			$params = array(
				'conditions'=>$conditions,
				'recursive'=>1,
			);
			$orders = $this->Order->find('all' ,$params);
			if($orders){
				$file_name = 'order-picklist-'.date('Ymd-His');
				if($ac == 'ws') $file_name = 'ws-picklist-'.date('Ymd-His');
				if($ac == 'retail') $file_name = 'retail-picklist-'.date('Ymd-His');
				$print_xml = $this->Print->OrderPickList($orders, $file_name);
				file_put_contents($path.$file_name.'.php', $print_xml);
				foreach($orders as $order){
					if($order['Order']['order_type'] != 4 and $order['Order']['order_type'] != 5){//特別注文はピックリストを印刷しない アンド、手配済も
						$Order['Order']['id'] = $order['Order']['id'];
						$Order['Order']['order_status'] = 2;
						$Order['Order']['updated_user'] = $this->Auth->user('id');
						$this->Order->save($Order);
						$this->Order->id = null;
					}
				}
				$print_out['url'] = '/buchedenoel/files/order-picklist/'.$file_name.'.php';
				$print_out['file'] = $file_name.'.pxd';
				$this->set('print', $print_out);
			}
		}
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if($file != '.' and $file != '..'){
				$old_file[] = $file;
			}
		}
		closedir($handle);
		rsort($old_file);
		$this->set('old_file', $old_file);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Order.', true));
			$this->redirect(array('action'=>'index'));
		}
		$order = $this->Order->searchOne($id);
		$this->set('order', $order);
		$order_type = get_order_type();
		$order_status = get_order_status();
		$this->set(compact('order_type', 'order_status'));
		if(!empty($order['Order']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/order-print/'.$order['Order']['print_file'].'.php';
			$print_out['file'] = $order['Order']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
		if(!empty($order['Order']['print_custom'])){
			$print_custom['url'] = '/buchedenoel/files/customorder-print/'.$order['Order']['print_custom'].'.php';
			$print_custom['file'] = $order['Order']['print_custom'].'.pxd';
			$this->set('print_custom', $print_custom);
		}
	}

	function store_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Order.', true));
			$this->redirect(array('action'=>'index'));
		}
		$order = $this->Order->searchOne($id);
		$this->set('order', $order);
		$order_type = get_order_type();
		$order_status = get_order_status();
		$this->set(compact('order_type', 'order_status'));
		if(!empty($order['Order']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/customorder-print/'.$order['Order']['print_file'].'.php';
			$print_out['file'] = $order['Order']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
		if(!empty($order['Order']['print_custom'])){
			$print_custom['url'] = '/buchedenoel/files/customorder-print/'.$order['Order']['print_custom'].'.php';
			$print_custom['file'] = $order['Order']['print_custom'].'.pxd';
			$this->set('print_custom', $print_custom);
		}
	}

	function order_print($id = null){
		$params = array(
			'conditions'=>array('Order.id'=>$id),
			'recursive'=>1,
		);
		$order = $this->Order->find('first' ,$params);
		//注残破棄の場合で、引当も発注もない場合は、破棄数量に入れる。
		if($order['Order']['order_type'] == 3){
			foreach($order['OrderDateil'] as $key=>$value){
				if($value['bid_quantity'] > ($value['pairing_quantity'] + $value['ordering_quantity'])){
					$order['OrderDateil'][$key]['an_quantity'] = $value['bid_quantity'] - ($value['pairing_quantity'] + $value['ordering_quantity']);
					$OrderDateil['OrderDateil'] = $order['OrderDateil'][$key];
					$this->OrderDateil->save($OrderDateil);
					$this->OrderDateil->id = null;
				}
			}
		}
		$Order['Order']['id'] = $id;
		$Order['Order']['order_status'] = 3;
		$this->Order->save($Order);
		$file_name = 'order_print'.$id.'-'.date('Ymd-His');
		$path = WWW_ROOT.'/files/order-print/';
		$print_xml = $this->Print->OrderPrint($order, $file_name);
		file_put_contents($path.$file_name.'.php', $print_xml);
		$Order['Order']['id'] = $id;
		$Order['Order']['updated_user'] = $this->Auth->user('id');
		$Order['Order']['print_file'] = $file_name;
		$this->Order->save($Order);
		$this->redirect(array('action'=>'view/'.$id));
	}

	function customorder_print($id = null){
		$params = array(
			'conditions'=>array('Order.id'=>$id),
			'recursive'=>1,
		);
		$order = $this->Order->find('first' ,$params);
		$params = array(
			'conditions'=>array('Section.id'=>$order['Depot']['section_id']),
			'recursive'=>0,
		);
		$section = $this->Section->find('first' ,$params);
		$order['Section'] = $section['Section'];
		$order['Order']['contact2_name'] = '';
		$order['Order']['contact3_name'] = '';
		$order['Order']['contact4_name'] = '';
		$params = array(
			'conditions'=>array('User.id'=>$order['Order']['contact1']),
			'recursive'=>0,
		);
		$user = $this->User->find('first' ,$params);
		$order['Order']['contact1_name'] = $user['User']['name'];
		if(!empty($order['Order']['contact2'])){
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact2']),
				'recursive'=>0,
			);
			$user = $this->User->find('first' ,$params);
			$order['Order']['contact2_name'] = $user['User']['name'];
		}
		if(!empty($order['Order']['contact3'])){
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact3']),
				'recursive'=>0,
			);
			$user = $this->User->find('first' ,$params);
			$order['Order']['contact3_name'] = $user['User']['name'];
		}
		if(!empty($order['Order']['contact4'])){
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact4']),
				'recursive'=>0,
			);
			$user = $this->User->find('first' ,$params);
			$order['Order']['contact4_name'] = $user['User']['name'];
		}
		//ステータス変更
		$Order['Order']['id'] = $id;
		$Order['Order']['order_status'] = 3;
		$this->Order->save($Order);
		$file_name = 'customorder_print'.$id.'-'.date('Ymd-His');
		$path = WWW_ROOT.'/files/customorder-print/';
		$print_xml = $this->Print->CustomOrderPrint($order, $file_name);
		file_put_contents($path.$file_name.'.php', $print_xml);
		$Order['Order']['id'] = $id;
		$Order['Order']['updated_user'] = $this->Auth->user('id');
		$Order['Order']['print_custom'] = $file_name;
		$this->Order->save($Order);
		$this->redirect(array('action'=>'view/'.$id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Order->create();
			if ($this->Order->save($this->data)) {
				$this->Session->setFlash(__('The Order has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Order could not be saved. Please, try again.', true));
			}
		}
		$sales = $this->Order->Sale->find('list');
		$depots = $this->Order->Depot->find('list');
		$this->set(compact('sales', 'depots'));
	}

	function edit($id = null) {
		if(!empty($this->data)){
			$this->Order->create();
			if ($this->Order->save($this->data['Order'])) {
				foreach($this->data['OrderDateil'] as $value){
					$OrderDateil['OrderDateil'] = $value;
					if(!empty($this->data['Order']['specified_lump'])) $OrderDateil['OrderDateil']['specified_date'] = $this->data['Order']['specified_lump'];
					if(!empty($this->data['Order']['store_arrival_lump'])) $OrderDateil['OrderDateil']['store_arrival_date'] = $this->data['Order']['store_arrival_lump'];
					if(!empty($this->data['Order']['stock_lump'])) $OrderDateil['OrderDateil']['stock_date'] = $this->data['Order']['stock_lump'];
					if(!empty($this->data['Order']['shipping_lump'])) $OrderDateil['OrderDateil']['shipping_date'] = $this->data['Order']['shipping_lump'];
					$this->OrderDateil->create();
					$result = $this->OrderDateil->save($OrderDateil);
					if ($result) {
						$this->OrderDateil->id = null;
					}else{
						$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
						$this->redirect(array('action'=>'edit/'.$this->data['Order']['id']));
					}
				}
				$this->Session->setFlash(__('The Order has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Order']['id']));
			}else{
				$this->Session->setFlash(__('The Order could not be saved. Please, try again.', true));
			}
		}
		$order = $this->Order->searchOne($id);
		$this->set('order', $order);
		$order_type = get_order_type();
		$order_status = get_order_status();
		$this->set(compact('order_type', 'order_status'));
	}

	function store_edit($id = null) {
		if(!empty($this->data)){
			$this->Order->create();
			if ($this->Order->save($this->data['Order'])) {
				if(!empty($this->data['OrderDateil'])){
					foreach($this->data['OrderDateil'] as $value){
						$OrderDateil['OrderDateil'] = $value;
						$params = array(
							'conditions'=>array('Item.id'=>$value['item_id']),
							'recursive'=>0,
							'fields'=>array('Item.price')
						);
						$item_price = $this->Item->find('first' ,$params);
						$item_price = $item_price['Item']['price'];
						$detail_price = $this->Total->PriceCalculation($item_price, $value['discount'], $value['adjustment']);
						$OrderDateil['OrderDateil']['bid'] = $detail_price['price'];
						$OrderDateil['OrderDateil']['discount'] = $detail_price['discount'];
						$OrderDateil['OrderDateil']['adjustment'] = $detail_price['adjustment'];
						if(!empty($this->data['Order']['specified_lump'])) $OrderDateil['OrderDateil']['specified_date'] = $this->data['Order']['specified_lump'];
						if(!empty($this->data['Order']['store_arrival_lump'])) $OrderDateil['OrderDateil']['store_arrival_date'] = $this->data['Order']['store_arrival_lump'];
						if(!empty($this->data['Order']['stock_lump'])) $OrderDateil['OrderDateil']['stock_date'] = $this->data['Order']['stock_lump'];
						if(!empty($this->data['Order']['shipping_lump'])) $OrderDateil['OrderDateil']['shipping_date'] = $this->data['Order']['shipping_lump'];
						$this->OrderDateil->create();
						$result = $this->OrderDateil->save($OrderDateil);
						if ($result) {
							$this->OrderDateil->id = null;
						}else{
							$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
							$this->redirect(array('action'=>'edit/'.$this->data['Order']['id']));
						}
					}
				}
				$this->Order->orderRecalculation($this->data['Order']['id']);//合計、消費税の再計算
				$this->Session->setFlash(__('The Order has been saved', true));
				$this->redirect(array('action'=>'store_view/'.$this->data['Order']['id']));
			}else{
				$this->Session->setFlash(__('The Order could not be saved. Please, try again.', true));
			}
		}
		$order = $this->Order->searchOne($id);
		$this->set('order', $order);
		$order_status = get_order_status();
		//$order_type = get_order_type();
		$order_type = array('2'=>'客注', '5'=>'手配済', '6'=>'現売');
		$this->set(compact('order_status', 'order_type'));
	}

	function sell($id = null) {
		$rate_fraction = '';
		$order = $this->Order->searchOne($id);
		if(!empty($order['Order']['destination_id'])){
			$params = array(
				'conditions'=>array('Company.id'=>$order['Destination']['company_id']),
				'recursive'=>0
			);
			$company = $this->Company->find('first' ,$params);
			$rate_fraction = $company['Company']['rate_fraction'];
			if(!empty($company['Company']['user_id'])){
				$order['Order']['contact1'] = $company['Company']['user_id'];
				$params = array(
					'conditions'=>array('User.id'=>$company['Company']['user_id']),
					'recursive'=>0
				);
				$company_user = $this->User->find('first' ,$params);
				$order['Order']['contact1_name'] = $company_user['User']['name'];
			}
			//締め日の計算。invoice_typeが1、月締めの場合はtotal_dayに従い締め日を計算。デフォルトは末締め。invoice_typeが1以外の場合は当日を入れる
			if($company['Billing']['invoice_type'] == 1){
				if(!empty($company['Billing']['total_day'])){
					//$total_dates = $this->Invoice->totalDay($company['Billing']['total_day']);
					$order['Order']['total_day'] = $this->Invoice->totalDay($company['Billing']['total_day']);
				}else{
					$order['Order']['total_day'] = $this->DateCal->this_last_day();
					//$order['Order']['total_day'] = '';
				}
			}else{
				$this_year = date('Y');
				$this_month = date('m');
				$this_day = date('d');
				$order['Order']['total_day'] = array('year'=>$this_year, 'month'=>$this_month, 'day'=>$this_day);
			}
		}else{
			//$order['Order']['total_day'] = $this->DateCal->this_last_day();指定倉庫に在庫がありません。または足りません。
			$order['Order']['total_day'] = '';
		}
		foreach($order['OrderDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Item.id'=>$value['item_id']),
				'recursive'=>0
			);
			$item = $this->Item->find('first' ,$params);
			$rate = $this->Company->rate($order['Destination']['company_id'], $item['Item']['brand_id']);
			$order['OrderDateil'][$key]['ex_bid'] = $value['bid'];
			$order['OrderDateil'][$key]['bid'] = $this->Total->rate_cal($rate_fraction, $rate, $value['bid'], $item['Item']['percent_code']);
		}
		$this->set('order', $order);
		$order_type = get_order_type();
		$order_status = get_order_status();
		$sale_type = get_sale_type();
		$section_depots = $this->Depot->sectionDepots('309');
		$this->set(compact('order_type', 'order_status', 'sale_type', 'section_depots'));
	}

	function store_sell($id = null) {
		$rate_fraction = '';
		$order = $this->Order->searchOne($id);
		foreach($order['OrderDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Item.id'=>$value['item_id']),
				'recursive'=>0
			);
			$item = $this->Item->find('first' ,$params);
			$rate = $this->Company->rate($order['Destination']['company_id'], $item['Item']['brand_id']);
			$order['OrderDateil'][$key]['ex_bid'] = $value['bid'];
			$order['OrderDateil'][$key]['bid'] = $this->Total->rate_cal($rate_fraction, $rate, $value['bid'], $item['Item']['percent_code']);
		}
		$this->set('order', $order);
		$order_type = get_order_type();
		$order_status = get_order_status();
		$section_depots = $this->Depot->sectionDepots($this->Auth->user('section_id'));
		$this->set(compact('order_type', 'order_status', 'section_depots'));
	}

	function sell_confirm(){
		$this->store_sell_confirm();
	}

	function store_sell_confirm(){
		
		$no_qty = false;
		$ex_total = 0;
		$sub_total = array();
		foreach($this->data['OrderDateil'] as $key=>$value){
			//jan が入っていたら、janを探して、旧から来たものは削除して、登録されているものにjanを登録
			if(!empty($value['subitem_jan'])){
				$value['subitem_jan'] = mb_convert_kana($value['subitem_jan'], 'a', 'UTF-8');
				$value['subitem_jan'] = ereg_replace("[^0-9]", "", $value['subitem_jan']);//半角数字以外削除
				$params = array(
					'conditions'=>array('Subitem.jan'=>$value['subitem_jan']),
					'recursive'=>0,
					'fields'=>array('Subitem.id', 'Subitem.item_id', 'Subitem.jan')
				);
				$subitem = $this->Subitem->find('first' ,$params);
				
				if(!$subitem){
					$this->Session->setFlash('619-JANコードを間違えているか、旧システムから仕入データが転送されていません。');
					$this->redirect(array('action'=>'store_sell/'.$this->data['Order']['id']));
				}
				
				//在庫も移動する
				$params = array(
					'conditions'=>array('Stock.subitem_id'=>$subitem['Subitem']['id'], 'Stock.quantity >='=>1),
					'recursive'=>0
				);
				$subitem_stock = $this->Stock->find('first' ,$params);
				if(empty($subitem_stock)){
					$this->Session->setFlash('629-処理を中断しました。旧システムから仕入データが転送されていない可能性があります。');
					if(empty($this->data['Order']['destination_id'])){
						$this->redirect(array('action'=>'store_sell/'.$this->data['Order']['id']));
					}else{
						$this->redirect(array('action'=>'sell/'.$this->data['Order']['id']));
					}
				}
				$this->Stock->delete($subitem_stock['Stock']['id']);
				$this->Stock->create();
				$new_stock = array();
				$new_stock['Stock']['subitem_id'] = $value['subitem_id'];
				$new_stock['Stock']['depot_id'] = $subitem_stock['Stock']['depot_id'];
				$new_stock['Stock']['quantity'] = 1;
				$this->Stock->save($new_stock);
				
				$this->Subitem->delete($subitem['Subitem']['id']);
				$this->Subitem->create();
				$subitem = array();
				$subitem['Subitem']['id'] = $value['subitem_id'];
				$subitem['Subitem']['jan'] = $value['subitem_jan'];
				$this->Subitem->save($subitem);
				$sub_total[$key]['money'] = $value['bid'];
				$sub_total[$key]['quantity'] = 1;
				$no_qty = true;
			}else{
				$stock_result = $this->Stock->stockConfirm($value['subitem_id'], $value['depot_id'], $value['sell_quantity']);
				if($stock_result === false){
					$this->Session->setFlash('600-指定倉庫に在庫がありません。または足りません。');
					if(empty($this->data['Order']['destination_id'])){
						$this->redirect(array('action'=>'store_sell/'.$this->data['Order']['id']));
					}else{
						$this->redirect(array('action'=>'sell/'.$this->data['Order']['id']));
					}
				}
				if($value['sell_quantity'] >= 1){
					//完了できる以上の数量を入力されたら、完了できる最大値に強制変更
					$max_sell = $value['bid_quantity'] - $value['before_sell_quantity'];
					if($max_sell < $value['sell_quantity']){
						$value['sell_quantity'] = $max_sell;
						$this->data['OrderDateil'][$key]['sell_quantity'] = $max_sell;
					}
					$sub_total[$key]['money'] = $value['bid'];
					$sub_total[$key]['quantity'] = $value['sell_quantity'];
					$ex_total = $ex_total + $value['ex_bid']; //$ex_total 上代合計　卸用
					$no_qty = true;
				}else{
					unset($this->data['OrderDateil'][$key]);
				}
			}
		}
		//税の計算方法を出してるんだが、親に持ってくるのをdepotじゃなくて、sectionに切り替えてから作業した
		if(!empty($this->data['Order']['section_id'])){
			$params = array(
				'conditions'=>array('Section.id'=>$this->data['Order']['section_id']),
				'recursive'=>0,
				'fields'=>array('Section.tax_method', 'Section.tax_fraction')
			);
			$Section = $this->Section->find('first' ,$params);
			$tax_method = $Section['Section']['tax_method'];
			$tax_fraction = $Section['Section']['tax_fraction'];
		}elseif(!empty($this->data['Order']['destination_id'])){
			$params = array(
				'conditions'=>array('Destination.id'=>$this->data['Order']['destination_id']),
				'recursive'=>0
			);
			$Destination = $this->Destination->find('first' ,$params);
			$tax_method = $Destination['Company']['tax_method'];
			$tax_fraction = $Destination['Company']['tax_fraction'];
			$this->data['Order']['section_id'] = 309;
		}else{
			$no_qty = false;
		}
		//売上数量が全て0だった、
		if($no_qty == false){
			$this->Session->setFlash('売上数量が入力されていません。');
			if(empty($this->data['Order']['destination_id'])){
				$this->redirect(array('action'=>'store_sell/'.$this->data['Order']['id']));
			}else{
				$this->redirect(array('action'=>'sell/'.$this->data['Order']['id']));
			}
		}
		$slip_total = $this->Total->slipTotal($sub_total, $tax_method, $tax_fraction);
		$this->data['Sale']['item_price_total'] = $slip_total['detail_total'];
		$this->data['Sale']['tax'] = $slip_total['tax'];
		$this->data['Sale']['total'] = $slip_total['total'];
		$this->data['Sale']['ex_total'] = $ex_total;
		$this->Session->write("Order.confirm", $this->data);
		$this->set('confirm', $this->data);
		$order_type = get_order_type();
		$order_status = get_order_status();
		$sale_type = get_sale_type();
		$this->set(compact('order_type', 'order_status', 'sale_type'));
	}
	
	function store_orders(){
		$session_read = $this->Session->read('Order');
		foreach($session_read['confirm']['OrderDateil'] as $value){
			$OrderDateil = array();
			if(!empty($value['subitem_jan'])) $value['sell_quantity'] = 1;
			if($this->Stock->Mimus($value['subitem_id'], $value['depot_id'], $value['sell_quantity'], $this->Auth->user('id'), 1)){
				$OrderDateil['OrderDateil']['id'] = $value['id'];
				$OrderDateil['OrderDateil']['sell_quantity'] = $value['sell_quantity'] + $value['before_sell_quantity'];
				$this->OrderDateil->save($OrderDateil);
				$this->OrderDateil->id = null;
			}else{
				$this->Session->setFlash('先に売上げられたか移動されたかで、指定倉庫に在庫が足りません。処理を中断しました。');
				if(empty($session_read['confirm']['Order']['destination_id'])){
					$this->redirect(array('controller'=>'orders', 'action'=>'store_view/'.$session_read['confirm']['Order']['id']));
				}else{
					$this->redirect(array('controller'=>'orders', 'action'=>'view/'.$session_read['confirm']['Order']['id']));
				}
			}
		}
		$this->Order->finish_juge($session_read['confirm']['Order']['id']);
		if(empty($session_read['confirm']['Order']['destination_id'])){
			$this->redirect(array('controller'=>'orders', 'action'=>'store_view/'.$session_read['confirm']['Order']['id']));
		}else{
			$session_read['confirm']['Sale']['created_user'] = $this->Auth->user('id');
			$this->Sale->WsSale($session_read);
			$this->redirect(array('controller'=>'orders', 'action'=>'view/'.$session_read['confirm']['Order']['id']));
		}
	}

	function delete($ac = null, $id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Order', true));
			$this->redirect(array('action'=>'index'));
		}
		if($ac == 'store'){
			$messe = '売上を取消しました。';
			$return_qty = 0;
			$params = array(
				'conditions'=>array('Order.id'=>$id),
				'recursive'=>2
			);
			$this->Order->contain('OrderDateil.Item');
			$Order = $this->Order->find('first' ,$params);
			foreach($Order['OrderDateil'] as $OrderDateil){
				if($OrderDateil['sell_quantity'] > 0 AND $OrderDateil['Item']['stock_code'] <> 2){
					$this->Stock->Plus($OrderDateil['subitem_id'], $OrderDateil['depot_id'], $OrderDateil['sell_quantity'], $this->Auth->user('id'), 5);
					$return_qty = $return_qty + $OrderDateil['sell_quantity'];
				}
			}
			if($return_qty > 0){
				$messe .= '<br>商品を　'.$return_qty.'個、在庫に戻しました。';
			}
			$Order['Order']['id'] = $id;
			$Order['Order']['order_status'] = 5;
			$this->Order->save($Order);
			$this->Session->setFlash($messe);
			$this->redirect(array('action'=>'store_view/'.$id));
		}

		if($ac == 'ws'){
			$Order['Order']['id'] = $id;
			$Order['Order']['order_status'] = 5;
			$this->Order->save($Order);
			$this->Session->setFlash(__('受注を取消しました。', true));
			$this->redirect(array('action'=>'view/'.$id));
		}
	}
	
	function special_add_ws($id = null){
		$this->special_add($id);
		$this->set('sectionDepot', $this->Depot->sectionDepots('309'));
	}

	function special_add($id = null){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Order', true));
			$this->redirect(array('controller'=>'items', 'action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Item.id'=>$id),
			'recursive'=>0
		);
		$item = $this->Item->find('first' ,$params);
		$params = array(
			'conditions'=>array('Section.id'=>$this->Auth->user('section_id')),
			'recursive'=>0,
		);
		$userSection = $this->Section->find('first' ,$params);
		$major_size = get_major_size();
		$color = get_color();
		$clarity = get_clarity();
		$cut = get_cut();
		$processes = $this->Process->find('list');
		$materials = $this->Material->find('list');
		$this->set(compact('processes', 'materials','color','clarity','cut','item', 'major_size', 'userSection'));
		$this->set('sectionDepot', $this->Depot->sectionDepots($this->Auth->user('section_id')));
	}

	function special_add_confirm($ac = null){
		if($this->data){
			$params = array(
				'conditions'=>array('Item.id'=>$this->data['Subitem']['item_id']),
				'recursive'=>0
			);
			$item = $this->Item->find('first' ,$params);
			$params = array(
				'conditions'=>array('Depot.id'=>$this->data['Order']['depot_id']),
				'recursive'=>0
			);
			$depot = $this->Depot->find('first' ,$params);
			$this->data['Order']['contact1_name'] = $this->User->userName($this->data['Order']['contact1']);
			$this->data['Order']['contact2_name'] = $this->User->userName($this->data['Order']['contact2']);
			$this->data['Order']['contact3_name'] = $this->User->userName($this->data['Order']['contact3']);
			$this->data['Order']['contact4_name'] = $this->User->userName($this->data['Order']['contact4']);
			$this->data['Order']['destination_name'] = $this->Destination->getName($this->data['Order']['destination_id']);
			$this->data['Subitem']['minority_size'] = mb_convert_kana($this->data['Subitem']['minority_size'], "a");
			$major_size = get_major_size();
			$color = get_color();
			$clarity = get_clarity();
			$cut = get_cut();
			if(!empty($this->data['Order']['adjustment'])){
				$this->data['Order']['adjustment'] = mb_convert_kana($this->data['Order']['adjustment'], 'a', 'UTF-8');
				$this->data['Order']['adjustment'] = ereg_replace("[^0-9\-]", "", $this->data['Order']['adjustment']);//半角数字とハイフン以外削除
			}
			if(!empty($this->data['Order']['shipping'])){
				$this->data['Order']['shipping'] = mb_convert_kana($this->data['Order']['shipping'], 'a', 'UTF-8');
				$this->data['Order']['shipping'] = ereg_replace("[^0-9]", "", $this->data['Order']['shipping']);//半角数字以外削除
			}
			$total = $item['Item']['price'] + $this->data['Order']['shipping'] + $this->data['Order']['adjustment'];
			$this->set('confirm', $this->data);
			$processes = $this->Process->find('list');
			$materials = $this->Material->find('list');
			$this->set(compact('processes', 'materials', 'color','clarity','cut','item', 'major_size', 'depot', 'total'));
			$this->Session->write("confirm", $this->data);
		}
		if($ac == 'confirm'){
			if($this->Session->check('confirm')){
				$session = $this->Session->read('confirm');
				$this->Session->delete("confirm");
				$params = array(
					'conditions'=>array('Item.id'=>$session['Subitem']['item_id']),
					'recursive'=>0
				);
				$item = $this->Item->find('first' ,$params);
				//合計を計算、消費税も
				$session['Order']['destination_id'] = $this->Destination->cleener($session['Order']['destination_id']);
				if(!empty($session['Order']['destination_id'])){
					$params = array(
						'conditions'=>array('Destination.id'=>$session['Order']['destination_id']),
						'recursive'=>0
					);
					$Destination = $this->Destination->find('first' ,$params);
					$tax_method = $Destination['Company']['tax_method'];
					$tax_fraction = $Destination['Company']['tax_fraction'];
					$view_action = 'view'; //出荷先が入っていた場合は、卸用のview
				}elseif(!empty($session['Order']['depot_id'])){
					$params = array(
						'conditions'=>array('Depot.id'=>$session['Order']['depot_id']),
						'recursive'=>0
					);
					$Depot = $this->Depot->find('first' ,$params);
					$tax_method = $Depot['Section']['tax_method'];
					$tax_fraction = $Depot['Section']['tax_fraction'];
					$view_action = 'store_view'; //出荷先が入っていなかった場合は、店舗用のstore_view、ちなみに倉庫番号が入っていなかった場合のことは考えていない。
				}
				$sub_total[0]['money'] = $item['Item']['price'];
				$sub_total[0]['quantity'] = 1;
				$slip_total = $this->Total->slipTotal($sub_total, $tax_method, $tax_fraction);
				//JANコードジェネレーター
				$jan = $this->JanCode->janGenerator($item['Brand']['id'],$item['Item']['name'],$session['Subitem']['major_size'],$session['Subitem']['minority_size']);
				$Order['Order'] = $session['Order'];
				$Order['Order']['price_total'] = $slip_total['detail_total'];
				$Order['Order']['total_tax'] = $slip_total['tax'];
				$Order['Order']['total'] = $slip_total['total'] + $session['Order']['shipping'] + $session['Order']['adjustment'];
				$Order['Order']['contact1'] = $this->User->cleener($Order['Order']['contact1']);
				$Order['Order']['contact2'] = $this->User->cleener($Order['Order']['contact2']);
				$Order['Order']['contact3'] = $this->User->cleener($Order['Order']['contact3']);
				$Order['Order']['contact4'] = $this->User->cleener($Order['Order']['contact4']);
				if($this->Order->save($Order)){
					$order_id = $this->Order->getInsertID();
				}else{
					$this->Session->setFlash('ERROR:orders_controller 614');
					$this->redirect(array('controller'=>'items', 'action'=>'index'));
				}
				$Subitem['Subitem'] = $session['Subitem'];
				$Subitem['Subitem']['name'] = $item['Item']['name'];
				$Subitem['Subitem']['jan'] = $jan;
				$Subitem['Subitem']['selldata_id'] = $order_id;
				if($this->Subitem->save($Subitem)){
					$subitem_id = $this->Subitem->getInsertID();
				}else{
					$this->Session->setFlash('ERROR:orders_controller 623');
					$this->redirect(array('controller'=>'items', 'action'=>'index'));
				}
				$OrderDateil['OrderDateil'] = $session['OrderDateil'];
				$OrderDateil['OrderDateil']['item_id'] = $session['Subitem']['item_id'];
				$OrderDateil['OrderDateil']['subitem_id'] = $subitem_id;
				$size = $this->Selector->sizeSelector($session['Subitem']['major_size'], $session['Subitem']['minority_size']);
				$OrderDateil['OrderDateil']['size'] = $size;
				$OrderDateil['OrderDateil']['bid'] = $item['Item']['price'];
				$OrderDateil['OrderDateil']['bid_quantity'] = 1;
				$OrderDateil['OrderDateil']['order_id'] = $order_id;
				if($this->OrderDateil->save($OrderDateil)){
					$dateil_id = $this->OrderDateil->getInsertID();
				}else{
					$this->Session->setFlash('ERROR:orders_controller 637');
					$this->redirect(array('controller'=>'items', 'action'=>'index'));
				}
				$this->Session->setFlash('特殊受注を入力しました。');
				$this->redirect(array('controller'=>'orders', 'action'=>$view_action.'/'.$order_id));
			}
		}
	}

}
?>