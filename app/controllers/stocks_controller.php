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
		if($ac == 'reset'){
			$this->Session->delete("Stock");
		}
		if(!empty($this->data)){
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
		if(!empty($subitem_name) or !empty($depot_name) or !empty($depot_id) or !empty($item_id) or !empty($subitem_jan)){			
			if(!empty($subitem_name)) $conditions[] = array('Subitem.name LIKE'=>'%'.$subitem_name.'%');
			if(!empty($item_id)) $conditions[] = array('Subitem.item_id'=>$item_id);
			if(!empty($subitem_jan)) $conditions[] = array('Subitem.jan'=>$subitem_jan);
			if(!empty($depot_name)) $conditions[] = array('Depot.name LIKE'=>'%'.$depot_name.'%');
			if(!empty($depot_id)) $conditions[] = array('Depot.id'=>$depot_id);
			$this->Session->write("Stock", $this->data);
		}else{
			$this->Session->delete("Stock");
			if(!empty($this->data['Stock']['ac'])){
				$ac = $this->data['Stock']['ac'];
				$id = $this->data['Stock']['id_ex'];
			}
		}
		$this->Stock->recursive = 0;
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
		
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>50,
			'order'=>array('Stock.updated'=>'desc')
		);
		
		$this->set('stocks', $this->paginate());
		if(empty($this->data['Stock']['csv'])) $this->data['Stock']['csv'] = 0;
		if($this->data['Stock']['csv'] == 1){
			$params = array(
				'conditions'=>$conditions,
				'recursive'=>0,
				'limit'=>5000
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
	function item_index($item_id = null){
		if($item_id == null){
			$this->redirect(array('controller'=>'items', 'action'=>'index'));
		}else{
			$item['name'] = $this->Item->itemName($item_id);
			$item['id'] = $item_id;
			$this->set('item', $item);
			$item_stocks = $this->Stock->ItemStocks($item_id);
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