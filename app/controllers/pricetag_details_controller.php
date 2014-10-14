<?php
class PricetagDetailsController extends AppController {

	var $name = 'PricetagDetails';
	var $helpers = array("Javascript", "Ajax");
	var $uses = array('PricetagDetail', 'Subitem', 'User', 'Depot', 'Pricetag', 'Item');
	var $components = array('OutputCsv', 'Selector');

	function add($ac = null, $id = null) {
		$total_quantity = 0;
		if(@$this->data['PricetagDetail']['step'] == '1') {
			$params = array(
				'conditions'=>array('Item.name'=>$this->data['PricetagDetail']['AutoItemName']),
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
				$params = array(
					'conditions'=>array('User.id'=>$this->Auth->user('id')),
					'recursive'=>0,
				);
				$user = $this->User->find('first' ,$params);
				$this->set('user', $user);
			}else{
				$this->Session->setFlash(__('品番は正確に入力してください。', true));
			}
		}
		if(@$this->data['PricetagDetail']['step'] == '2') {
			$subitems = array_keys($this->data['subitem']);
			//pr($subitems);
			foreach($subitems as $subitem_id){
				if($this->data['subitem'][$subitem_id] > 0){
					$params = array(
						'conditions'=>array('Subitem.id'=>$subitem_id),
						'recursive'=>0
					);
					$subitem = $this->Subitem->find('first' ,$params);
					$session_write['Subitem']['id'] =  $subitem['Subitem']['id'];
					$session_write['Subitem']['name'] =  $subitem['Subitem']['name'];
					$session_write['Subitem']['quantity'] = $this->data['subitem'][$subitem_id];
					$session_write['Subitem']['major_size'] = $subitem['Subitem']['major_size'];
					$session_write['Subitem']['minority_size'] = $subitem['Subitem']['minority_size'];
					$session_write['Subitem']['jan'] = $subitem['Subitem']['jan'];
					$session_write['Item']['id'] =  $subitem['Subitem']['item_id'];
					$session_write['Item']['name'] =  $this->data['Item']['name'];
					$session_write['Item']['price'] =  $this->data['Item']['price'];
					$session_write['Section']['id'] =  $this->data['Section']['id'];
					$session_write['Factory']['name'] =  $this->data['Factory']['name'];
					$session_write['Factory']['id'] =  $this->data['Factory']['id'];
					$this->Session->write("PricetagDetail.".$subitem['Subitem']['id'], $session_write);
				}
			}
		}
		if($this->Session->check('PricetagDetail')){
			$details = array();
			$session_read = $this->Session->read('PricetagDetail');
			if($ac == 'del'){
				/*
				$params = array(
					'conditions'=>array('Subitem.id'=>$id),
					'recursive'=>0,
					'fields'=>array('Subitem.name')
				);
				$del_subitem = $this->Subitem->find('first' ,$params);
				$this->Session->delete("PricetagDetail.".$del_subitem['Subitem']['name']);
				unset($session_read[$del_subitem['Subitem']['name']]);
				*/
				$this->Session->delete("PricetagDetail.".$id);
				unset($session_read[$id]);
			}
			if($ac == 'alldel'){
				$this->Session->delete("PricetagDetail");
				$session_read = array();
			}
			if($ac == 'csv'){
				$i = 0;
				foreach($session_read as $value){
					$params = array(
						'conditions'=>array('Subitem.id'=>$value['Subitem']['id']),
						'recursive'=>0
					);
					$subitem = $this->Subitem->find('first' ,$params);
					$Pricetags['PricetagDetail'][$i]['Subitem']['jan'] = $subitem['Subitem']['jan'];
					$Pricetags['PricetagDetail'][$i]['Subitem']['major_size'] = $subitem['Subitem']['major_size'];
					$Pricetags['PricetagDetail'][$i]['Subitem']['minority_size'] = $subitem['Subitem']['minority_size'];
					$Pricetags['PricetagDetail'][$i]['Subitem']['name'] = $subitem['Subitem']['name'];
					$Pricetags['PricetagDetail'][$i]['Subitem']['name_kana'] = $subitem['Subitem']['name_kana'];
					$Pricetags['PricetagDetail'][$i]['Subitem']['item_id'] = $value['Item']['id'];
					$Pricetags['PricetagDetail'][$i]['quantity'] = $value['Subitem']['quantity'];
					$i++;
				}
				$output_csv = $this->OutputCsv->priceTag($Pricetags);
				$user_id = $this->Auth->user('id');
				$file_name = 'tag-'.$user_id.'-'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/pricetagcsv/';
				$out = '';
				foreach($output_csv as $output){
					$out .= $output."\r\n";
				}
				$out = mb_convert_encoding($out, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $out);
				$print_out['url'] = '/'.SITE_DIR.'/files/pricetagcsv/'.$file_name;
				$print_out['file'] = $file_name;
				$this->set('print', $print_out);
				$this->Session->delete("PricetagDetail");
				$session_read = array();
			}

			if($ac == 'ordering'){
				$Pricetag = array();
				$PricetagDetail = array();
				foreach($session_read as $key=>$value){
					//section_id が無い場合はリダイレクト
					if(empty($value['Section']['id'])){
						$this->Session->delete("PricetagDetail");
						$this->Session->setFlash(__('所属部門を見直して、やり直してください。', true));
						$this->redirect(array('controller'=>'pricetag_details', 'action'=>'add'));
					}
					$Pricetag = array();
					$PricetagDetail = array();
					$params = array(
						'conditions'=>array('and'=>array(
							'Pricetag.section_id'=>$value['Section']['id'],
							'Pricetag.pricetag_status'=>1
						)),
						'recursive'=>0
					);
					$Pricetag = $this->Pricetag->find('first' ,$params);
					if($Pricetag == false){
						$Pricetag['Pricetag']['pricetag_status'] = 1;
						$Pricetag['Pricetag']['section_id'] = $value['Section']['id'];
						$Pricetag['Pricetag']['created_user'] = $this->Auth->user('id');
						$this->Pricetag->save($Pricetag);
						$Pricetag['Pricetag']['id'] = $this->Pricetag->getInsertID();
						$this->Pricetag->id = null;
					}
					$PricetagDetail['PricetagDetail']['pricetag_id'] = $Pricetag['Pricetag']['id'];
					$PricetagDetail['PricetagDetail']['subitem_id'] = $value['Subitem']['id'];
					$PricetagDetail['PricetagDetail']['quantity'] = $value['Subitem']['quantity'];
					$PricetagDetail['PricetagDetail']['created_user'] = $this->Auth->user('id');
					$this->PricetagDetail->save($PricetagDetail);
					$this->PricetagDetail->id = null;
				}
				$this->Session->delete("PricetagDetail");
				$this->redirect(array('controller'=>'pricetags', 'action'=>'index'));
			}
			foreach($session_read as $ki=>$val){
				$size = $this->Selector->sizeSelector($val['Subitem']['major_size'], $val['Subitem']['minority_size']);
				$session_read[$ki]['Subitem']['size'] = $size;
			}
			$this->set('details', $session_read);
		}
	}

	function getData(){
		$this->data['OrderDateil']['AutoItemName'] = strtolower($_GET["q"]);
		$this->layout = 'ajax';
		$params = array(
			'conditions'=>array('Item.name LIKE'=>$this->data['PricetagDetail']['AutoItemName'].'%'),
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

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PricetagDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data['PricetagDetail']['id'])) {
			if ($this->PricetagDetail->save($this->data)) {
				$this->Session->setFlash(__('The PricetagDetail has been saved', true));
				$this->redirect(array('controller'=>'Pricetag','action'=>'view', $this->data['PricetagDetail']['pricetag_id']));
			} else {
				$this->Session->setFlash(__('The PricetagDetail could not be saved. Please, try again.', true));
			}
		}
		$this->data = $this->PricetagDetail->read(null, $id);
		$depots = $this->Depot->find('list');
		$this->set(compact('depots'));
	}

	function csv($id = null){
		$params = array(
			'conditions'=>array('Pricetag.id'=>$id),
			'recursive'=>2,
		);
		$total_qty = 0;
		$Pricetag = $this->Pricetag->find('first' ,$params);
		foreach($Pricetag['PricetagDetail'] as $detail){
			$total_qty = $total_qty + $detail['quantity'];
		}

		$output_csv = $this->OutputCsv->priceTag($Pricetag);
		$file_name = 'tag-'.$Pricetag['Pricetag']['section_id'].'-'.$id.'-'.date('Ymd-His').'.csv';
		$path = WWW_ROOT.'/files/pricetag/';
		file_put_contents($path.$file_name, $output_csv);
		$Pricetag['Pricetag']['id'] = $id;
		$Pricetag['Pricetag']['pricetag_status'] = 2;
		$Pricetag['Pricetag']['total_quantity'] = $total_qty;
		$Pricetag['Pricetag']['updated_user'] = $this->Auth->user('id');
		$Pricetag['Pricetag']['csv_data'] = $file_name;
		$this->Pricetag->save($Pricetag);
		$this->redirect(array('action'=>'view', $id));
	}

}
?>