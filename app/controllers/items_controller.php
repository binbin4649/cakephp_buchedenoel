<?php
class ItemsController extends AppController {

	var $name = 'Items';
	var $helpers = array('AddForm',"Javascript","Ajax");
	var $uses = array('Item', 'User', 'ItemImage', 'TagsItem', 'Subitem', 'Stock', 'Itembase', 'Depot');
	var $components = array('ImageSelect', 'StratCsv', 'DateilSeach', 'Cleaning', 'OutputCsv');

	function index() {
		if(!empty($this->data['Item'])){
			$this->Item->recursive = 0;
			$conditions = array();
			if(!empty($this->data['Item']['jan'])){
				$jan = trim($this->data['Item']['jan']);
				$params = array(
					'conditions'=>array('Subitem.jan'=>$jan),
					'recursive'=>0,
					'fields'=>array('Subitem.item_id')
				);
				$subitem_jan = $this->Subitem->find('first' ,$params);
				if($subitem_jan) $conditions[] = array('and'=>array('Item.id'=>$subitem_jan['Subitem']['item_id']));
			}
			if(!empty($this->data['Item']['message_stamp'])){
				$message_stamp = trim($this->data['Item']['message_stamp']);
				$conditions['or'][] = array('Item.message_stamp_ja LIKE'=>'%'.$message_stamp.'%');
				$conditions['or'][] = array('Item.message_stamp LIKE'=>'%'.$message_stamp.'%');
			}
			if (!empty($this->data['Item']['word'])) {
				$words = split(',', $this->data['Item']['word']);
				foreach($words as $word){
					$seach_word = trim($word);
					$seach_word = strtoupper($seach_word);
					$conditions['or'][] = array('Item.name LIKE'=>'%'.$seach_word.'%');
					//$conditions[] = array('or'=>array('Item.name LIKE'=>'%'.$seach_word.'%'));
				}
			}
			if(!empty($this->data['Tag']['Tag'])){
				$item_list_marge = array();
				foreach($this->data['Tag']['Tag'] as $tag){
					$params = array(
						'conditions'=>array('TagsItem.tag_id'=>$tag),
						'recursive'=>0,
						'fields'=>array('TagsItem.item_id')
					);
					$item_list = $this->TagsItem->find('list' ,$params);
					$item_list_marge = Set::merge($item_list_marge, $item_list);

				}
				$conditions[] = array('and'=>array('Item.id'=>$item_list_marge));
			}
			if(!empty($this->data['Item']['release_day_start']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data['Item']['release_day_start']);
				$conditions[] = array('and'=>array('Item.release_day >='=>$date));
			}
			if(!empty($this->data['Item']['release_day_end']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data['Item']['release_day_end']);
				$conditions[] = array('and'=>array('Item.release_day <='=>$date));
			}
			if(!empty($this->data['Item']['order_end_day_start']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data['Item']['order_end_day_start']);
				$conditions[] = array('and'=>array('Item.order_end_day >='=>$date));
			}
			if(!empty($this->data['Item']['order_end_day_end']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data['Item']['order_end_day_end']);
				$conditions[] = array('and'=>array('Item.order_end_day <='=>$date));
			}
			if(!empty($this->data['Item']['factory_id']))$conditions[] = array('and'=>array('Item.factory_id'=>$this->data['Item']['factory_id']));
			if(!empty($this->data['Item']['brand_id']))$conditions[] = array('and'=>array('Item.brand_id'=>$this->data['Item']['brand_id']));
			if(!empty($this->data['Item']['sales_state_code_id']))$conditions[] = array('and'=>array('Item.sales_state_code_id'=>$this->data['Item']['sales_state_code_id']));
			if(!empty($this->data['Item']['process_id']))$conditions[] = array('and'=>array('Item.process_id'=>$this->data['Item']['process_id']));
			if(!empty($this->data['Item']['material_id']))$conditions[] = array('and'=>array('Item.material_id'=>$this->data['Item']['material_id']));
			if(!empty($this->data['Item']['stone_id']))$conditions[] = array('and'=>array('Item.stone_id'=>$this->data['Item']['stone_id']));
			if(!empty($this->data['Item']['stock_code']))$conditions[] = array('and'=>array('Item.stock_code'=>$this->data['Item']['stock_code']));
			if(!empty($this->data['Item']['order_approve']))$conditions[] = array('and'=>array('Item.order_approve'=>$this->data['Item']['order_approve']));
			if(!empty($this->data['Item']['cutom_order_approve']))$conditions[] = array('and'=>array('Item.cutom_order_approve'=>$this->data['Item']['cutom_order_approve']));
			if(!empty($this->data['Item']['trans_approve']))$conditions[] = array('and'=>array('Item.trans_approve'=>$this->data['Item']['trans_approve']));
			if(!empty($this->data['Item']['atelier_trans_approve']))$conditions[] = array('and'=>array('Item.atelier_trans_approve'=>$this->data['Item']['atelier_trans_approve']));
			if(!empty($this->data['Item']['percent_code']))$conditions[] = array('and'=>array('Item.percent_code'=>$this->data['Item']['percent_code']));
			if(!empty($this->data['Item']['sales_sum_code']))$conditions[] = array('and'=>array('Item.sales_sum_code'=>$this->data['Item']['sales_sum_code']));
			if(!empty($this->data['Item']['itemproperty']))$conditions[] = array('and'=>array('Item.itemproperty'=>$this->data['Item']['itemproperty']));
			if(!empty($this->data['Item']['itemtype']))$conditions[] = array('and'=>array('Item.itemtype'=>$this->data['Item']['itemtype']));
			$limit = 20;
			$this->Session->write("Item.conditions", $conditions);
			$this->Session->write("Item.search", $this->data['Item']);
		}else{//検索条件無しの場合
			$this->Item->recursive = 0;
			$conditions = array();
			$limit = 20;
			if(empty($this->params['named']['page'])){
				$session_juge = true;
				if(!empty($this->data['Item']['print1'])) $session_juge = false;
				if(!empty($this->data['Item']['print2'])) $session_juge = false;
				if($session_juge) $this->Session->delete("Item");
			}
		}
		if($this->Session->check('Item')){
			$conditions = $this->Session->read('Item.conditions');
			$this->data['Item'] = $this->Session->read('Item.search');
		}

		$stock_code = get_stock_code();
		$order_approve = get_order_approve();
		$cutom_order_approve = get_cutom_order_approve();
		$trans_approve = get_trans_approve();
		$atelier_trans_approve = get_atelier_trans_approve();
		$percent_code = get_percent_code();
		$sales_sum_code = get_sales_sum_code();
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();
		$tags = $this->Item->Tag->find('list');
		$factories = $this->Item->Factory->find('list');
		$brands = $this->Item->Brand->find('list');
		$salesStateCodes = $this->Item->SalesStateCode->find('list');
		$processes = $this->Item->Process->find('list');
		$materials = $this->Item->Material->find('list');
		$stones = $this->Item->Stone->find('list');
		$this->set(compact(
			'tags', 'factories', 'brands', 'salesStateCodes', 'processes', 'materials', 'stones', 'itemproperty', 'itemtype',
			'stock_code', 'order_approve', 'cutom_order_approve', 'trans_approve', 'atelier_trans_approve', 'percent_code', 'sales_sum_code'
		));
		$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>$limit,
				'order'=>array('Item.updated'=>'desc')
			);
		$index_outs = $this->paginate();
		$index_exit = array();
		foreach($index_outs as $index_out){
			$index_out['Factory']['name'] = $this->Cleaning->factoryName($index_out['Factory']['name']);
			$index_out['Factory']['name'] = mb_substr($index_out['Factory']['name'], 0, 8);
			$index_exit[] = $this->ImageSelect->itemImageSelect($index_out);
		}
		$this->set('items', $index_exit);

		if(!empty($this->data['Item']['print1']) or !empty($this->data['Item']['print2'])){
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>600,
				'order'=>array('Item.itemtype,Item.name')
			);
			$index_outs = $this->paginate();
			$index_exit = array();
			foreach($index_outs as $index_out){
				if(!empty($index_out['Item']['trans_approve']))$index_out['Item']['trans_approve'] = $trans_approve[$index_out['Item']['trans_approve']];
				$print_exit[] = $this->ImageSelect->itemImageSelect($index_out);
			}
		}
		unset($print);
		if(!empty($this->data['Item']['print1'])) {
			unset($this->data['Item']['print1']);
			$file_name = 'item6x6-'.date('Ymd-His');
			$mime_type = 'php';
			$path = WWW_ROOT.'/files/print/';
			$print_xml = $this->DateilSeach->printXML($print_exit, $file_name);
			file_put_contents($path.$file_name.'.'.$mime_type, $print_xml);
			$print_out['url'] = 'files/print/'.$file_name.'.'.$mime_type;
			$print_out['file'] = $file_name.'.pxd';
			$this->set('print', $print_out);
		}
		if(!empty($this->data['Item']['print2'])) {
			unset($this->data['Item']['print2']);
			$file_name = 'item2x8-'.date('Ymd-His');
			$mime_type = 'php';
			$path = WWW_ROOT.'/files/print/';
			$print_xml = $this->DateilSeach->print2XML($print_exit, $file_name);
			file_put_contents($path.$file_name.'.'.$mime_type, $print_xml);
			$print_out['url'] = 'files/print/'.$file_name.'.'.$mime_type;
			$print_out['file'] = $file_name.'.pxd';
			$this->set('print2', $print_out);
		}

		if(!empty($this->data['Item']['csv'])){
			$params = array(
				'conditions'=>$conditions,
				'limit'=>5000,
				'order'=>array('Item.created'=>'desc')
			);
			$item_csv = $this->Item->find('all' ,$params);
			$output_csv = $this->OutputCsv->items($item_csv);
			$file_name = 'items_csv'.date('Ymd-His').'.csv';
			$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
			$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output_csv);
			$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
			$output['name'] = $file_name;
			$this->set('csv', $output);
			$this->data['Item']['csv'] = null;
		}

	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Item', true), array('action'=>'index'));
		}
		$stock_code = get_stock_code();
		$unit = get_unit();
		$order_approve = get_order_approve();
		$cutom_order_approve = get_cutom_order_approve();
		$trans_approve = get_trans_approve();
		$atelier_trans_approve = get_atelier_trans_approve();
		$percent_code = get_percent_code();
		$sales_sum_code = get_sales_sum_code();
		$view_data = $this->Item->read(null, $id);
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();
		if(!empty($view_data['Item']['stock_code']))$view_data['Item']['stock_code'] = $stock_code[$view_data['Item']['stock_code']];
		if(!empty($view_data['Item']['unit']))$view_data['Item']['unit'] = $unit[$view_data['Item']['unit']];
		if(!empty($view_data['Item']['order_approve']))$view_data['Item']['order_approve'] = $order_approve[$view_data['Item']['order_approve']];
		if(!empty($view_data['Item']['cutom_order_approve']))$view_data['Item']['cutom_order_approve'] = $cutom_order_approve[$view_data['Item']['cutom_order_approve']];
		if(!empty($view_data['Item']['trans_approve']))$view_data['Item']['trans_approve'] = $trans_approve[$view_data['Item']['trans_approve']];
		if(!empty($view_data['Item']['atelier_trans_approve']))$view_data['Item']['atelier_trans_approve'] = $atelier_trans_approve[$view_data['Item']['atelier_trans_approve']];
		if(!empty($view_data['Item']['percent_code']))$view_data['Item']['percent_code'] = $percent_code[$view_data['Item']['percent_code']];
		if(!empty($view_data['Item']['sales_sum_code']))$view_data['Item']['sales_sum_code'] = $sales_sum_code[$view_data['Item']['sales_sum_code']];
		if(!empty($view_data['Item']['itemproperty']))$view_data['Item']['itemproperty'] = $itemproperty[$view_data['Item']['itemproperty']];
		if(!empty($view_data['Item']['itemtype']))$view_data['Item']['itemtype'] = $itemtype[$view_data['Item']['itemtype']];
		//メイン画像を先頭に持ってくる
		$itemimages = array();
		if(isset($view_data['ItemImage'])){
			foreach($view_data['ItemImage'] as $images){
				if($images['id'] == $view_data['Item']['itemimage_id']){
					array_unshift($itemimages, $images);
				}else{
					$itemimages[] = $images;
				}
			}
		}
		if(isset($itemimages))$this->set('itemimages', $itemimages);
		//Subitemページネーター
		$conditions = array();
		$this->Subitem->recursive = 0;
		$conditions = array('and'=>array('Subitem.item_id'=>$id));
		$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Subitem.name'=>'asc')
			);
		$subitems = $this->paginate('Subitem');
		//pr($subitems);
		//exit;
		foreach($subitems as $key=>$value){
			$params = array(
				'conditions'=>array('Stock.subitem_id'=>$value['Subitem']['id']),
				'recursive'=>0,
				'fields'=>array('Stock.quantity')
			);
			$stocks = $this->Stock->find('all' ,$params);
			$total_qty = 0;
			foreach($stocks as $stock){
				$total_qty = $total_qty + $stock['Stock']['quantity'];
			}
			if($total_qty == 0){
				$subitems[$key]['Subitem']['total_qty'] = 0;
			}else{
				$subitems[$key]['Subitem']['total_qty'] = $total_qty;
			}
		}
		$this->set('subitems', $subitems);
		/*
		foreach($view_data['Subitem'] as $key=>$subitem){
			$params = array(
				'conditions'=>array('Stock.subitem_id'=>$subitem['id']),
				'recursive'=>0,
				'fields'=>array('Stock.quantity')
			);
			$stocks = $this->Stock->find('all' ,$params);
			$total_qty = 0;
			foreach($stocks as $stock){
				$total_qty = $total_qty + $stock['Stock']['quantity'];
			}
			if($total_qty == 0){
				$view_data['Subitem'][$key]['total_qty'] = 0;
			}else{
				$view_data['Subitem'][$key]['total_qty'] = $total_qty;
			}
		}
		*/
		$this->set('item', $view_data);
		//ペア品番のnameをもってくる
		if(!empty($view_data['Item']['pair_id'])){
			$params = array(
				'conditions'=>array('Item.id'=>$view_data['Item']['pair_id']),
				'recursive'=>0,
				'fields'=>array('Item.name')
			);
			$this->set('pair', $this->Item->find('first' ,$params));
		}

	}


	function add() {
		if (!empty($this->data)) {
			$this->data['Item']['name'] = trim($this->data['Item']['name']);
			//$this->data['Item']['name'] = strtoupper($this->data['Item']['name']);
			$this->Item->create();
			if ($this->Item->save($this->data)) {
				$id = $this->Item->getInsertID();
				$this->redirect('/items/view/'.$id);
			} else {
			}
		}
		$stock_code = get_stock_code();
		$unit = get_unit();
		$order_approve = get_order_approve();
		$cutom_order_approve = get_cutom_order_approve();
		$trans_approve = get_trans_approve();
		$atelier_trans_approve = get_atelier_trans_approve();
		$percent_code = get_percent_code();
		$sales_sum_code = get_sales_sum_code();
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();

		$tags = $this->Item->Tag->find('list');
		$factories = $this->Item->Factory->find('list');
		$brands = $this->Item->Brand->find('list');
		$salesStateCodes = $this->Item->SalesStateCode->find('list');
		$processes = $this->Item->Process->find('list');
		$materials = $this->Item->Material->find('list');
		$stones = $this->Item->Stone->find('list');
		$this->set(compact(
			'tags', 'factories', 'brands', 'salesStateCodes', 'processes', 'materials', 'stones', 'itemproperty', 'itemtype',
			'stock_code', 'unit', 'order_approve', 'cutom_order_approve', 'trans_approve', 'atelier_trans_approve', 'percent_code', 'sales_sum_code'
		));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Item', true), array('action'=>'index'));
		}

		if (!empty($this->data['Item']['id'])) {
			if(!empty($this->data['Item']['AutoItemName'])){
				$auto_item_name = trim($this->data['Item']['AutoItemName']);
				//$auto_item_name = strtoupper($auto_item_name);
				$result = $this->Item->find('first', array('conditions'=>array('Item.name'=>$auto_item_name),));
				if($result) $this->data['Item']['pair_id'] = $result['Item']['id'];
			}else{
				$params = array(
					'conditions'=>array('Item.id'=>$id),
					'recursive'=>0,
					'fields'=>array('Item.pair_id')
				);
				$pairid_old = $this->Item->find('first' ,$params);
				$this->data['Item']['pair_id'] = null;
			}
			$this->data['Item']['name'] = trim($this->data['Item']['name']);
			//$this->data['Item']['name'] = strtoupper($this->data['Item']['name']);
			//工賃　+　至急品合計　＝　原価　ただし親品番の　　なにも入っていない場合は無視
			$item_cost = $this->data['Item']['labor_cost'] + $this->data['Item']['supply_full_cost'];
			if($item_cost >= 1){
				$this->data['Item']['cost'] = $item_cost;
			}
			if(!empty($this->data['Tag'])){
				$item_tag = $this->data['Tag'];
			}
			$this->data['Tag'] = array(false);
			if ($this->Item->save($this->data)) {
				if(!empty($this->data['Item']['pair_id'])){
					$pair_data = array('Item'=>array('id'=>$result['Item']['id'], 'pair_id'=>$id));
					$this->Item->save($pair_data, $validate = false, $fieldList = array('pair_id'));
				}
				if(!empty($pairid_old['Item']['pair_id'])){
					$pair_data = array('Item'=>array('id'=>$pairid_old['Item']['pair_id'], 'pair_id'=>null));
					$this->Item->save($pair_data, $validate = false, $fieldList = array('pair_id'));
				}
				if(!empty($item_tag)){
					$this->Item->create();
					$this->data['Tag'] = $item_tag;
					$this->Item->save($this->data);
				}
				$this->redirect('/items/view/'.$id);
			}
		}
		$this->data = $this->Item->read(null, $id);
		$params = array(
			'conditions'=>array('Item.id'=>$this->data['Item']['pair_id']),
			'recursive'=>0,
			'fields'=>array('Item.name')
		);
		$pair_item = $this->Item->find('first' ,$params);
		$params = array(
			'conditions'=>array('ItemImage.item_id'=>$id),
			'recursive'=>0,
			'fields'=>array('ItemImage.id')
		);
		$item_image = $this->ItemImage->find('all' ,$params);

		$stock_code = get_stock_code();
		$unit = get_unit();
		$order_approve = get_order_approve();
		$cutom_order_approve = get_cutom_order_approve();
		$trans_approve = get_trans_approve();
		$atelier_trans_approve = get_atelier_trans_approve();
		$percent_code = get_percent_code();
		$sales_sum_code = get_sales_sum_code();
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();

		$tags = $this->Item->Tag->find('list');
		$factories = $this->Item->Factory->find('list');
		$brands = $this->Item->Brand->find('list');
		$salesStateCodes = $this->Item->SalesStateCode->find('list');
		$processes = $this->Item->Process->find('list');
		$materials = $this->Item->Material->find('list');
		$stones = $this->Item->Stone->find('list');
		$this->set(compact(
			'tags', 'factories', 'brands', 'salesStateCodes', 'processes', 'materials', 'stones', 'item_image', 'pair_item', 'itemproperty', 'itemtype',
			'stock_code', 'unit', 'order_approve', 'cutom_order_approve', 'trans_approve', 'atelier_trans_approve', 'percent_code', 'sales_sum_code'
		));
	}

	function getData(){
		$this->data['OrderDateil']['AutoItemName'] = strtolower($_GET["q"]);
		$this->layout = 'ajax';
		$params = array(
			'conditions'=>array('Item.name LIKE'=>$this->data['Item']['AutoItemName'].'%'),
			'recursive'=>0,
			'limit'=>30,
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

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Item', true), array('action'=>'index'));
		}
		if ($this->Item->del($id) == false) {

			//$this->flash(__('Item deleted', true), array('action'=>'index'));
			$this->redirect('/items/');
		}
	}


	function csv_add(){//初期の商品マスター移行スクリプト
		//ここにdepot_idの口を作って、在庫登録する倉庫を指定できるようにする。
		$this->data['Item']['depot'] = mb_convert_kana($this->data['Item']['depot'], 'a', 'UTF-8');
		$this->data['Item']['depot'] = ereg_replace("[^0-9]", "", $this->data['Item']['depot']);//半角数字以外を削除
		
		if(empty($this->data['Item']['depot'])){
			$depot_id = 910;
		}else{
			//depot_id の存在確認
			$depot_id = $this->data['Item']['depot'];
		}
		$this->data['Item']['depot'] = null;
		$params = array(
			'conditions'=>array('Depot.id'=>$depot_id),
			'recursive'=>-1,
		);
		$results = $this->Depot->find('first', $params);
		if(!$results){
			$this->data['Item']['upload_file']['tmp_name'] = null;
			$this->Session->setFlash('倉庫番号が違います');
		}
		if (!empty($this->data['Item']['upload_file']['tmp_name'])){
			$this->Item->create();
			$file_name = date('Ymd-His').'item.csv';
			rename($this->data['Item']['upload_file']['tmp_name'], WWW_ROOT.'/files/temp/'.$file_name);
			$sj_file_stream = file_get_contents(WWW_ROOT.'/files/temp/'.$file_name);
			$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$sj_rename_opne = fopen(WWW_ROOT.'/files/temp/en'.$file_name, 'w');
			$result = fwrite($sj_rename_opne, $sj_file_stream);
			fclose($sj_rename_opne);
			$sj_opne = fopen(WWW_ROOT.'/files/temp/en'.$file_name, 'r');
			
			if($this->StratCsv->loadSyohinIchiranCsv($sj_opne, $depot_id, $this->data['Item']['stock1'])){
				$this->Session->setFlash(__('たぶん登録がおわりました。確認してみてください。', true));
			}else{
				$this->Session->setFlash('ファイルを間違えています。');
				$this->redirect('/items/csv_add/');
			}
		}
	}



}
?>