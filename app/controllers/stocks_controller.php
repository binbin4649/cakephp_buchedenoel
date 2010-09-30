<?php
class StocksController extends AppController {

	var $name = 'Stocks';
	var $uses = array('Stock', 'Subitem', 'Depot', 'Section', 'Item');
	var $components = array('OutputCsv');

	function index($ac = null, $id = null) {
		if($ac != null and $id != null) $this->Session->delete("Stock");
		$subitem_name = null;
		$depot_name = null;
		$conditions = array();
		$contain_conditions = array();
		if($ac == 'reset'){
			$this->Session->delete("Stock");
		}
		if(!empty($this->data)){
			//ブランド検索と部門検索を追加
			$subitem_name = trim($this->data['Stock']['subitem_name']);
			$depot_name = trim($this->data['Stock']['depot_name']);
			$depot_id = mb_convert_kana($this->data['Stock']['depot_id'], 'a', 'UTF-8');
			$depot_id = ereg_replace("[^0-9]", "", $depot_id);//半角数字以外を削除
			$this->data['Stock']['depot_id'] = $depot_id;
			$item_id = mb_convert_kana($this->data['Stock']['item_id'], 'a', 'UTF-8');
			$item_id = ereg_replace("[^0-9]", "", $item_id);//半角数字以外を削除
			$this->data['Stock']['item_id'] = $item_id;
			$subitem_jan = mb_convert_kana($this->data['Stock']['subitem_jan'], 'a', 'UTF-8');
			$subitem_jan = ereg_replace("[^0-9]", "", $subitem_jan);//半角数字以外を削除
			$this->data['Stock']['subitem_jan'] = $subitem_jan;
			$section_id = mb_convert_kana($this->data['Stock']['section_id'], 'a', 'UTF-8');
			$section_id = ereg_replace("[^0-9]", "", $section_id);//半角数字以外を削除
			$this->data['Stock']['section_id'] = $section_id;
			
			$old_system_no = mb_convert_kana($this->data['Stock']['old_system_no'], 'a', 'UTF-8');
			$old_system_no = ereg_replace("[^0-9]", "", $old_system_no);//半角数字以外を削除
			$this->data['Stock']['old_system_no'] = $old_system_no;
			
			$brand_id = $this->data['Stock']['brand_id'];
		}elseif($this->Session->check('Stock')){
			$this->data = $this->Session->read('Stock');
			$subitem_name = trim($this->data['Stock']['subitem_name']);
			$depot_name = trim($this->data['Stock']['depot_name']);
			$depot_id = mb_convert_kana($this->data['Stock']['depot_id'], 'a', 'UTF-8');
			$depot_id = ereg_replace("[^0-9]", "", $depot_id);//半角数字以外を削除
			$this->data['Stock']['depot_id'] = $depot_id;
			$item_id = mb_convert_kana($this->data['Stock']['item_id'], 'a', 'UTF-8');
			$item_id = ereg_replace("[^0-9]", "", $item_id);//半角数字以外を削除
			$this->data['Stock']['item_id'] = $item_id;
			$subitem_jan = mb_convert_kana($this->data['Stock']['subitem_jan'], 'a', 'UTF-8');
			$subitem_jan = ereg_replace("[^0-9]", "", $subitem_jan);//半角数字以外を削除
			$this->data['Stock']['subitem_jan'] = $subitem_jan;
		}else{
			$this->Session->delete("Stock");
		}
		if(!empty($subitem_name) or !empty($depot_name) or !empty($depot_id) or !empty($item_id) or !empty($subitem_jan) or !empty($section_id) or !empty($brand_id) or !empty($old_system_no)){
			if(!empty($subitem_name)) $conditions[] = array('Subitem.name LIKE'=>'%'.$subitem_name.'%');
			if(!empty($item_id)) $conditions[] = array('Subitem.item_id'=>$item_id);
			if(!empty($subitem_jan)) $conditions[] = array('Subitem.jan'=>$subitem_jan);
			if(!empty($depot_name)) $conditions[] = array('Depot.name LIKE'=>'%'.$depot_name.'%');
			if(!empty($depot_id)) $conditions[] = array('Depot.id'=>$depot_id);
			if(!empty($section_id)) $conditions[] = array('Depot.section_id'=>$section_id);
			if(!empty($old_system_no)) $conditions[] = array('Depot.old_system_no'=>$old_system_no);
			if(!empty($brand_id)) $conditions['or'] = $this->Item->brandItemQuery($brand_id);
			$this->Session->write("Stock", $this->data);
		}else{
			$this->Session->delete("Stock");
			if(!empty($this->data['Stock']['ac'])){
				$ac = $this->data['Stock']['ac'];
				$id = $this->data['Stock']['id_ex'];
			}
		}
		//$this->Stock->recursive = 0;
		if($ac == 'depot' and $id != null){
			$conditions = array('Stock.depot_id'=>$id);
			$params = array(
				'conditions'=>array('Depot.id'=>$id),
				'recursive'=>0
			);
			$depot = $this->Depot->find('first' ,$params);
			$this->set('depot', $depot);
		}

		if($ac == 'subitem' and $id != null){
			$conditions = array('Stock.subitem_id'=>$id);
			$params = array(
				'conditions'=>array('Subitem.id'=>$id),
				'recursive'=>0
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$this->set('subitem', $subitem);
		}
		
		$conditions[] = array('Stock.quantity >'=>0);
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>50,
			'order'=>array('Stock.updated'=>'desc'),
			'recursive'=>2,
			'contain'=>array('Depot', 'Subitem.Item'),
			/*
			'joins'=>array(array(
				'type'=>'LEFT',
				'alias'=>'Subitem',
				'table'=>'subitems',
				'conditions'=>'Stock.subitem_id = Subitem.id',
			),array(
				'type'=>'LEFT',
				'alias'=>'Item',
				'table'=>'items',
				'conditions'=>'Subitem.item_id = Item.id',
			
			)),
			*/
		);
		/*
		$this->paginate->bindModel(array('belongsTo' => array('Subitem' => array(
				'className' => 'Subitem',
				'foreignKey' => 'subitem_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
				)
		)));
		*/
		$stocks = $this->paginate();
		$this->set('stocks', $stocks);
		$this->set('brands', $this->Item->Brand->find('list'));
		if(empty($this->data['Stock']['csv'])) $this->data['Stock']['csv'] = 0;
		if($this->data['Stock']['csv'] == 1){
			$params = array(
				'conditions'=>$conditions,
				'recursive'=>2,
				'limit'=>8000,
				'contain'=>array('Depot', 'Subitem.Item'),
			);
			$stocks = $this->Stock->find('all' ,$params);
			$output_csv = $this->OutputCsv->stocks($stocks);
			$file_name = 'stock_csv'.date('Ymd-His').'.csv';
			$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
			$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output_csv);
			$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
			$output['name'] = $file_name;
			$this->set('csv', $output);
			$this->data['Stock']['csv'] = null;
		}
	}
	
	//親品番検索
	function item_index($item_id = null, $ac = null, $ac2 = null){
		if($item_id == null){
			$this->redirect(array('controller'=>'items', 'action'=>'index'));
		}else{
			$item['name'] = $this->Item->itemName($item_id);
			$item['id'] = $item_id;
			$this->set('item', $item);
			if($ac == 'not_defa'){
				$item_stocks = $this->Stock->ItemStocks($item_id);
				$this->set('depo', 'not_defa');
			}
			if($ac == 'all'){
				$item_stocks = $this->Stock->ItemStocksAll($item_id);
				$this->set('depo', 'all');
			}
			if($ac == null or $ac == 'defa'){
				$item_stocks = $this->Stock->ItemStocksDefault($item_id);
				$this->set('depo', 'defa');
			}
			if($ac2 == 'csv'){
				$output_csv = $this->OutputCsv->item_stocks($item_stocks, $item);
				$file_name = $item['id'].'-'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
			}
			$this->set('item_stocks', $item_stocks);
			$this->set('major_size', get_major_size());
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Stock.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('stock', $this->Stock->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Stock->create();
			if ($this->Stock->save($this->data)) {
				$this->Session->setFlash(__('The Stock has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Stock could not be saved. Please, try again.', true));
			}
		}
		$subitems = $this->Stock->Subitem->find('list');
		$depots = $this->Stock->Depot->find('list');
		$this->set(compact('subitems', 'depots'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Stock', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Stock->save($this->data)) {
				$this->Session->setFlash(__('The Stock has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Stock could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Stock->read(null, $id);
		}
		$subitems = $this->Stock->Subitem->find('list');
		$depots = $this->Stock->Depot->find('list');
		$this->set(compact('subitems','depots'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Stock', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Stock->del($id)) {
			$this->Session->setFlash(__('Stock deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	//在庫移動プログラム　旧　→　新
	function csv_add(){
		if (!empty($this->data)) {
			$is_depot = false;
			$depot_old_no = mb_convert_kana($this->data['Stock']['depot'], 'a', 'UTF-8');
			$depot_old_no = ereg_replace("[^0-9]", "", $depot_old_no);//半角数字以外を削除
			$params = array(
				'conditions'=>array('Depot.old_system_no'=>$depot_old_no),
				'recursive'=>0
			);
			$is_depot = $this->Depot->find('first' ,$params);
			if($is_depot){
				$this->Stock->create();
				$file_name = date('Ymd-His').'stock.csv';
				rename($this->data['Stock']['upload_file']['tmp_name'], WWW_ROOT.'/files/temp/'.$file_name);
				$sj_file_stream = file_get_contents(WWW_ROOT.'/files/temp/'.$file_name);
				$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
				$sj_rename_opne = fopen(WWW_ROOT.'/files/temp/en'.$file_name, 'w');
				$result = fwrite($sj_rename_opne, $sj_file_stream);
				fclose($sj_rename_opne);
				$sj_opne = fopen(WWW_ROOT.'/files/temp/en'.$file_name, 'r');
				$csv_header = fgetcsv($sj_opne);
				while($sj_row = fgetcsv($sj_opne)){
					$params = array(
						'conditions'=>array('Subitem.jan'=>$sj_row[8]),
						'recursive'=>0
					);
					$subitem = $this->Subitem->find('first' ,$params);
					if(!$subitem){//なかった場合
						$params = array(
							'conditions'=>array('Item.name'=>$sj_row[0]),
							'recursive'=>0
						);
						$item = $this->Item->find('first' ,$params);
						if(!$item){//なかった場合
							$item = $this->Item->NewItem($sj_row[0], $sj_row[7], $sj_row[5]);
						}
						$subitem = $this->Subitem->NewSubitem($item['Item']['id'], $sj_row[3], $sj_row[8], $sj_row[0]);
					}
					$qty = floor($sj_row[10]);
					$this->Stock->Plus($subitem['Subitem']['id'], $is_depot['Depot']['id'], $qty, 1135, 2);
				}
			}else{//倉庫が無かったら
				$this->Session->setFlash('半角数字倉庫がありません。販売管理システムの倉庫番号を半角数字で入力してください');
				$this->redirect(array('action'=>'csv_add'));
			}
		}
	}


}
?>