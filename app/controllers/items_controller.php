<?php
class ItemsController extends AppController {

	var $name = 'Items';
	var $helpers = array('AddForm',"Javascript","Ajax");
	var $uses = array('Item', 'User', 'ItemImage', 'TagsItem', 'Subitem', 'Stock', 'Itembase');
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
			$this->data['Item']['name'] = strtoupper($this->data['Item']['name']);
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
				$auto_item_name = strtoupper($auto_item_name);
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
			$this->data['Item']['name'] = strtoupper($this->data['Item']['name']);
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
		$this->layout = 'ajax';
		$params = array(
			'conditions'=>array('Item.name LIKE'=>'%'.$this->data['Item']['AutoItemName'].'%'),
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
		if (!empty($this->data)) {
			$this->Item->create();
			$file_name = date('Ymd-His').'item.csv';
			rename($this->data['Item']['upload_file']['tmp_name'], WWW_ROOT.'/files/temp/'.$file_name);
			$sj_file_stream = file_get_contents(WWW_ROOT.'/files/temp/'.$file_name);
			$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$sj_rename_opne = fopen(WWW_ROOT.'/files/temp/en'.$file_name, 'w');
			$result = fwrite($sj_rename_opne, $sj_file_stream);
			fclose($sj_rename_opne);
			$sj_opne = fopen(WWW_ROOT.'/files/temp/en'.$file_name, 'r');
			$csv_header = fgetcsv($sj_opne);
			$starter = true;
			if(trim($csv_header[0]) != '商品CD') $starter = false;
			if(trim($csv_header[1]) != '品名') $starter = false;
			if(trim($csv_header[2]) != '規格') $starter = false;
			if(trim($csv_header[3]) != '型番') $starter = false;
			if(trim($csv_header[4]) != 'サイズCD') $starter = false;
			if(trim($csv_header[5]) != 'サイズ記号') $starter = false;
			if(trim($csv_header[6]) != 'メーカ型番') $starter = false;
			if(trim($csv_header[7]) != '鑑定') $starter = false;
			if(trim($csv_header[8]) != '鑑別') $starter = false;
			if(trim($csv_header[9]) != '分類') $starter = false;
			if(trim($csv_header[10]) != '分類名') $starter = false;
			if(trim($csv_header[11]) != '石') $starter = false;
			if(trim($csv_header[12]) != '石名') $starter = false;
			if(trim($csv_header[13]) != '枠素材') $starter = false;
			if(trim($csv_header[14]) != '枠素材名') $starter = false;
			if(trim($csv_header[15]) != 'カラット') $starter = false;
			if($starter == false){
				$this->Session->setFlash('ファイルを間違えています。');
				$this->redirect('/items/csv_add/');
			}
			/*
			$itembase_file_stream = file_get_contents(WWW_ROOT.'/files/temp/itembase-original.csv');
			$itembase_file_stream = mb_convert_encoding($itembase_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$itembase_opne_stream = fopen(WWW_ROOT.'/files/temp/en-itembase-original.csv', 'w');
			$result = fwrite($itembase_opne_stream, $itembase_file_stream);
			fclose($itembase_opne_stream);

			$itembase_stream = fopen(WWW_ROOT.'/files/temp/en-itembase-original.csv', 'r');
			$csv_header = fgetcsv($itembase_stream);
			$item_base = array();
			while($itembase_row = fgetcsv($itembase_stream)){
				$item_base[] = $itembase_row;
			}
			*/
			
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
				$subitem_major_size = $this->StratCsv->baseMajorSize(trim($sj_row[5]));
				if($subitem_major_size == 'other'){
					$subitem_minority_size = trim($sj_row[5]);
				}
					//$pre_sj10 = mb_convert_kana($sj_row[10], 'K', 'UTF-8');
				//$tags[] = $this->StratCsv->masterDump('Tag', $pre_sj10);//タグのid
				$subitem_name_kana = $sj_row[12];//ルース名　半角カナ　subitemに入れる
					$sj12_zen = mb_convert_kana($subitem_name_kana, 'K', 'UTF-8');
				$item_stone_id = $this->StratCsv->masterDump('Stone', $sj12_zen);//ルースのid
				$item_material_id = $this->StratCsv->masterDump('Material', $sj_row[14]);//マテリアルのid
				$item_price = floor($sj_row[26]);//上代 切捨て整数化floor
				$subitem_cost = floor($sj_row[29]);//仕入単価
				$item_cost = floor($sj_row[32]);//在庫原価
				if($subitem_cost == 0) $subitem_cost = $item_cost;
					if(!empty($sj_row[36])){
						$pre_sj36 = mb_convert_kana($sj_row[36], 'K', 'UTF-8');
					}else{
						$pre_sj36 = '';
					}
				$item_factory_id = $this->StratCsv->masterDump('Factory', $pre_sj36);//工場のid
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

				$item_brand_id = $this->StratCsv->masterDump('Brand', $sj_row[73]);//ブランドのid
				//$subitem_name = $this->StratCsv->sjSubItemName($sj_row[4], $item_name);
				$subitem_name = $this->StratCsv->sjSubItemName($subitem_sub_name, $item_name);
				//$subitem_name = $item_name.'-'.$subitem_sub_name;//subitemの品番
				$params = array(
					'conditions'=>array('Item.name'=>$item_name),
					'recursive'=>0
				);
				$find_item = $this->Item->find('first' ,$params);
				if($find_item){//あったときの処理　次にsubitemを探す
					$item_id = $find_item['Item']['id'];
					$params = array(
						'conditions'=>array('Subitem.jan'=>$subitem_jan),
						'recursive'=>0
					);
					$find_subitem = $this->Subitem->find('first' ,$params);
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
						$this->Subitem->save($save_subitem);
						$subitem_id = $this->Subitem->getInsertID();
						if($find_item['Item']['stock_code'] == '3'){
							$this->Stock->Plus($subitem_id, 910, 1, 1135, 1);
						}
						$this->Subitem->id = null;
					}

				}else{//itemが無かった時の処理
					//アニバ、ファサード、カフナ、LUVは単品管理に変える
					if($item_brand_id == 10 or $item_brand_id == 11 or $item_brand_id == 12 or $item_brand_id == 3 or $item_brand_id == 4 or $item_brand_id == 13){
						$stock_code = 3;
					}else{
						$stock_code = 1;
					}
					$params = array(
						'conditions'=>array('Itembase.itemnum'=>$item_name),
						'recursive'=>0
					);
					$Itembase = $this->Itembase->find('first' ,$params);
					if($Itembase){
						$item_release_day = $this->StratCsv->baseRelease($Itembase['Itembase']['release']);//リリース日
						$itemtype = $this->StratCsv->baseItemType($Itembase['Itembase']['item_type']);//アイテムタイプ
						$itemproperty = $this->StratCsv->baseSex($Itembase['Itembase']['sex']);//性別
							//$separater = $this->StratCsv->baseSeparateProcess($base[8]);//M or P マテリアルかプロセスかを振り分ける。企画倒れ
						$item_process_id = $this->StratCsv->baseProcess($Itembase['Itembase']['process']);//プロセスのid　マテリアル無視　無い場合は''
						if(!empty($Itembase['Itembase']['other_process'])) $item_remark .= $Itembase['Itembase']['other_process'];
						if(!empty($Itembase['Itembase']['other_loose'])) $item_stone_other = $Itembase['Itembase']['other_loose'];
						if(!empty($Itembase['Itembase']['loose_spec'])) $item_stone_spec = $Itembase['Itembase']['loose_spec'];
						if(!empty($Itembase['Itembase']['messeage'])) $item_message_stamp = $Itembase['Itembase']['messeage'];
						if(!empty($Itembase['Itembase']['trans'])) $item_message_stamp_ja = $Itembase['Itembase']['trans'];
						$basic_size = $this->StratCsv->baseBasicSize($Itembase['Itembase']['basic_size']);
						$order_size = $this->StratCsv->baseOrderSize($Itembase['Itembase']['order_size']);
						$item_trans_approve = $this->StratCsv->baseTransApprove($Itembase['Itembase']['repair_size']);
						$item_in_chain = $this->StratCsv->baseInChain($Itembase['Itembase']['chain'], $Itembase['Itembase']['other_chain']);//チェーン品番または工場名が入る。無い場合は空値''。
						$item_sales_state_code = $this->StratCsv->baseSalesStateCode($Itembase['Itembase']['ado']);//ado　販売状況salesStateCodeのid
						if(!empty($Itembase['Itembase']['remark'])) $item_remark .= $Itembase['Itembase']['remark'];//リマーク追加
						$item_atelier_trans_approve = $this->StratCsv->baseAtelierTransApprove($Itembase['Itembase']['atelier_repair_size']);
						if(!empty($Itembase['Itembase']['secret_remark'])) $item_secret_remark .= $Itembase['Itembase']['secret_remark'];//シークレットリマーク
						$item_unit = $this->StratCsv->baseUnit($Itembase['Itembase']['unit']);//寸法基準のid
						if(!empty($Itembase['Itembase']['weight'])) $item_weight = $Itembase['Itembase']['weight'];
						if(!empty($Itembase['Itembase']['spec'])) $item_demension = $Itembase['Itembase']['spec'];
						$save_item = array('Item'=>array(
							'name'=>$item_name,
							'stone_id'=>$item_stone_id,
							'material_id'=>$item_material_id,
							'price'=>$item_price,
							'cost'=>$item_cost,
							'factory_id'=>$item_factory_id,
							'brand_id'=>$item_brand_id,
							'release_day'=>$item_release_day,
							'process_id'=>$item_process_id,
							'remark'=>$item_remark,
							'stone_other'=>$item_stone_other,
							'stone_spec'=>$item_stone_spec,
							'message_stamp'=>$item_message_stamp,
							'message_stamp_ja'=>$item_message_stamp_ja,
							'trans_approve'=>$item_trans_approve,
							'in_chain'=>$item_in_chain,
							'sales_state_code_id'=>$item_sales_state_code,
							'atelier_trans_approve'=>$item_atelier_trans_approve,
							'secret_remark'=>$item_secret_remark,
							'unit'=>$item_unit,
							'weight'=>$item_weight,
							'demension'=>$item_demension,
							'title'=>$item_title,
							'itemtype'=>$itemtype,
							'itemproperty'=>$itemproperty,
							'basic_size'=>$basic_size,
							'order_size'=>$order_size,
							'stock_code'=>$stock_code,
						));
						$this->Item->save($save_item);
						$item_id = $this->Item->getInsertID();
						$this->Item->id = null;
					}else{
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
					$this->Item->save($save_item);
					$item_id = $this->Item->getInsertID();
					$this->Item->id = null;
					}
					//$result = fopen(WWW_ROOT.'/img/itemimage-old/'.$item_name.'.jpg', 'r');
					if(@fopen(WWW_ROOT.'/img/itemimage-old/'.$item_name.'.jpg', 'r')){
						$save_item_image = array('ItemImage'=>array(
							'item_id'=>$item_id,
						));
						$this->ItemImage->save($save_item_image);
						$item_image_id = $this->ItemImage->getInsertID();
						copy(WWW_ROOT.'/img/itemimage-old/'.$item_name.'.jpg' , WWW_ROOT.'/img/itemimage/'.$item_image_id.'.jpg');
						//fclose($result);
						$this->ItemImage->id = null;
					}
					$save_subitem = array('Subitem'=>array(
						'name'=>$subitem_name,
						'item_id'=>$item_id,
						'major_size'=>$subitem_major_size,
						'minority_size'=>$subitem_minority_size,
						'name_kana'=>$subitem_name_kana,
						'jan'=>$subitem_jan,
						'cost'=>$subitem_cost,
					));
					$this->Subitem->save($save_subitem);
					$subitem_id = $this->Subitem->getInsertID();
					if($stock_code == '3'){
						$this->Stock->Plus($subitem_id, 910, 1, 1135, 1);
					}
					$this->Subitem->id = null;
				}
			}//csv while終わり
			$this->Session->setFlash(__('たぶん登録がおわりました。確認してみてください。', true));
		}
	}



}
?>