<?php
class OrderDateilsController extends AppController {

	var $name = 'OrderDateils';
	var $helpers = array("Javascript","Ajax");
	var $uses = array('OrderDateil', 'Subitem', 'Depot', 'Item', 'Order', 'Destination', 'Stock', 'Transport');
	var $components = array('Total', 'Print', 'OutputCsv', 'Selector');

	function index() {
		$modelName = 'OrderDateil';
		
		//pr($this->data[$modelName]['updating']);
		
		
		if(!empty($this->data[$modelName]['new_shipping_date'])){
			$this->data[$modelName]['new_shipping_date'] = mb_convert_kana($this->data[$modelName]['new_shipping_date'], 'a', 'UTF-8');
			//$this->data[$modelName]['new_shipping_date'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['new_shipping_date']);//半角数字以外を削除;
			if(ereg("[0-9]{8}", $this->data[$modelName]['new_shipping_date'])){
				
			}else{
				$this->data[$modelName]['new_shipping_date'] = null;
				$this->Session->setFlash(__('出荷日は、半角数字8文字で入力して下さい。', true));
			}
		}
		if(!empty($this->data[$modelName]['new_shipping_date'])){
			//pr($this->data[$modelName]['update']);
			foreach($this->data[$modelName]['updating'] as $upid=>$check){
				$save_data = array();
				if($check == '1'){
					$this->OrderDateil->create();
					$save_data['OrderDateil']['id'] = $upid;
					$save_data['OrderDateil']['shipping_date'] = $this->data[$modelName]['new_shipping_date'];
					$this->OrderDateil->save($save_data);
					$this->OrderDateil->id = null;
				}
			}
			$this->data[$modelName]['new_shipping_date'] = null;
		}
		//入荷日一括更新
		if(!empty($this->data[$modelName]['new_stock_date'])){
			$this->data[$modelName]['new_stock_date'] = mb_convert_kana($this->data[$modelName]['new_stock_date'], 'a', 'UTF-8');
			//$this->data[$modelName]['new_stock_date'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['new_stock_date']);//半角数字以外を削除;
			if(ereg("[0-9]{8}", $this->data[$modelName]['new_stock_date'])){
				
			}else{
				$this->data[$modelName]['new_stock_date'] = null;
				$this->Session->setFlash(__('入荷日は、半角数字8文字で入力して下さい。', true));
			}
		}
		if(!empty($this->data[$modelName]['new_stock_date'])){
			foreach($this->data[$modelName]['updating'] as $upid=>$check){
				$save_data = array();
				if($check == '1'){
					$this->OrderDateil->create();
					$save_data['OrderDateil']['id'] = $upid;
					$save_data['OrderDateil']['stock_date'] = $this->data[$modelName]['new_stock_date'];
					$this->OrderDateil->save($save_data);
					$this->OrderDateil->id = null;
				}
			}
			$this->data[$modelName]['new_stock_date'] = null;
		}
		
		$conditions = array();
		if (!empty($this->data)) {
			foreach($this->data[$modelName]['ordertype'] as $key=>$value){
				if($value == '1'){
					$conditions['OR'][] = array('OrderDateil.order_type'=>$key);
				}
			}
			if(!empty($this->data[$modelName]['order_id'])){
				$conditions['AND'][] = array('Order.id'=>$this->data[$modelName]['order_id']);
			}
			if(!empty($this->data[$modelName]['transport_id'])){
				$conditions['AND'][] = array('TransportDateil.transport_id'=>$this->data[$modelName]['transport_id']);
			}
			if(!empty($this->data[$modelName]['section_id'])){
				$conditions['AND'][] = array('Order.section_id'=>$this->data[$modelName]['section_id']);
			}
			if(!empty($this->data[$modelName]['item_name'])){
				$conditions['AND'][] = array('Item.name LIKE'=>'%'.$this->data[$modelName]['item_name'].'%');
			}
			if(!empty($this->data[$modelName]['start_created']['year']) and !empty($this->data[$modelName]['start_created']['month']) and !empty($this->data[$modelName]['start_created']['day'])){
				$start_created = $this->data[$modelName]['start_created']['year'].'-'.$this->data[$modelName]['start_created']['month'].'-'.$this->data[$modelName]['start_created']['day'].' 00:00:00';
				$conditions['AND'][] = array('OrderDateil.created >='=>$start_created);
			}
			if(!empty($this->data[$modelName]['end_created']['year']) and !empty($this->data[$modelName]['end_created']['month']) and !empty($this->data[$modelName]['end_created']['day'])){
				$end_created = $this->data[$modelName]['end_created']['year'].'-'.$this->data[$modelName]['end_created']['month'].'-'.$this->data[$modelName]['end_created']['day'].' 23:59:59';
				$conditions['AND'][] = array('OrderDateil.created <='=>$end_created);
			}
			if(!empty($this->data[$modelName]['start_arrival']['year']) and !empty($this->data[$modelName]['start_arrival']['month']) and !empty($this->data[$modelName]['start_arrival']['day'])){
				$start_arrival = $this->data[$modelName]['start_arrival']['year'].'-'.$this->data[$modelName]['start_arrival']['month'].'-'.$this->data[$modelName]['start_arrival']['day'].' 00:00:00';
				$conditions['AND'][] = array('OrderDateil.specified_date >='=>$start_arrival);
			}
			if(!empty($this->data[$modelName]['end_arrival']['year']) and !empty($this->data[$modelName]['end_arrival']['month']) and !empty($this->data[$modelName]['end_arrival']['day'])){
				$end_arrival = $this->data[$modelName]['end_arrival']['year'].'-'.$this->data[$modelName]['end_arrival']['month'].'-'.$this->data[$modelName]['end_arrival']['day'].' 23:59:59';
				$conditions['AND'][] = array('OrderDateil.specified_date <='=>$end_arrival);
			}
			if(!empty($this->data[$modelName]['start_stock']['year']) and !empty($this->data[$modelName]['start_stock']['month']) and !empty($this->data[$modelName]['start_stock']['day'])){
				$start_stock = $this->data[$modelName]['start_stock']['year'].'-'.$this->data[$modelName]['start_stock']['month'].'-'.$this->data[$modelName]['start_stock']['day'].' 00:00:00';
				$conditions['AND'][] = array('OrderDateil.stock_date >='=>$start_stock);
			}
			if(!empty($this->data[$modelName]['end_stock']['year']) and !empty($this->data[$modelName]['end_stock']['month']) and !empty($this->data[$modelName]['end_stock']['day'])){
				$end_stock = $this->data[$modelName]['end_stock']['year'].'-'.$this->data[$modelName]['end_stock']['month'].'-'.$this->data[$modelName]['end_stock']['day'].' 23:59:59';
				$conditions['AND'][] = array('OrderDateil.stock_date <='=>$end_stock);
			}
			if(!empty($this->data[$modelName]['start_shipping']['year']) and !empty($this->data[$modelName]['start_shipping']['month']) and !empty($this->data[$modelName]['start_shipping']['day'])){
				$start_shipping = $this->data[$modelName]['start_shipping']['year'].'-'.$this->data[$modelName]['start_shipping']['month'].'-'.$this->data[$modelName]['start_shipping']['day'].' 00:00:00';
				$conditions['AND'][] = array('OrderDateil.shipping_date >='=>$start_shipping);
			}
			if(!empty($this->data[$modelName]['end_shipping']['year']) and !empty($this->data[$modelName]['end_shipping']['month']) and !empty($this->data[$modelName]['end_shipping']['day'])){
				$end_shipping = $this->data[$modelName]['end_shipping']['year'].'-'.$this->data[$modelName]['end_shipping']['month'].'-'.$this->data[$modelName]['end_shipping']['day'].' 23:59:59';
				$conditions['AND'][] = array('OrderDateil.shipping_date <='=>$end_shipping);
			}
			if(empty($this->data[$modelName]['null_shipping'])) $this->data[$modelName]['null_shipping'] = 0;
			if($this->data[$modelName]['null_shipping'] == 1){
				$conditions['AND'][] = array('OrderDateil.shipping_date'=>null);
			}
			if(empty($this->data[$modelName]['null_stock'])) $this->data[$modelName]['null_stock'] = 0;
			if($this->data[$modelName]['null_stock'] == 1){
				$conditions['AND'][] = array('OrderDateil.stock_date'=>null);
			}
			if(empty($this->data[$modelName]['cancel_not'])) $this->data[$modelName]['cancel_not'] = 0;
			if($this->data[$modelName]['cancel_not'] == 1){
				$conditions['AND'][] = array('Order.order_status <>'=>5);
			}
			if(empty($this->data[$modelName]['sample_not'])) $this->data[$modelName]['sample_not'] = 0;
			if($this->data[$modelName]['sample_not'] == 1){
				$conditions['AND'][] = array('Item.id <>'=>1499);
			}
			if(empty($this->data[$modelName]['sample_only'])) $this->data[$modelName]['sample_only'] = 0;
			if($this->data[$modelName]['sample_only'] == 1){
				$conditions['AND'][] = array('Item.id'=>1499);
			}
			if(empty($this->data[$modelName]['csv'])) $this->data[$modelName]['csv'] = 0;
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'limit'=>5000,
					'order'=>array('OrderDateil.created'=>'desc')
				);
				$details = $this->OrderDateil->find('all' ,$params);
				$output_csv = $this->OutputCsv->OrderDateil($details);
				$file_name = 'orderdetails_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
		}
		
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>100,
			'order'=>array('OrderDateil.created'=>'desc')
		);
		$values = $this->paginate();
		foreach($values as $key=>$value){
			$size = $this->Selector->sizeSelector($value['Subitem']['major_size'], $value['Subitem']['minority_size']);
			$values[$key]['OrderDateil']['size'] = $size;
			$values[$key]['Order']['section_name'] = $this->Section->cleaningName($value['Order']['section_id']);
			
		}
		$this->set('orderDateils', $values);
		$this->set('orderStatus', get_order_status());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid OrderDateil.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('orderDateil', $this->OrderDateil->read(null, $id));
	}

	function add($ac = null, $id = null) {
		if($ac == 'ordering'){
			$session_order = $this->Session->read('Order');
			if(empty($session_order['destination_id'])){
				$this->Session->setFlash(__('出荷先は必ず入力して下さい。', true));
				$this->redirect(array('controller'=>'order_dateils', 'action'=>'add'));
			}else{
				$company_contact = $this->Destination->companyContact($session_order['destination_id']);
				if($company_contact != null){
					$session_order['contact1'] = $company_contact;
				}
				$this->Session->write("Order", $session_order);
			}
		}
		$this->store_add($ac, $id);
		$order_type = array('1'=>'受注(卸)', '3'=>'注残破棄(卸)', '4'=>'特別注文', '7'=>'取置');
		$this->set('orderType', $order_type);
		$params = array(
			'conditions'=>array('Depot.section_id'=>309),
			'recursive'=>-1
		);
		$this->set('sectionDepot', $this->Depot->find('list' ,$params));
	}

	function getData(){
		$this->layout = 'ajax';
		$params = array(
			'conditions'=>array('Item.name LIKE'=>'%'.$this->data['OrderDateil']['AutoItemName'].'%'),
			'recursive'=>0,
			'limit'=>20,
			'order'=>array('Item.name'=>'asc'),
			'fields'=>array('Item.name')
		);
		$result = $this->Item->find('all', $params);
		if(!empty($result)){
			foreach($result as $values){
				$Autoitems[] = $values['Item']['name'];
			}
		}else{
			$Autoitems[] = 'しらんがな';
		}
		$this->set("Autoitems",$Autoitems);
	}

	function store_add($ac = null, $id = null) {
		if($ac == 'reset'){
			$this->Session->delete("OrderDateil");
			$this->Session->delete("Order");
			$session_read = array();
		}
		$total_quantity = 0;
		if(@$this->data['OrderDateil']['step'] == '1') {
			if(!empty($this->data['OrderDateil']['AutoItemName'])){
				$params = array(
					'conditions'=>array('Item.name'=>$this->data['OrderDateil']['AutoItemName']),
					'recursive'=>0,
				);
				$item = $this->Item->find('first' ,$params);
				if($item){
					$this->set('item', $item);
					$params = array(
						'conditions'=>array('Subitem.item_id'=>$item['Item']['id']),
						'recursive'=>0,
						'order'=>array('Subitem.name'=>'asc')
					);
					$subitems = $this->Subitem->find('all' ,$params);
					$this->set('subitems', $subitems);
				}else{
					$this->Session->setFlash(__('品番を間違えてるかも、', true));
				}
			}
			//Orderデータの整形
			if(!empty($this->data['OrderDateil']['destination_id'])){
				$this->Session->write("Order.destination_id", $this->data['OrderDateil']['destination_id']);
			}else{
				$this->Session->delete("Order.destination_id");
			}
			if(!empty($this->data['OrderDateil']['partners_no'])){
				$this->Session->write("Order.partners_no", $this->data['OrderDateil']['partners_no']);
			}else{
				$this->Session->delete("Order.partners_no");
			}
			if(!empty($this->data['OrderDateil']['date'])){
				$this->Session->write("Order.date", $this->data['OrderDateil']['date']);
			}else{
				$this->Session->delete("Order.date");
			}
			if(!empty($this->data['OrderDateil']['events_no'])){
				$events_no = trim($this->data['OrderDateil']['events_no']);
				$events_no = mb_convert_kana($events_no, 'a');
				$this->Session->write("Order.events_no", $this->data['OrderDateil']['events_no']);
			}else{
				$this->Session->delete("Order.events_no");
			}
			if(!empty($this->data['OrderDateil']['customers_name'])){
				$this->Session->write("Order.customers_name", $this->data['OrderDateil']['customers_name']);
			}else{
				$this->Session->delete("Order.customers_name");
			}
			if(!empty($this->data['OrderDateil']['remark'])){
				$this->Session->write("Order.remark", $this->data['OrderDateil']['remark']);
			}else{
				$this->Session->delete("Order.remark");
			}
			if(!empty($this->data['OrderDateil']['contact1'])){
				$this->Session->write("Order.contact1", $this->data['OrderDateil']['contact1']);
			}else{
				$this->Session->delete("Order.contact1");
			}
			if(!empty($this->data['OrderDateil']['contact2'])){
				$this->Session->write("Order.contact2", $this->data['OrderDateil']['contact2']);
			}else{
				$this->Session->delete("Order.contact2");
			}
			if(!empty($this->data['OrderDateil']['contact3'])){
				$this->Session->write("Order.contact3", $this->data['OrderDateil']['contact3']);
			}else{
				$this->Session->delete("Order.contact3");
			}
			if(!empty($this->data['OrderDateil']['contact4'])){
				$this->Session->write("Order.contact4", $this->data['OrderDateil']['contact4']);
			}else{
				$this->Session->delete("Order.contact4");
			}
			if(!empty($this->data['OrderDateil']['prev_money'])){
				$this->Session->write("Order.prev_money", $this->data['OrderDateil']['prev_money']);
			}else{
				$this->Session->delete("Order.prev_money");
			}
			if(!empty($this->data['OrderDateil']['order_status']) OR $this->data['OrderDateil']['order_status'] == '0'){
				$this->Session->write("Order.order_status", $this->data['OrderDateil']['order_status']);
			}else{
				$this->Session->delete("Order.order_status");
			}
		}
		//取り置き入力
		if(!empty($this->data['OrderDateil']['reserve'])){
			$transport_id = $this->data['OrderDateil']['reserve'];
			$params = array(
				'conditions'=>array('Transport.id'=>$transport_id),
				'recursive'=>3,
			);
			$this->Transport->contain('TransportDateil.Subitem.Item');
			$Transport = $this->Transport->find('first' ,$params);
			if($Transport){
				if($Transport['Transport']['layaway_type'] == 1){
					$session_detail = $this->Session->read('OrderDateil');
					$this->Session->delete("OrderDateil");
					foreach($Transport['TransportDateil'] as $reserv){
						$reserv_write = array();
						$reserv_write['Subitem']['transport_detail_id'] = $reserv['id'];
						$reserv_write['Subitem']['transport_id'] = $Transport['Transport']['id'];
						$reserv_write['Subitem']['id'] = $reserv['Subitem']['id'];
						$reserv_write['Subitem']['name'] = $reserv['Subitem']['name'];
						$reserv_write['Subitem']['quantity'] = $reserv['out_qty'];
						$reserv_write['Subitem']['minority_size'] = $reserv['Subitem']['minority_size'];
						$reserv_write['Subitem']['major_size'] = $reserv['Subitem']['major_size'];
						$reserv_write['Item']['id'] = $reserv['Subitem']['item_id'];
						$reserv_write['Subitem']['specified_date'] = $Transport['Transport']['arrival_date'];
						$reserv_write['Subitem']['marking'] = '';
						$reserv_write['Subitem']['order_type'] = '7';
						$reserv_write['Subitem']['discount'] = '';
						$reserv_write['Subitem']['adjustment'] = '';
						$reserv_write['Item']['price'] = $reserv['Subitem']['Item']['price'];
						$reserv_write['Subitem']['sub_remarks'] = $Transport['Transport']['remark'];
						$reserv_write['Subitem']['span_no'] = '';
						//$reserv_write['Subitem']['depot_id'] = $Transport['Transport']['in_depot'];
						$reserv_write['Subitem']['depot_id'] = $this->Section->defaultDepotId($this->Auth->user('section_id'));
						$session_detail[] = $reserv_write;
					}
					$this->Session->write("OrderDateil", $session_detail);
					$this->data['OrderDateil']['reserve'] = '';
				}else{
					$this->Session->setFlash(__('既に取り置き入力が済んでいる、番号です。', true));
				}
			}else{
				$this->Session->setFlash(__('取置番号を間違えていると思われます。', true));
			}
		}
		
		//saleから渡ってきた売上を無理栗マージ
		if($ac == 'addsale'){
			$session_reader = $this->Session->read('SaleJan');
			$this->Session->delete("SaleJan");
			$session_count = $this->Session->read('OrderDateil');
			if($session_count){
				$i = count($session_count) + 1;
			}else{
				$i = 0;
			}
			foreach($session_reader as $key=>$value){
				$session_write = array();
				$session_write['Subitem']['id'] = $value['Subitem']['id'];
				$session_write['Subitem']['name'] = $value['Subitem']['name'];
				$session_write['Subitem']['quantity'] = $value['Subitem']['qty'];
				$session_write['Subitem']['major_size'] = $value['Subitem']['major_size'];
				$session_write['Subitem']['minority_size'] = $value['Subitem']['minority_size'];
				$session_write['Item']['id'] = $value['Item']['id'];
				$session_write['Subitem']['specified_date'] = array('year'=>'', 'month'=>'', 'day'=>'');
				$session_write['Subitem']['marking'] = '';
				$session_write['Subitem']['order_type'] = '6'; // 6 現売
				$price_element = $this->Total->PriceCalculation($value['Item']['price'], $value['discount'], $value['adjustment']);
				$session_write['Subitem']['discount'] = $price_element['discount'] * 100;
				$session_write['Subitem']['adjustment'] = $price_element['adjustment'];
				$session_write['Item']['price'] = $price_element['price'];
				$session_write['Subitem']['sub_remarks'] =  $value['sub_remark'];
				$value['span_no'] = mb_convert_kana($value['span'], 'a', 'UTF-8');
				$session_write['Subitem']['span_no'] = ereg_replace("[^0-9a-zA-Z]", "", $value['span_no']);//半角英数字以外を削除
				$value['depot'] = mb_convert_kana($value['depot'], 'a', 'UTF-8');
				$session_write['Subitem']['depot_id'] = ereg_replace("[^0-9]", "", $value['depot']);//半角数字以外を削除;
				$this->Session->write("OrderDateil.".$i, $session_write);
				$i++;
			}
		}
		//特別注文を無理栗マージ
		if($ac == 'special'){
			if(!empty($this->data)){
				$session = $this->data;
				$session_count = $this->Session->read('OrderDateil');
				if($session_count){
					$i = count($session_count) + 1;
				}else{
					$i = 0;
				}
				$session_write = array();
				$session_write['Subitem']['id'] = '';
				$params = array(
					'conditions'=>array('Item.id'=>$session['Subitem']['item_id']),
					'recursive'=>0,
					'fields'=>array('Item.name', 'Item.price'),
				);
				$Item = $this->Item->find('first' ,$params);
				$session_write['Subitem']['name'] = $Item['Item']['name'];
				$session_write['Subitem']['quantity'] = 1;
				$session_write['Subitem']['major_size'] = $session['Subitem']['major_size'];
				$session_write['Subitem']['minority_size'] = $session['Subitem']['minority_size'];
				$session_write['Item']['id'] = $session['Subitem']['item_id'];
				$session_write['Subitem']['specified_date'] = array(
					'year'=>$session['OrderDateil']['specified_date']['year'], 
					'month'=>$session['OrderDateil']['specified_date']['month'], 
					'day'=>$session['OrderDateil']['specified_date']['day']
				);
				$session_write['Subitem']['marking'] = $session['OrderDateil']['marking'];
				$session_write['Subitem']['order_type'] = $session['Order']['order_type']; // 4 特別注文
				$price_element = $this->Total->PriceCalculation($Item['Item']['price'], $session['Order']['discount'], $session['Order']['adjustment']);
				$session_write['Subitem']['discount'] = $price_element['discount'] * 100;
				$session_write['Subitem']['adjustment'] = $price_element['adjustment'];
				$session_write['Item']['price'] = $price_element['price'];
				$session_write['Subitem']['sub_remarks'] =  $session['Order']['remark'];
				$value['span_no'] = mb_convert_kana($session['Order']['span_no'], 'a', 'UTF-8');
				$session_write['Subitem']['span_no'] = ereg_replace("[^0-9a-zA-Z]", "", $value['span_no']);//半角英数字以外を削除
				$value['depot'] = mb_convert_kana($session['Order']['depot_id'], 'a', 'UTF-8');
				$session_write['Subitem']['depot_id'] = ereg_replace("[^0-9]", "", $value['depot']);//半角数字以外を削除;
				//ここからspecialの独自変換
				$session_write['Subitem']['process_id'] = $session['Subitem']['process_id'];
				$session_write['Subitem']['material_id'] = $session['Subitem']['material_id'];
				$session_write['Subitem']['carat'] = $session['Subitem']['carat'];
				$session_write['Subitem']['color'] = $session['Subitem']['color'];
				$session_write['Subitem']['clarity'] = $session['Subitem']['clarity'];
				$session_write['Subitem']['cut'] = $session['Subitem']['cut'];
				$session_write['Order']['destination_id'] = $session['Order']['destination_id'];
				$session_write['Order']['shipping'] = $session['Order']['shipping'];
				$session_write['Item']['stock_code'] = 3;
				$this->Session->write("OrderDateil.".$i, $session_write);
			}
		}
		if($ac == 'edit'){
			$session_read = $this->Session->read('OrderDateil');
			$params = array(
				'conditions'=>array('Item.id'=>$session_read[$id]['Item']['id']),
				'recursive'=>0,
			);
			$item = $this->Item->find('first' ,$params);
			$this->set('item', $item);
			$params = array(
				'conditions'=>array('Subitem.item_id'=>$item['Item']['id']),
				'recursive'=>0,
				'order'=>array('Subitem.name'=>'asc')
			);
			$subitems = $this->Subitem->find('all' ,$params);
			$this->set('subitems', $subitems);
			$this->set('edit', $session_read[$id]);
			$this->Session->delete("OrderDateil.".$id);
			unset($session_read[$id]);
		}
		
		if(@$this->data['OrderDateil']['step'] == '2'){
			$subitems = array_keys($this->data['subitem']);
			foreach($subitems as $subitem_id){
				if($this->data['subitem'][$subitem_id] > 0){
					$session_write = array();
					$params = array(
						'conditions'=>array('Subitem.id'=>$subitem_id),
						'recursive'=>0
					);
					$this->Subitem->unbindModel(array('belongsTo'=>array('Process', 'Material')));
					$subitem = $this->Subitem->find('first' ,$params);
					$quantity = trim($this->data['subitem'][$subitem_id]);
					$quantity = mb_convert_kana($quantity, 'a');
					$session_write['Subitem']['id'] =  $subitem['Subitem']['id'];
					$session_write['Subitem']['name'] =  $subitem['Subitem']['name'];
					$session_write['Subitem']['quantity'] = $quantity;
					$session_write['Subitem']['major_size'] = $subitem['Subitem']['major_size'];
					$session_write['Subitem']['minority_size'] = $subitem['Subitem']['minority_size'];
					$session_write['Item']['id'] =  $subitem['Subitem']['item_id'];
					if(!empty($this->data['OrderDateil']['transport_detail_id'])){
						$session_write['Subitem']['transport_detail_id'] = $this->data['OrderDateil']['transport_detail_id'];
					}
					$session_write['Subitem']['marking'] = trim($this->data['OrderDateil']['marking']);
					$session_write['Subitem']['specified_date'] = $this->data['OrderDateil']['specified_date'];
					$session_write['Subitem']['discount'] = $this->data['OrderDateil']['discount'];
					$session_write['Subitem']['adjustment'] = $this->data['OrderDateil']['adjustment'];
					$session_write['Subitem']['depot_id'] = $this->data['OrderDateil']['depot_id'];
					$session_write['Subitem']['order_type'] = $this->data['OrderDateil']['order_type'];
					if($this->data['OrderDateil']['order_type'] == '6'){ //現売で在庫が無かった場合は、強制的に客注
						if($this->Stock->stockConfirm($subitem['Subitem']['id'], $this->data['OrderDateil']['depot_id'], $quantity)){
						}else{
							$this->Session->setFlash(__('在庫が無かったので、客注に変更しました。', true));
							$session_write['Subitem']['order_type'] = '2';
						}
					}
					$this->data['OrderDateil']['span_no'] = mb_convert_kana($this->data['OrderDateil']['span_no'], 'a', 'UTF-8');
					$session_write['Subitem']['span_no'] = ereg_replace("[^0-9a-zA-Z]", "", $this->data['OrderDateil']['span_no']);//半角英数字以外を削除
					$price_element = $this->Total->PriceCalculation($this->data['Item']['price'], $this->data['OrderDateil']['discount'], $this->data['OrderDateil']['adjustment']);
					$this->data['Item']['price'] =  $price_element['price'];
					$this->data['OrderDateil']['adjustment'] = $price_element['adjustment'];
					$this->data['OrderDateil']['discount'] = $price_element['discount'];
					$session_write['Subitem']['discount'] = $price_element['discount'] * 100;
					$session_write['Subitem']['adjustment'] = $price_element['adjustment'];
					$session_write['Item']['price'] =  $price_element['price'];
					$session_write['Subitem']['sub_remarks'] =  $this->data['OrderDateil']['sub_remarks'];
					$session_count = $this->Session->read('OrderDateil');
					/*
					if($session_count){
						$i = count($session_count);
					}else{
						$i = 0;
					}
					$this->Session->write("OrderDateil.".$i, $session_write);//ここでまとめて、詳細をセッションに追加している
					*/
					$session_count[] = $session_write;
					$this->Session->write("OrderDateil", $session_count);
				}
			}
		}
		if($this->Session->check('OrderDateil')){
			$details = array();
			$session_read = $this->Session->read('OrderDateil');
			$session_order = $this->Session->read('Order');
			if($ac == 'del'){
				$this->Session->delete("OrderDateil.".$id);
				unset($session_read[$id]);
			}
			if($ac == 'alldel'){
				$this->Session->delete("OrderDateil");
				$this->Session->delete("Order");
				$session_read = array();
			}
			if($ac == 'ordering'){
				$i = 0;
				foreach($session_read as $key=>$value){
					$sub_total[$i]['money'] = $value['Item']['price'];
					$sub_total[$i]['quantity'] = $value['Subitem']['quantity'];
					$i++;
				}
				//消費税の計算方法、1、出荷先　2、倉庫を見ていき、指定が無ければログインユーザーのセクションで判断する
				
				//(7/21)　1受注の中に複数の部門は存在しないようにする。
				//　という前提の下、１つ目のdetailのdepot_idから、section_id を引いて、念のため格納する。
				//if(!empty($session_order['depot_id']))
				if(!empty($session_read['0']['Subitem']['depot_id'])){
					$params = array(
						'conditions'=>array('Depot.id'=>$session_read['0']['Subitem']['depot_id']),
						'recursive'=>0,
					);
					$Depot = $this->Depot->find('first' ,$params);
					$tax_method = $Depot['Section']['tax_method'];
					$tax_fraction = $Depot['Section']['tax_fraction'];
					$session_order['depot_name'] = $Depot['Depot']['name'];
					$session_order['section_name'] = $Depot['Section']['name'];
					$session_order['section_id'] = $Depot['Section']['id'];
				}else{
					$params = array(
						'conditions'=>array('Section.id'=>$this->Auth->user('section_id')),
						'recursive'=>0,
					);
					$Section = $this->Section->find('first' ,$params);
					$tax_method = $Section['Section']['tax_method'];
					$tax_fraction = $Section['Section']['tax_fraction'];
					$session_order['section_name'] = $Section['Section']['name'];
					$session_order['section_id'] = $this->Auth->user('section_id');
				}
				//出荷先が登録されている場合は、消費税メソッドを上書き
				if(!empty($session_order['destination_id'])){
					$params = array(
						'conditions'=>array('Destination.id'=>$session_order['destination_id']),
						'recursive'=>0,
					);
					$Destination = $this->Destination->find('first' ,$params);
					$tax_method = $Destination['Company']['tax_method'];
					$tax_fraction = $Destination['Company']['tax_fraction'];
					$session_order['destination_name'] = $Destination['Destination']['name'];
				}
				//販売担当者が入っていたら名前を追加
				if(!empty($session_order['contact1'])) $session_order['contact1_name'] = $this->User->userName($session_order['contact1']);
				if(!empty($session_order['contact2'])) $session_order['contact2_name'] = $this->User->userName($session_order['contact2']);
				if(!empty($session_order['contact3'])) $session_order['contact3_name'] = $this->User->userName($session_order['contact3']);
				if(!empty($session_order['contact4'])) $session_order['contact4_name'] = $this->User->userName($session_order['contact4']);
				
				$slip_total = $this->Total->slipTotal($sub_total, $tax_method, $tax_fraction);
				if(empty($session_order['shipping'])) $session_order['shipping'] = 0;
				if(empty($session_order['adjustment'])) $session_order['adjustment'] = 0;
				$session_order['total'] = $slip_total['total'] + $session_order['shipping'] + $session_order['adjustment'];
				$session_order['price_total'] = $slip_total['detail_total'];
				$session_order['total_tax'] = $slip_total['tax'];
				//$session_order['order_type'] = $session_order['order_type'];
				$this->Session->write("Confirm.order", $session_order);
				$this->Session->write("Confirm.details", $session_read);
				$this->redirect(array('controller'=>'order_dateils', 'action'=>'confirm'));
			}
			$this->set('details', $session_read); //ここで詳細をセット
		}
		//デフォルトDepotを用意
		$params = array(
			'conditions'=>array('Section.id'=>$this->Auth->user('section_id')),
			'recursive'=>0,
		);
		$userSection = $this->Section->find('first' ,$params);
		if($this->Session->check('Order.depot_id')) $userSection['Section']['default_depot'] = $this->Session->read('Order.depot_id');
		$this->set('userSection', $userSection);

		//セッションを受け取ってまたセットする
		if($this->Session->check('Order.order_status')){
			$this->set('order_status', $this->Session->read('Order.order_status'));
		}else{
			$this->set('order_status', '');
		}
		
		if($this->Session->check('Order.order_type')){
			$this->set('order_type', $this->Session->read('Order.order_type'));
		}else{
			$this->set('order_type', '');
		}
		if($this->Session->check('Order.prev_money')){
			$this->set('prev_money', $this->Session->read('Order.prev_money'));
		}else{
			$this->set('prev_money', '');
		}
		if($this->Session->check('Order.partners_no')){
			$this->set('partners_no', $this->Session->read('Order.partners_no'));
		}else{
			$this->set('partners_no', '');
		}
		if($this->Session->check('Order.date')){
			$this->set('date', $this->Session->read('Order.date'));
		}else{
			$this->set('date', array());
		}
		if($this->Session->check('Order.events_no')){
			$this->set('events_no', $this->Session->read('Order.events_no'));
		}else{
			$this->set('events_no', '');
		}
		if($this->Session->check('Order.customers_name')){
			$this->set('customers_name', $this->Session->read('Order.customers_name'));
		}else{
			$this->set('customers_name', '');
		}
		if($this->Session->check('Order.remark')){
			$this->set('remark', $this->Session->read('Order.remark'));
		}else{
			$this->set('remark', '');
		}
		if($this->Session->check('Order.contact1')){
			$params = array(
					'conditions'=>array('User.id'=>$this->Session->read('Order.contact1')),
					'recursive'=>0,
			);
			$user1 = $this->User->find('first' ,$params);
			if(!$user1) {
				$user1['User']['id'] = 'そんな人は';
				$user1['User']['name'] = 'いません。';
			}
			$this->set('contact1', $user1);
		}else{
			$contact1 = $this->Auth->user();
			$this->set('contact1', $contact1);
		}
		if($this->Session->check('Order.contact2')){
			$params = array('conditions'=>array('User.id'=>$this->Session->read('Order.contact2')),'recursive'=>0,);
			$user2 = $this->User->find('first' ,$params);
			if(!$user2) {
				$user2['User']['id'] = 'そんな人も';
				$user2['User']['name'] = 'いません。';
			}
			$this->set('contact2', $user2);
		}else{
			$contact2['User']['name'] = '';
			$contact2['User']['id'] = '';
			$this->set('contact2', $contact2);
		}
		if($this->Session->check('Order.contact3')){
			$params = array('conditions'=>array('User.id'=>$this->Session->read('Order.contact3')),'recursive'=>0,);
			$user3 = $this->User->find('first' ,$params);
			if(!$user3) {
				$user3['User']['id'] = 'いま';
				$user3['User']['name'] = 'せん。';
			}
			$this->set('contact3', $user3);
		}else{
			$contact3['User']['name'] = '';
			$contact3['User']['id'] = '';
			$this->set('contact3', $contact3);
		}
		if($this->Session->check('Order.contact4')){
			$params = array('conditions'=>array('User.id'=>$this->Session->read('Order.contact4')),'recursive'=>0,);
			$user4 = $this->User->find('first' ,$params);
			if(!$user4) {
				$user4['User']['id'] = 'だから';
				$user4['User']['name'] = 'いないって！';
			}
			$this->set('contact4', $user4);
		}else{
			$contact4['User']['name'] = '';
			$contact4['User']['id'] = '';
			$this->set('contact4', $contact4);
		}
		if($this->Session->check('Order.destination_id')){
			$params = array(
					'conditions'=>array('Destination.id'=>$this->Session->read('Order.destination_id')),
					'recursive'=>0,
			);
			$Destination = $this->Destination->find('first' ,$params);
			if(!$Destination){
				$Destination['Destination']['name'] = 'そんな出荷先はありません。';
				$Destination['Destination']['id'] = '';
			}
			$this->set('destination', $Destination);
		}else{
			$Destination['Destination']['name'] = '';
			$Destination['Destination']['id'] = '';
			$this->set('destination', $Destination);
		}
		$params = array(
			'conditions'=>array('Depot.section_id'=>$this->Auth->user('section_id')),
			'recursive'=>0,
		);
		$this->set('sectionDepot', $this->Depot->find('list' ,$params));
		$order_type = array('2'=>'客注', '5'=>'手配済', '6'=>'現売');
		$this->set('orderType', $order_type);
	}//store_add終わり

	function confirm(){
		$this->set('sorting', $this->Auth->user('access_authority'));
		$Confirm = $this->Session->read('Confirm');
		if(empty($Confirm['order']['contact1']) and empty($Confirm['order']['date'])){
			$Confirm['order']['contact1'] = $this->Auth->user('id');
			$Confirm['order']['contact1_name'] = $this->Auth->user('name');
			$Confirm['order']['date']['year'] = date('Y');
			$Confirm['order']['date']['month'] = date('m');
			$Confirm['order']['date']['day'] = date('d');
			$this->Session->write('Confirm', $Confirm);
		}
		$this->set('Confirm', $Confirm);
		$this->set('orderStatus', get_order_status());
		$this->set('orderType', get_order_type());
	}
	

	function add_confirm(){
		//ここの途中に、モデルを直接叩いてsaleを保存する。　→　817 sale要らないんじゃね？
		$confirm = $this->Session->read('Confirm');
		$this->Session->delete("OrderDateil");
		$this->Session->delete("Order");
		$Order['Order'] = $confirm['order'];
		$Order['Order']['created_user'] = $this->Auth->user('id');
		if($confirm['order']['order_status'] == 6){
			$Order['Order']['order_status'] = $confirm['order']['order_status'];
		}else{
			$Order['Order']['order_status'] = 1;
		}
		$this->Order->save($Order);
		$order_id = $this->Order->getInsertID();
		$Order['Order']['id'] = $order_id;
		//$Input_processing_sales = false;
		//$transportDetailId = array();
		foreach($confirm['details'] as $detail){
			//order_typeが4の時は、先にsubitemを登録する。お渡し入力の時にjanを入れてもらい、更新する。
			if($detail['Subitem']['order_type'] == 4){
				$Subitem['Subitem'] = $detail['Subitem'];
				$Subitem['Subitem']['item_id'] = $detail['Item']['id'];
				$Subitem['Subitem']['selldata_id'] = $order_id;
				$this->Subitem->save($Subitem);
				$detail['Subitem']['id'] = $this->Subitem->getInsertID();
			}
			$OrderDateil = array();
			$OrderDateil['OrderDateil']['order_id'] = $order_id;
			$OrderDateil['OrderDateil']['item_id'] = $detail['Item']['id'];
			$OrderDateil['OrderDateil']['subitem_id'] = $detail['Subitem']['id'];
			$OrderDateil['OrderDateil']['specified_date'] = $detail['Subitem']['specified_date'];
			$OrderDateil['OrderDateil']['bid'] = $detail['Item']['price'];
			$OrderDateil['OrderDateil']['bid_quantity'] = $detail['Subitem']['quantity'];
			$OrderDateil['OrderDateil']['marking'] = $detail['Subitem']['marking'];
			if(!empty($detail['Subitem']['transport_detail_id'])){
				$OrderDateil['OrderDateil']['transport_dateil_id'] = $detail['Subitem']['transport_detail_id'];
			}
			$OrderDateil['OrderDateil']['discount'] = $detail['Subitem']['discount'];
			$OrderDateil['OrderDateil']['adjustment'] = $detail['Subitem']['adjustment'];
			$OrderDateil['OrderDateil']['depot_id'] = $detail['Subitem']['depot_id'];
			$OrderDateil['OrderDateil']['order_type'] = $detail['Subitem']['order_type'];
			$OrderDateil['OrderDateil']['span_no'] = $detail['Subitem']['span_no'];
			$OrderDateil['OrderDateil']['sub_remarks'] = $detail['Subitem']['sub_remarks'];
			$OrderDateil['OrderDateil']['created_user'] = $this->Auth->user('id');
			// order_type = 6 現売
			if($OrderDateil['OrderDateil']['order_type'] == 6){
				$result = $this->Stock->Mimus(
					$detail['Subitem']['id'], 
					$detail['Subitem']['depot_id'], 
					$detail['Subitem']['quantity'],
					$this->Auth->user('id'),
					1
				);
				if($result == false){// の場合はsell_qtyを加算せず、客注にする。リダイレクトはしない。
					$this->Session->setFlash('一部、在庫が無かったので客注で売上入力しました。');
					$OrderDateil['OrderDateil']['order_type'] = 2;
					//$this->redirect(array('controller'=>'order_dateils', 'action'=>'confirm'));
				}else{
					$OrderDateil['OrderDateil']['sell_quantity'] = $detail['Subitem']['quantity'];
				}
			}
			if(empty($OrderDateil['OrderDateil']['discount'])){
				$OrderDateil['OrderDateil']['discount'] = 0;
			}
			$this->OrderDateil->save($OrderDateil);
			$this->OrderDateil->id = null;
		}
		//layaway status も変更、明細単位で全部揃っていたらステータスを更新する。
		if(!empty($transportDetailId)){
			$this->layawayStatusUpdate($transportDetailId);
		}
		$this->Order->finish_juge($order_id);
		$this->Session->delete("Confirm");
		if(empty($Order['Order']['destination_id'])){
			$this->redirect(array('controller'=>'orders', 'action'=>'store_index'));
		}else{
			$this->redirect(array('controller'=>'orders', 'action'=>'index'));
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid OrderDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->OrderDateil->save($this->data)) {
				$this->Session->setFlash(__('The OrderDateil has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The OrderDateil could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->OrderDateil->read(null, $id);
		}
		$orders = $this->OrderDateil->Order->find('list');
		$items = $this->OrderDateil->Item->find('list');
		$subitems = $this->OrderDateil->Subitem->find('list');
		$transportDateils = $this->OrderDateil->TransportDateil->find('list');
		$this->set(compact('orders','items','subitems','transportDateils'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for OrderDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->OrderDateil->del($id)) {
			$this->Session->setFlash(__('OrderDateil deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	

}
?>